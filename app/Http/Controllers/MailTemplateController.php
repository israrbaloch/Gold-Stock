<?php

namespace App\Http\Controllers;

use App\Mail\BlogsMail;
use App\Mail\NewsMail;
use App\Mail\Promotions\PromoMail;
use App\Models\Blog;
use App\Models\HomeNew;
use App\Models\MailTemplate;
use App\Models\MailTemplateProperty;
use App\Models\Product;
use Illuminate\Http\Request;
use Log;
use ReflectionClass;

class MailTemplateController extends Controller {

    private static $availableTemplates = [
        PromoMail::class,
        BlogsMail::class,
        NewsMail::class,
    ];

    public function index() {
        if (auth()->user()) {
            $mailTemplates = MailTemplate::orderBy('id', 'desc')
                ->paginate(100);
            $mailTemplatesNames = [];
            foreach (self::$availableTemplates as $template) {
                $mailTemplatesNames[] = [
                    'template' => $template,
                    'name' => app($template)->_name,
                ];
            }
            return view('admin.mails.list')
                ->with('mailTemplates', $mailTemplates)
                ->with('mailTemplatesNames', $mailTemplatesNames);
        } else {
            return redirect("/admin/login");
        }
    }

    public function getCreateView() {
        if (auth()->user()) {
            $availableTemplates = [];
            foreach (self::$availableTemplates as $template) {
                $availableTemplates[] = app($template);
            }

            $templateProperties = [];
            foreach ($availableTemplates as $template) {
                $reflectionClass = new ReflectionClass(get_class($template));
                $_properties = $reflectionClass->getProperties();
                $properties = [];

                foreach ($_properties as $_property) {
                    $_property->setAccessible(true);
                    $type = $_property->getType();
                    if ($type) {
                        if (strpos($_property->getName(), '_') !== 0) {
                            $properties[] = [
                                'name' => $_property->getName(),
                                'type' => $type->getName(),
                            ];
                        }
                    }
                }
                $templateProperties[] = $properties;
            }

            Log::info($availableTemplates);
            return view('admin.mails.create')
                ->with('templates', $availableTemplates)
                ->with('templateProperties', $templateProperties);
        } else {
            return redirect("/admin/login");
        }
    }

    public function create(Request $request) {
        if (auth()->user()) {
            $request->validate([
                'subject' => 'required',
                'template' => 'required|integer',
                'subscription' => 'required',
            ]);

            $mail = new MailTemplate;
            $mail->subject = $request->subject;
            $mail->subscription = $request->subscription;
            $template = app(self::$availableTemplates[$request->template]);
            $mail->template = get_class($template);
            $mail->save();

            $mailTemplateProperties = $request->properties;
            foreach ($mailTemplateProperties as $mailTemplateProperty) {
                if (array_key_exists('value', $mailTemplateProperty)) {
                    $_mailTemplateProperty = new MailTemplateProperty;
                    $_mailTemplateProperty->mail_template_id = $mail->id;
                    $_mailTemplateProperty->name = $mailTemplateProperty['name'];
                    $_mailTemplateProperty->value = $mailTemplateProperty['value'];
                    $_mailTemplateProperty->type = $mailTemplateProperty['type'];
                    $_mailTemplateProperty->save();
                }
            }
            Log::info($mailTemplateProperties);
            return redirect("/admin/mails");
        } else {
            return redirect("/admin/login");
        }
    }

    function getMailView(Request $request, $view) {
        if (auth()->user()) {
            return $this->getView($view, $request->properties);;
        } else {
            return redirect("/admin/login");
        }
    }
    function getMailTemplateView(Request $request, $id) {
        if (auth()->user()) {
            $mailTemplate = MailTemplate::find($id);
            $template = $mailTemplate->template;
            $templateInstance = app($template);
            return $this->getView($templateInstance->view, $request->properties);
        } else {
            return redirect("/admin/login");
        }
    }

    private function getView($view, $properties) {
        $_view = view($view);
        foreach ($properties as $property) {
            $_view->with($property['name'], self::getPropertyData($property));
        }
        return $_view;
    }

    public static function getPropertyData($property) {
        Log::debug($property);
        switch ($property['type']) {
            case 'bool':
                if (array_key_exists('value', $property)) {
                    return $property['value'] === '1' ? true : false;
                } else {
                    return false;
                }
                break;
            case Product::class:
                if (array_key_exists('value', $property)) {
                    return Product::find($property['value']);
                }
                break;
            case Blog::class:
                if (array_key_exists('value', $property)) {
                    return Blog::find($property['value']);
                }
                break;
            case HomeNew::class:
                if (array_key_exists('value', $property)) {
                    return HomeNew::find($property['value']);
                }
                break;
            default:
                if (array_key_exists('value', $property)) {
                    return $property['value'];
                }
                break;
        }
        return null;
    }

    function getUpdateView($id) {
        if (auth()->user()) {
            $mailTemplate = $this->getById($id);
            $mailTemplateProperties = MailTemplateProperty::where('mail_template_id', '=', $id)
                ->get();

            $reflectionClass = new ReflectionClass($mailTemplate->template);
            $properties = $reflectionClass->getProperties();

            $_mailTemplateProperties = [];
            foreach ($properties as $property) {
                $property->setAccessible(true);
                $type = $property->getType();
                if ($type) {
                    $mailTemplateProperty = $mailTemplateProperties->first(function ($value, $key) use ($property) {
                        return $value->name === $property->getName();
                    });
                    if (strpos($property->getName(), '_') !== 0) {
                        $data = self::getPropertyData([
                            'type' => $type->getName(),
                            'value' => $mailTemplateProperty->value ?? null,
                        ]);
                        if ($data) {
                            $mailTemplateProperty->title = $data->title ?? $data->name ?? null;
                        }
                        $_mailTemplateProperties[] = [
                            'name' => $property->getName(),
                            'type' => $type->getName(),
                            'value' => $mailTemplateProperty->value ?? null,
                            'title' => $mailTemplateProperty->title ?? null,
                        ];
                    }
                }
            }
            return view('admin.mails.update')
                ->with('mailTemplate', $mailTemplate)
                ->with('mailTemplateProperties', $_mailTemplateProperties);
        } else {
            return redirect("/admin/login");
        }
    }

    private function getById($id) {
        return MailTemplate::where('id', '=', $id)->first();
    }

    public function update(Request $request, $id) {
        if (auth()->user()) {
            $request->validate([
                'subject' => 'required',
                'properties' => 'required',
                'subscription' => 'required',
            ]);

            $mail = $this->getById($id);
            $mail->subject = $request->subject;
            $mail->subscription = $request->subscription;
            $mail->save();

            MailTemplateProperty::where('mail_template_id', '=', $id)
                ->delete();

            // TODO: validate product exist
            $mailTemplateProperties = $request->properties;
            foreach ($mailTemplateProperties as $mailTemplateProperty) {
                $requirement = new MailTemplateProperty;
                $requirement->mail_template_id = $mail->id;
                $requirement->name = $mailTemplateProperty['name'];
                $requirement->type = $mailTemplateProperty['type'];
                $requirement->value = $mailTemplateProperty['value'];
                $requirement->save();
            }

            return response()->json(['message' => 'Mail updated']);
        } else {
            return redirect("/admin/login");
        }
    }
}
