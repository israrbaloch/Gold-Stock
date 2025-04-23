<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeMail;
use App\Models\MetalDeposit;
use App\Models\MetalWithdrawal;
use App\Models\CashDeposit;
use App\Models\CashWithdrawal;
use App\Models\Currency;
use App\Models\Metal;
use App\Notifications\ResetPasswordNotification;
use Exception;
use Illuminate\Support\Facades\URL;
use TCG\Voyager\Models\Role;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    protected $table = 'users';
    protected $appends = ['has_google', 'has_email', 'account_number', 'balances'];

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'name_for_admins', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscribed' => 'boolean',
        'news_subscribed' => 'boolean',
        'blogs_subscribed' => 'boolean',
        'promo_subscribed' => 'boolean',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function loginSecurity()
    {
        return $this->hasOne(LoginSecurity::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->id, 'hash' => sha1($this->email)]
        );

        Mail::send('emails.user.verify-email', [
            'name' => $this->name, // Pass the user's name
            'url' => $verificationUrl,
        ], function ($message) {
            $message->to($this->email)
                ->subject('Verify Your Email Address');
        });
    }

    public function generateCode()
    {
        $code = rand(10000, 99999);

        UserCode::updateOrCreate(['user_id' => auth()->user()->id], ['code' => $code]);

        try {
            $details = [
                'title' => 'Login Code',
                'code' => $code,
            ];
            Mail::to(auth()->user()->email)->send(new CodeMail($details));
        } catch (Exception $e) {
            info('Error: ' . $e->getMessage());
        }
    }

    public function getHasGoogleAttribute()
    {
        $ls = LoginSecurity::where('user_id', $this->id)->first();
        $has = $ls ? $ls->google2fa_enable : 0;
        return $has;
    }

    public function getHasEmailAttribute()
    {
        $ls = LoginSecurity::where('user_id', $this->id)->first();
        $has = $ls ? $ls->email2fa_enable : 0;
        return $has;
    }

    public function getAccountNumberAttribute()
    {
        $account = Account::where('user_id', $this->id)
            ->orderBy('id', 'desc')
            ->first();
        return $account ? $account->number : null;
    }

    public function getBalancesAttribute()
    {
        $metalDeposits = MetalDeposit::where('user_id', $this->id)
            ->where('status_id', 2)
            ->get();
        $cashDeposits = CashDeposit::where('user_id', $this->id)
            ->where('status_id', 2)
            ->get();
        $metalWithdrawals = MetalWithdrawal::where('user_id', $this->id)->get();
        $cashithdrawals = CashWithdrawal::where('user_id', $this->id)->get();
        $balances = [];
        $metals = [];
        $cash = [];
        $allMetals = Metal::all();
        $currencies = Currency::all();

        $i = 0;
        foreach ($allMetals as $metal) {
            $metals[$i]['metalName'] = $metal->name;
            $metals[$i]['total'] = 0;
            foreach ($metalDeposits as $dp) {
                if ($metal->id == $dp->metal_id) {
                    $metals[$i]['total'] += $dp->oz;
                }
            }
            foreach ($metalWithdrawals as $wd) {
                if ($metal->id == $wd->metal_id) {
                    $metals[$i]['total'] -= $wd->oz;
                }
            }
            $i++;
        }
        $balances['metals'] = $metals;
        $i = 0;
        foreach ($currencies as $cr) {
            $cash[$i]['currency'] = $cr->code;
            $cash[$i]['total'] = 0;
            foreach ($cashDeposits as $dp) {
                if ($cr->id == $dp->currency_id) {
                    $cash[$i]['total'] += round($dp->value, 2);
                }
            }
            foreach ($cashithdrawals as $wd) {
                if ($cr->id == $wd->currency_id) {
                    $cash[$i]['total'] -= round($wd->value, 2);
                }
            }
            $cash[$i]['total'] = round($cash[$i]['total'], 2);
            $i++;
        }
        $balances['cash'] = $cash;
        return $balances;
    }
}
