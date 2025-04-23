<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        if (config('app.env') != 'testing') {
            VerifyEmail::toMailUsing(function ($notifiable, $url) {
                return (new MailMessage)
                    ->view('emails.user.verify-email', ['url' => $url])
                    ->subject('Verify Email Address')
                    ->line('Click the button below to verify your email address.')
                    ->action('Verify Email Address', $url);
            });
        }
    }
}
