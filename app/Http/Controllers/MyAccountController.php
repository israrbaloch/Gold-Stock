<?php

namespace App\Http\Controllers;

use App\Mail\AdminIdentificationMail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Account;
use App\Models\Identification;
use App\Models\Province;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Log;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getView()
    {
        $user = auth()->user();
        $account = Account::where('user_id', $user->id)->join('provinces', 'provinces.id', 'accounts.province_id')->orderBy('accounts.id', 'desc')->first();
        Log::debug($user);
        if ($account && $user) {
            return view('account.index')
                ->with('myaccount', $account)
                ->with('user', $user);
        } else {
            return redirect()->route('profile');
        }
    }

    public function setProfile()
    {
        $user = auth()->user();
        $provinces = Province::select('name', 'id')->get();
        return view('profile')
            ->with('user', $user)
            ->with('provinces', $provinces);
    }

    public function saveProfile(Request $request)
    {
        $user = auth()->user();
        $account = Account::select('number')->orderBy('number', 'desc')->first();
        $accountnumber = ($account) ? $account->number + 1 : 1;
        $userAccount = Account::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        $profile = $userAccount ? $userAccount : new Account();
        $profile->user_id = auth()->user()->id;
        $profile->number = $accountnumber;
        $profile->last_login_time = Carbon::now();
        $profile->last_ip_address = $this->get_client_ip();
        $profile->address_line1 = $request->address_line1;
        $profile->fname = $request->fname;
        $profile->lname = $request->lname;
        $profile->city = $request->city;
        $profile->phone = $request->phone;
        $profile->postcode = $request->postcode;
        $profile->province_id = $request->province_id;
        $profile->save();
        $updateuser = User::find($user->id);
        $updateuser->name_for_admins = $request->fname . ' ' . $request->lname . ' (' . $user->email . ')';
        $updateuser->name = $request->fname . ' ' . $request->lname;
        $updateuser->save();
        return redirect()->route('account')
            ->with('user', $user)
            ->with('myaccount', $profile);
    }

    public function setAccountNumber()
    {
        do {
            $accountNumber =  rand(100000, 999999);
            $results = Account::where('number', $accountNumber)->orderBy('id', 'desc')->first();
        } while (count($results) > 0);
        return $accountNumber;
    }

    public function get_client_ip()
    {
        // Nothing to do without any reliable information
        if (!isset($_SERVER['REMOTE_ADDR'])) {
            return NULL;
        }

        // Header that is used by the trusted proxy to refer to
        // the original IP
        $proxy_header = "HTTP_X_FORWARDED_FOR";

        // List of all the proxies that are known to handle 'proxy_header'
        // in known, safe manner
        $trusted_proxies = array("2001:db8::1", "192.168.50.1");

        if (in_array($_SERVER['REMOTE_ADDR'], $trusted_proxies)) {

            // Get IP of the client behind trusted proxy
            if (array_key_exists($proxy_header, $_SERVER)) {

                // Header can contain multiple IP-s of proxies that are passed through.
                // Only the IP added by the last proxy (last IP in the list) can be trusted.
                $client_ip = trim(end(explode(",", $_SERVER[$proxy_header])));

                // Validate just in case
                if (filter_var($client_ip, FILTER_VALIDATE_IP)) {
                    return $client_ip;
                } else {
                    // Validation failed - beat the guy who configured the proxy or
                    // the guy who created the trusted proxy list?
                    // TODO: some error handling to notify about the need of punishment
                }
            }
        }

        // In all other cases, REMOTE_ADDR is the ONLY IP we can trust.
        return $_SERVER['REMOTE_ADDR'];
    }

    public function saveLoginData(Request $request)
    {

        $account = Account::where("user_id", Auth::user()->id)->orderBy('id', 'desc')->first();

        if ($account) {
            $currentIP = $this->get_client_ip();
            $lastIP = $account->last_ip_address;
            if ($lastIP != $currentIP) {
                $account->last_ip_address = $this->get_client_ip();
                $account->last_login_time = Carbon::now();
                $account->save();
                return response()->json(array('success' => true), 200);
            }
        } else {
            return response()->json(array('success' => "noaccount"), 200);
        }
    }

    public function saveIdentification(Request $request)
    {
        $file = $request->file('file');
        // Storage::put('users/identification/' . auth()->user()->id . '.' . $file->extension(), File::get($file));
        $filePath = 'users/identification/' . auth()->user()->id . '.' . $file->extension();

        // Store the file in the public disk
        Storage::disk('public')->put($filePath, File::get($file));
        $url = 'users/identification/' . auth()->user()->id . '.' . $file->extension();
        $account = Account::where("user_id", auth()->user()->id)->orderBy('id', 'desc')->first();
        $account->identification = $url;
        $account->upload_id_date = Carbon::now();
        $account->update();

        Identification::updateOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'file' => $url,
                'verified' => 0,
            ]
        );
        $data = array(
            'fname' => auth()->user()->name,
            'email' => auth()->user()->email,
            'file'   => $file,
            'filename' => auth()->user()->id,
            'ext' => $file->extension(),
        );
        $emails = User::whereIn('role_id', [1])->pluck('email');
        Mail::to($emails)->send(new AdminIdentificationMail($data));
        return response()->json(array('success' => $request), 200);
    }

    public function saveShippingInfo(Request $request)
    {
        $user = auth()->user();
        $profile = Account::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        $profile->address_line1 = $request->billing_address_1;
        $profile->fname = $request->billing_first_name;
        $profile->lname = $request->billing_last_name;
        $profile->city = $request->billing_city;
        $profile->phone = $request->billing_phone;
        $profile->postcode = $request->billing_postcode;
        $profile->province_id = $request->billing_province_id;
        $profile->save();
        return back()
            ->with('success', true);
    }
}
