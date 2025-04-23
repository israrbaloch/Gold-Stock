<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MyAccountController;
use App\Providers\RouteServiceProvider;
use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Auth;
use Hash;
use Log;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        // dd($request->all());
        // login-modal put in session
        session()->flash('login-modal', true);

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            session()->forget('login-modal');
            $account = Account::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();
            if ($account) {
                $accontroller = new MyAccountController();
                $account->last_ip_address = $accontroller->get_client_ip();
                $account->last_login_time = Carbon::now();
                $account->save();
            } else {
                return redirect()->route('profile');
            }
            if ($account && $account->has_email) {
                auth()->user()->generateCode();
                return redirect()->route('2faemail.index');
            } else {
                if ($request->redirect) {
                    return redirect($request->redirect);
                }
                return redirect()->route('home');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function hasGoogleLogin(Request $request) {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $account = Account::where("user_id", $user->id)->orderBy('id', 'desc')->first();
            if (Hash::check($request->password, $user->password)) {
                if ($account && $account->has_google) {
                    return response()->json(array('success' => true, 'has_google' => true), 200);
                } else {
                    return response()->json(array('success' => true, 'has_google' => false), 200);
                }
            } else {
                return response()->json(array('success' => false, 'has_google' => false), 200);
            }
        }
    }

    public function verify2fa(Request $request) {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $secret = $request->google_code;
            $valid = $google2fa->verifyKey($user->loginSecurity->google2fa_secret, $secret);
            if ($valid) {
                Auth::login($user);
                return response()->json(array('success' => true), 200);
            } else {
                return response()->json(array('success' => false, 'msg' => "Invalid verification Code, Please try again."), 200);
                //return redirect('2fa')->with('error',"Invalid verification Code, Please try again.");
            }
        }
    }
}
