<?php

namespace App\Http\Controllers;

use App\Models\PriceAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceAlertController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'alert_type' => 'required|string',
            'value' => 'required|numeric|min:0',
            'frequency' => 'required|string',
            'type' => 'required|numeric',
            'product_id' => 'nullable|numeric',
            'metal_id' => 'nullable|numeric',
        ]);

        PriceAlert::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'metal_id' => $request->metal_id,
                'product_id' => $request->product_id,
                'alert_type' => $request->alert_type,
            ],
            [
                'value' => $request->value,
                'frequency' => $request->frequency,
                'type' => $request->type,
                'currency' => $request->currency,
                'status' => 1,
            ]
        );

        return redirect()->back()->with('alert_created', 'Price alert created successfully!');
    }

    // Fetch active alerts for a user
    public function index()
    {
        $alerts = PriceAlert::where('user_id', Auth::id())->where('status', 1)->get();
        return view('alerts.index', compact('alerts'));
    }

    // Delete an alert
    public function destroy($id)
    {
        $alert = PriceAlert::findOrFail($id);
        if ($alert->user_id == Auth::id()) {
            $alert->delete();
            return redirect()->back()->with('success', 'Alert deleted successfully!');
        }
        return redirect()->back()->with('error', 'Unauthorized action!');
    }

    // markAsRead
    public function markAsRead(Request $request)
    {
        $request->validate([
            'notification_id' => 'required',
        ]);

        $notification = auth()->user()->notifications()->where('id', $request->notification_id)->first();
        if ($notification) {
            $notification->markAsRead();
            return redirect()->back()->with('success', 'Notification marked as read!');
        }
        return redirect()->back()->with('error', 'Notification not found!');
    }

    // markAllRead
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => 'All notifications marked as read!']);
    }
}
