<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\MailTemplate;
use App\Models\Scheduler;
use App\Models\SchedulerSelectedUser;
use App\Models\SubscriptionList;
use App\Models\SubscriptionListUser;
use App\Models\User;
use Illuminate\Http\Request;
use Log;

class SchedulerController extends Controller {

    function index() {
        if (auth()->user()) {
            $schedulers = Scheduler::orderBy('id', 'desc')
                ->paginate(10);
            return view('admin.mails.scheduler.list')
                ->with('schedulers', $schedulers);
        } else {
            return redirect("/admin/login");
        }
    }

    public function getCreateView() {
        if (auth()->user()) {
            $mailTemplates = MailTemplate::orderBy('id', 'desc')
                ->paginate(10);
            $subscriptionLists = SubscriptionList::all();
            return view('admin.mails.scheduler.create')
                ->with('mailTemplates', $mailTemplates)
                ->with('subscriptionLists', $subscriptionLists);
        } else {
            return redirect("/admin/login");
        }
    }

    public function create(Request $request) {
        if (auth()->user()) {
            $request->validate([
                'template_id' => 'required',
                'scheduled_at' => 'required',
                'type' => 'required',
            ]);

            if ($request->type == 'specific') {
                $request->validate([
                    'users' => 'required',
                ]);
            }
            if ($request->type == 'list') {
                $request->validate([
                    'subscription_id' => 'required',
                ]);
            }

            $template = MailTemplate::where('id', $request->template_id)->first();
            if (!$template) {
                Log::error('Template not found');
                return response()->json([
                    'message' => 'Template not found',
                ], 404);
            }

            $scheduler = new Scheduler();
            $scheduler->template_id = $template->id;
            $scheduler->scheduled_at = $request->scheduled_at;

            $scheduledTime = strtotime($request->scheduled_at);
            $currentTime = time();
            $timeDifference = $scheduledTime - $currentTime;
            $minutesDifference = floor($timeDifference / 60);

            if ($minutesDifference < 10) {
                $scheduler->scheduled_at = date('Y-m-d H:i:s', strtotime('+10 minutes', $scheduledTime));
            }
            $scheduler->type = $request->type;
            if ($request->type == 'list') {
                $list = SubscriptionList::where('id', $request->subscription_id)->first();
                if (!$list) {
                    Log::error('List not found');
                    return response()->json([
                        'message' => 'List not found',
                    ], 404);
                }
                $scheduler->subscription_id = $list->id;
            }
            $scheduler->save();

            if ($request->type == 'specific') {
                $users = [];
                $users = json_decode($request->users);
                if (!$users) {
                    Log::error('Invalid users');
                    return response()->json([
                        'message' => 'Invalid users',
                    ], 400);
                }

                foreach ($users as $user) {
                    $user = User::where('id', $user)->first();
                    if (!$user) {
                        Log::error('User not found');
                        return response()->json([
                            'message' => 'User not found',
                        ], 404);
                    }
                    SchedulerSelectedUser::create([
                        'scheduler_id' => $scheduler->id,
                        'user_id' => $user->id,
                    ]);
                }
            } else if ($request->type == 'business') {
                $accounts = Account::unique()->get();

                foreach ($accounts as $account) {
                    $user = User::where('id', $account->user_id)->first();
                    if (!$user) {
                        Log::error('User ' . $account->user_id . ' not found');
                        continue;
                    }

                    if ($user->subscribed) {
                        SchedulerSelectedUser::create([
                            'scheduler_id' => $scheduler->id,
                            'user_id' => $user->id,
                        ]);
                    }
                }
            }

            return redirect("/admin/mails/scheduler");
        } else {
            return redirect("/admin/login");
        }
    }

    function getUpdateView($id) {
        if (auth()->user()) {
            $scheduler = $this->getById($id);
            $mailTemplates = MailTemplate::orderBy('id', 'desc')
                ->paginate(10);
            $selectedUsers = SchedulerSelectedUser::where('scheduler_id', $scheduler->id)->get();
            Log::info($selectedUsers);
            $subscriptionLists = SubscriptionList::all();
            return view('admin.mails.scheduler.update')
                ->with('scheduler', $scheduler)
                ->with('selectedUsers', $selectedUsers)
                ->with('mailTemplates', $mailTemplates)
                ->with('subscriptionLists', $subscriptionLists);
        } else {
            return redirect("/admin/login");
        }
    }

    private function getById($id) {
        $mail = Scheduler::where('id', '=', $id)->first();
        return $mail;
    }

