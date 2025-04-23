<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Mail\UserWelcomeMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => ['required','string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'same:confirm_email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data) {
        // $data['name'] = "";
        $nameForAdmins = $data['name'] . ' (' . $data['email'] . ')';
        back()->with('message', 'Thanks for contacting us!');

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'name_for_admins' => $nameForAdmins,
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        // dd($request->all(), config('app.env'));
        session()->flash('reg_type', $request->type);
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        event(new Registered($user));
        $this->guard()->login($user);

        // dd($user->email, $user->name, $user->type, config('app.env'));
        // dd($request->type);

        // send welcome mail
        if (config('app.env') != 'testing') {
            Mail::to($user->email)->queue(new UserWelcomeMail($user->name, $request->type));
        }
        
        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }
}
