<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\UserCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TwoFAController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('2faemail');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required',
        ]);
        if (auth()->user()){
            $find = UserCode::where('user_id', auth()->user()->id)
                            ->where('code', $request->code)
                            ->where('updated_at', '>=', now()->subMinutes(2))
                            ->first();

            if (!is_null($find)) {
                Session::put('user_2fa', auth()->user()->id);
                if($request->activate == 1 || $request->activate == 2){
                    $user = User::find(auth()->user()->id);
                    if($request->activate == 1){
                        $user->loginSecurity->email2fa_enable = 1;
                        $user->loginSecurity->save();
                        return response()->json(array('success' => true, 'msg' => 'Two steps authentication Activated!'), 200);
                    } else {
                        $user->loginSecurity->email2fa_enable = 0;
                        $user->loginSecurity->save();
                        return response()->json(array('success' => true, 'msg' => 'Two steps authentication Deactivated!'), 200);
                        
                    }
                } else {
                    return redirect()->route('home');
                }
            } else {
                return back()->with('email-error', 'Invalid verification Code, Please try again.');
            }
        } else {
            return back()->with('email-error', 'Something went wrong. Please try again.');
        }
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function verify()
    {
        auth()->user()->generateCode();
        return response()->json(array('success' => true, 'msg' => 'We sent you code on your email.'), 200);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function resend()
    {
        auth()->user()->generateCode();
  
        return response()->json(array('success' => true, 'msg' => 'We sent you code on your email.'), 200);
    }
}
