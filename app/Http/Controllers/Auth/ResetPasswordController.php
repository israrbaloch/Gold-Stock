<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserChangePasswordMail;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password) {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        // send welcome mail
        Mail::to($user->email)->queue(new UserChangePasswordMail($user));
        // event(new PasswordReset($user));

        $this->guard()->login($user);
    }
}
