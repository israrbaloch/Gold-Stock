<?php

namespace App\Console\Commands;

use App\Models\SchedulerUser;
use Illuminate\Console\Command;
use Log;

class SchedulerSendCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:send';

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
        Log::info('Scheduler send command is running');

        $users = SchedulerUser::where('sent_at', '<=', now())
            ->whereIn('status', ['pending', 'failed'])
            ->where('attempts', '<', 3)
            ->get();

        if ($users->count() == 0) {
            Log::info('No users to send');
            return 0;
        }

        // set all users status to in progress
        foreach ($users as $user) {
            $user->update(['status' => 'in progress']);
        }

        $users->each(function ($user) {
            $user->sendMail();
        });
        return 0;
    }
}
