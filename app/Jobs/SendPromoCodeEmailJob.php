<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PromoCodeEmail;

class SendPromoCodeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    protected $promoCode;

    /**
     * Create a new job instance.
     *
     * @param array $users
     * @param string $promoCode
     */
    public function __construct(array $users, $promoCode)
    {
        $this->users = $users;
        $this->promoCode = $promoCode;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        foreach ($this->users as $userId) {
            $user = User::find($userId);
            if ($user) {
                Mail::to($user->email)->send(new PromoCodeEmail($user, $this->promoCode));
            }
        }
    }
}

