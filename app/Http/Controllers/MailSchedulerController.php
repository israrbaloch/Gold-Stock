<?php

namespace App\Http\Controllers;

use App\Models\MailTemplate;
use App\Models\Scheduler;
use App\Models\SchedulerSelectedUser;
use App\Models\User;
use Illuminate\Http\Request;
use Log;

class MailSchedulerController extends Controller {
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
            return view('admin.mails.scheduler.create')
                ->with('mailTemplates', $mailTemplates);
        } else {
            return redirect("/admin/login");
        }
    }

    public function create(Request $request) {
        if (auth()->user()) {
            $request->validate([
                'subject' => 'required',
                'template_id' => 'required',
                'scheduled_at' => 'required',
                'specific_users' => 'required',
            ]);

            if ($request->specific_users == 'on') {
                $request->validate([
                    'users' => 'required',
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
            $scheduler->subject = $request->subject;
            $scheduler->template_id = $template->id;
            $scheduler->scheduled_at = $request->scheduled_at;
            $scheduler->save();

            $users = [];
            if ($request->specific_users == 'on') {
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
                $scheduler->specific_users = true;
                $scheduler->save();
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
            $selectedUsers = User::join('scheduler_selected_users', 'users.id', '=', 'scheduler_selected_users.user_id')
                ->where('scheduler_selected_users.scheduler_id', '=', $scheduler->id)
                ->get();
            return view('admin.mails.scheduler.update')
                ->with('scheduler', $scheduler)
                ->with('selectedUsers', $selectedUsers)
                ->with('mailTemplates', $mailTemplates);
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
                'subject' => 'required',
                'template_id' => 'required',
                'scheduled_at' => 'required',
            ]);

            if ($request->specific_users == 'on') {
                $request->validate([
                    'users' => 'required',
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

            $scheduler->subject = $request->subject;
            $scheduler->template_id = $template->id;
            $scheduler->scheduled_at = $request->scheduled_at;
            $scheduler->save();

            $users = [];
            if ($request->specific_users == 'on') {
                $users = json_decode($request->users);
                if (!$users) {
                    Log::error('Invalid users');
                    return response()->json([
                        'message' => 'Invalid users',
                    ], 400);
                }

                SchedulerSelectedUser::where('scheduler_id', $scheduler->id)->delete();
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
                $scheduler->specific_users = true;
                $scheduler->save();
            } else {
                $scheduler->specific_users = false;
                $scheduler->save();
            }

            return response()->json(['message' => 'Mail updated']);
        } else {
            return redirect("/admin/login");
        }
    }
}
