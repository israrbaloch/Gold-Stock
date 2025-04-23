<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AskVerificationMail;
use App\Models\Identification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class IdentificationController extends Controller
{
    // index
    public function index()
    {
        $user_id = request()->get('user_id');
        $verified = request()->get('verified');
        $identifications = Identification::when($user_id, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        })->when($verified == '0' || $verified == '1', function ($query) use ($verified) {
            return $query->where('verified', $verified);
        })
            ->latest()
            ->paginate(10);

        return view('admin.identifications.index', compact('identifications'));
    }

    // approve
    public function approve(Identification $identification)
    {
        $identification->update(['verified' => 1]);
        return redirect()->back()->with('success', 'Identification approved successfully!');
    }

    // reject
    public function reject(Identification $identification)
    {
        $identification->update(['verified' => 0]);
        return redirect()->back()->with('success', 'Identification rejected successfully!');
    }

    // sendIdentificationMail
    public function sendIdentificationMail()
    {
        $user_id = request()->get('user_id');
        $user = User::findOrFail($user_id);
        Mail::to($user->email)->send(new AskVerificationMail($user->name));
        return redirect()->back()->with(
            [
                'message' => 'Identification mail sent successfully!',
                'alert-type' => 'info'
            ]
        );
    }
}
