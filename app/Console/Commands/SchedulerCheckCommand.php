<?php

namespace App\Console\Commands;

use App\Models\Scheduler;
use App\Models\SchedulerSelectedUser;
use App\Models\SchedulerUser;
use App\Models\Subscription;
use App\Models\SubscriptionList;
use App\Models\User;
use Illuminate\Console\Command;
use Log;

class SchedulerCheckCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $schedulers = Scheduler::where('scheduled_at', '<=', now())
            ->where('status', 'pending')
            ->get();

        if ($schedulers->count() == 0) {
            return 0;
        }
        Log::info('Scheduler checker command is running');

        // $subscribedUsers = User::where('subscribed', true)->get();
        $newsSubscribedUsers = User::where('news_subscribed', true)->get();
        $blogsSubscribedUsers = User::where('blogs_subscribed', true)->get();
        $promoSubscribedUsers = User::where('promo_subscribed', true)->get();

        foreach ($schedulers as $scheduler) {
            $scheduler->status = 'in progress';
            $scheduler->save();

            try {
                $isSelectedUsers = false;
                if ($scheduler->type == 'specific' || $scheduler->type == 'business') {
                    $_usersQuery = User::whereIn('id', $scheduler->selectedUsers->pluck('id'));
                    switch ($scheduler->template->subscription) {
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
                            Log::error('Unknown subscription type: ' . $scheduler->template->subscription);
                            $scheduler->status = 'failed';
                            $scheduler->save();
                            continue 2;
                    }
                    $usersToSend = $_usersQuery->get();
                    $isSelectedUsers = true;
                } else if ($scheduler->type == 'list') {
                    $subscription = SubscriptionList::where('id', $scheduler->subscription_id)->first();
                    if (!$subscription) {
                        Log::error('Subscription not found: ' . $scheduler->subscription_id);
                        $scheduler->status = 'failed';
                        $scheduler->save();
                        continue;
                    }
                    $usersToSend = $subscription->users;
                } else if ($scheduler->type == 'all') {
                    switch ($scheduler->template->subscription) {
                        case 'news':
                            $usersToSend = $newsSubscribedUsers;
                            break;
                        case 'blogs':
                            $usersToSend = $blogsSubscribedUsers;
                            break;
                        case 'promo':
                            $usersToSend = $promoSubscribedUsers;
                            break;
                        default:
                            Log::error('Unknown subscription type: ' . $scheduler->template->subscription);
                            $scheduler->status = 'failed';
                            $scheduler->save();
                            continue 2;
                    }
                } else {
                    Log::error('Unknown scheduler type: ' . $scheduler->type);
                    $scheduler->status = 'failed';
                    $scheduler->save();
                    continue;
                }

                foreach ($usersToSend as $user) {
                    SchedulerUser::create([
                        'scheduler_id' => $scheduler->id,
                        'user_id' => $user->id,
                        'sent_at' => now(),
                    ]);
                    if ($isSelectedUsers) {
                        SchedulerSelectedUser::where('scheduler_id', $scheduler->id)
                            ->where('user_id', $user->id)
                            ->update(['sent' => true]);
                    }
                }
                $scheduler->status = 'sent';
                $scheduler->save();
            } catch (\Exception $e) {
                Log::error('Error while sending scheduler: ' . $e->getMessage());
                $scheduler->status = 'failed';
                $scheduler->save();
            }
        }

        Log::info('Scheduler checker command is done');
        return 0;
    }
}
