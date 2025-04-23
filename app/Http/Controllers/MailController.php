<?php

namespace App\Http\Controllers;

use App\Mail\GoldStockMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller {
    function send($params) {
        try {
            // dd($params);
            if ($params['View'] == 'customerBuyMetal' || $params['View'] == 'customerOrder') {
                $params['Subject'] = "Your GoldStockCanada order from " . Carbon::now() . " is complete";
                Mail::to($params['email'])->send(new GoldStockMail($params));
                if ($params['View'] == 'customerOrder') {
                    $params['View'] = 'newCustomerOrder';
                    $params['Subject'] = "New customer order (" . $params['metalOrder'] . ") - " . Carbon::now();
                    $emails = User::whereIn('role_id', [1, 3, 4])->pluck('email');
                    Mail::to($emails)->send(new GoldStockMail($params));
                }
                if ($params['View'] == 'customerBuyMetal') {
                    $params['View'] = 'newCustomerBuyMetal';
                    $params['Subject'] = "New customer order (" . $params['metalOrder'] . ") - " . Carbon::now();
                    $emails = User::whereIn('role_id', [1, 3, 4])->pluck('email');
                    Mail::to($emails)->send(new GoldStockMail($params));
                }
                return back()->with('message', 'Thanks for contacting us!');
            } else {
                Mail::to($params['email'])->send(new GoldStockMail($params));
                $emails = User::whereIn('role_id', [1, 3, 4])->pluck('email');
                Mail::to($emails)->send(new GoldStockMail($params));
                return back()->with('message', 'Thanks for contacting us!');
            }
        } catch (\Error $th) {
            Log::error($th);
        }
    }

    function newUser($params) {
        //    dd($params);
        $emails = User::whereIn('role_id', [1, 3, 4])->pluck('email');
        $data = array(
            'Subject' => $params['Subject'],
            'View'    =>  $params['View'],
            'newemail'   =>  $params['newemail']
        );

        Mail::to($emails)->send(new GoldStockMail($data));
        return back()->with('message', 'Thanks for contacting us!');
    }

    function convert($params) {
        $params['Subject'] = "Your GoldStockCanada order from " . Carbon::now() . " is complete";
        Mail::to($params['email'])->send(new GoldStockMail($params));
        $params['Subject'] = "New customer order (" . $params['ProductOrder'] . ") - " . Carbon::now();
        $emails = User::whereIn('role_id', [1, 3, 4])->pluck('email');
        Mail::to($emails)->send(new GoldStockMail($params));
        return back()->with('message', 'Thanks for contacting us!');
    }

    public function verification($params) {
        $data = array(
            'Subject' => $params['Subject'],
            'View'    =>  $params['View'],
            'fname'   =>  $params['fname'],
            'email'   =>  $params['email'],
            'file'   =>  $params['file'],
            'filename' => $params['filename'],
            'ext' => $params['ext'],
        );
        $emails = User::whereIn('role_id', [1, 3, 4])->pluck('email');
        Mail::to($emails)->send(new GoldStockMail($data));
        return back()->with('message', 'Thanks for contacting us!');
    }
}
