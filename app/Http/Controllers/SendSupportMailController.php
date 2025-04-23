<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSupportMail;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use App\Models\User;

class SendSupportMailController extends Controller {
    function index() {
        return view('emails.supportContact');
    }

    function send(Request $request) {
        $this->validate($request, [
            'option'   => 'required',
            'fname'   => 'required',
            'lname'   => 'required',
            'email'  =>  'required|email',
            'message' =>  'required'
        ]);

        $data = array(
            'option' => $request->option,
            'fname'    => $request->fname,
            'lname'    => $request->lname,
            'email'    => $request->email,
            'message' =>  $request->message,
        );
        $admins = User::whereIn('role_id', [1])->pluck('email');
        Mail::to($admins)->send(new EmailSupportMail($data));
        return back()->with('message', 'Thanks for contacting us!');
    }
}
