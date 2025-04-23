<?php

namespace App\Http\Controllers;

use App\Models\LoginSecurity;
use Auth;
use Illuminate\Http\Request;

class LoginSecurityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show 2FA Setting form
     */
    public function show2faForm(Request $request){
        $user = Auth::user();
        $google2fa_url = "";
        $secret_key = "";

        if($user->loginSecurity()->exists()){
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2fa_url = $google2fa->getQRCodeInline(
                'GoldStock Google Login',
                $user->email,
                $user->loginSecurity->google2fa_secret
            );
            $secret_key = $user->loginSecurity->google2fa_secret;
        }

        $data = array(
            'user' => $user,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url
        );
        return response()->json(array('success' => true, 'data' => $data), 200);
        //return view('auth.2fa_settings')->with('data', $data);
    }

    /**
     * Generate 2FA secret key
     */
    public function generate2faSecret(Request $request){
        $user = Auth::user();
        // Initialise the 2FA class
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        // Add the secret key to the registration data
        $login_security = LoginSecurity::firstOrNew(array('user_id' => $user->id));
        $login_security->user_id = $user->id;
        $login_security->google2fa_enable = 0;
        $login_security->google2fa_secret = $google2fa->generateSecretKey();
        $login_security->save();
        
        return response()->json(array('success' => true), 200);
        //return redirect('/2fa')->with('success',"Secret key is generated.");
    }

    /**
     * Enable 2FA
     */
    public function enable2fa(Request $request){
        $user = Auth::user();
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        $secret = $request->input;
        $valid = $google2fa->verifyKey($user->loginSecurity->google2fa_secret, $secret);
        if($valid){
            $user->loginSecurity->google2fa_enable = 1;
            $user->loginSecurity->save();
            return response()->json(array('success' => true, 'msg' => "Secret key is generated."), 200);
        }else{
            return response()->json(array('success' => false, 'msg' => "Invalid verification Code, Please try again."), 200);
            //return redirect('2fa')->with('error',"Invalid verification Code, Please try again.");
        }
    }

    /**
     * Disable 2FA
     */
    public function disable2fa(Request $request){
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
        $user = Auth::user();
        $secret = $request->input;
        $valid = $google2fa->verifyKey($user->loginSecurity->google2fa_secret, $secret);
        if($valid){
            $user->loginSecurity->google2fa_enable = 0;
            $user->loginSecurity->save();
            return response()->json(array('success' => true, 'msg' => "2FA is now disabled."), 200);
        } else {
            return response()->json(array('success' => false, 'msg' => "Invalid verification Code, Please try again."), 200);
        }
        //return redirect('/2fa')->with('success',"2FA is now disabled.");
    }
}