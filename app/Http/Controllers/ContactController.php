<?php

namespace App\Http\Controllers;

use App\Mail\EmailSupportMail;
use App\Models\User;
use Illuminate\Http\Request;
use Log;
use Mail;

class ContactController extends Controller {
    function getView() {
        return view('support');
    }

    function store(Request $request) {

        // dd($request->all());
        $this->validate($request, [
            // 'option'   => 'required',
            // 'fname'   => 'required',
            // 'lname'   => 'required',
            'name'   => 'required',
            'email'  =>  'required|email',
            'message' =>  'required'
        ]);

        $data = array(
            // 'option' => $request->option,
            // 'fname'    => $request->fname,
            // 'lname'    => $request->lname,
            'name'    => $request->name,
            'email'    => $request->email,
            'message' =>  $request->message,
        );
        $admins = User::whereIn('role_id', [1])->pluck('email');
        try {
            Mail::to($admins)->queue(new EmailSupportMail($data));
        } catch (\Throwable $th) {
            Log::info('Contact: ' . json_encode($data));
            Log::critical($th);
        }

        return redirect()->back()->with('message', 'Thanks for contacting us!');
    }
}