    public function update(Request $request, $id) {
        if (auth()->user()) {
            $request->validate([
                'template_id' => 'required',
                'scheduled_at' => 'required',
                'type' => 'required',
            ]);

            if ($request->specific_users == 'on') {
                $request->validate([
                    'users' => 'required',
                ]);
            }

            if ($request->type == 'list') {
                $request->validate([
                    'subscription_id' => 'required',
                ]);
            }

            $scheduler = $this->getById($id);
            if (!$scheduler) {
                Log::error('Scheduler not found');
                return response()->json([
                    'message' => 'Scheduler not found',
                ], 404);
            }

            $template = MailTemplate::where('id', $request->template_id)->first();
            if (!$template) {
                Log::error('Template not found');
                return response()->json([
                    'message' => 'Template not found',
                ], 404);
            }

            $scheduler->template_id = $template->id;
            $scheduler->scheduled_at = $request->scheduled_at;

            $scheduledTime = strtotime($request->scheduled_at);
            $currentTime = time();
            $timeDifference = $scheduledTime - $currentTime;
            $minutesDifference = floor($timeDifference / 60);

            if ($minutesDifference < 10) {
                $scheduler->scheduled_at = date('Y-m-d H:i:s', strtotime('+10 minutes', $scheduledTime));
            }
            $scheduler->type = $request->type;
            if ($request->type == 'list') {
                $list = SubscriptionList::where('id', $request->subscription_id)->first();
                if (!$list) {
                    Log::error('List not found');
                    return response()->json([
                        'message' => 'List not found',
                    ], 404);
                }
                $scheduler->subscription_id = $list->id;
            }
            $scheduler->save();

            $users = [];
            Log::info($request->type);
            if ($request->type == 'specific') {
                $users = json_decode($request->users);
                if (!$users) {
                    Log::error('Invalid users');
                    return response()->json([
                        'message' => 'Invalid users',
                    ], 400);
                }


                SchedulerSelectedUser::where('scheduler_id', $scheduler->id)->delete();
                foreach ($users as $user) {
                    Log::info($user);
                    $user = User::where('id', $user)->first();
                    if (!$user) {
                        Log::error('User not found');
                        return response()->json([
                            'message' => 'User not found',
                        ], 404);
                    }
                    SchedulerSelectedUser::create([
                        'scheduler_id' => $scheduler->id,
                        'user_id' => $user->id,
                    ]);
                }
            } else if ($request->type == 'business') {
                SchedulerSelectedUser::where('scheduler_id', $scheduler->id)->delete();
                $accounts = Account::unique()->get();

                foreach ($accounts as $account) {
                    $user = User::where('id', $account->user_id)->first();
                    if (!$user) {
                        Log::error('User ' . $account->user_id . ' not found');
                        continue;
                    }

                    if ($user->subscribed) {
                        SchedulerSelectedUser::create([
                            'scheduler_id' => $scheduler->id,
                            'user_id' => $user->id,
                        ]);
                    }
                }
            }
            $scheduler->type = $request->type;
            $scheduler->save();

            return response()->json(['message' => 'Mail updated']);
        } else {
            return redirect("/admin/login");
        }
    }

    public function users($templateId, $type, $listId) {

        $template = MailTemplate::where('id', $templateId)->first();
        Log::debug($template);
        switch ($type) {
            case 'all':
                switch ($template->subscription) {
                    case 'news':
                        return User::where('news_subscribed', true)->get();
                    case 'blogs':
                        return User::where('blogs_subscribed', true)->get();
                    case 'promo':
                        return User::where('promo_subscribed', true)->get();
                    default:
                        Log::error('Unknown subscription type: ' . $template->subscription);
                        return response()->json([
                            'message' => 'Unknown subscription type: ' . $template->subscription,
                        ], 400);
                }
                break;
            case 'business':
                $accounts = Account::unique()->get();

                $_usersQuery = User::whereIn('id', $accounts->pluck('user_id'));
                switch ($template->subscription) {
                    case 'news':
                        $_usersQuery->where('news_subscribed', true);
                        break;
                    case 'blogs':
                        $_usersQuery->where('blogs_subscribed', true);
                        break;
                    case 'promo':
                        $_usersQuery->where('promo_subscribed', true);
                        break;
                    default:
                        Log::error('Unknown subscription type: ' . $template->subscription);
                        break;
                }
                return $_usersQuery->get();

            case 'list':
                $subscriptionList = SubscriptionList::where('id', $listId)->first();
                $users = SubscriptionListUser::where('subscription_list_id', $subscriptionList->id)->get();
                return $users->map(function ($user) {
                    return [
                        'name' => $user->user->name,
                        'email' => $user->user->email,
                    ];
                });
        }
    }
}
