<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendPromoCodeEmailJob;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermission('browse_promo_codes')) {
            abort(403, 'You do not have permission to browse promo codes.');
        }
        $promoCodes = PromoCode::paginate(10);
        return view('admin.promo-codes.index', compact('promoCodes'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('add_promo_codes')) {
            abort(403, 'You do not have permission to create promo codes.');
        }
        return view('admin.promo-codes.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('add_promo_codes')) {
            abort(403, 'You do not have permission to create promo codes.');
        }
        $request->validate([
            'code' => 'required|unique:promo_codes,code',
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        PromoCode::create($request->all());

        return redirect()->route('admin.promo-codes.index')->with('success', 'Promo code created successfully.');
    }

    public function edit(PromoCode $promoCode)
    {
        // edit
        if (!auth()->user()->hasPermission('edit_promo_codes')) {
            abort(403, 'You do not have permission to edit promo codes.');
        }
        return view('admin.promo-codes.edit', compact('promoCode'));
    }

    public function update(Request $request, PromoCode $promoCode)
    {
        // edit
        if (!auth()->user()->hasPermission('edit_promo_codes')) {
            abort(403, 'You do not have permission to edit promo codes.');
        }
        $request->validate([
            'code' => 'required|unique:promo_codes,code,' . $promoCode->id,
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $promoCode->update($request->all());

        return redirect()->to('/admin/promo-codes')->with('success', 'Promo code updated successfully.');
    }

    public function destroy(PromoCode $promoCode)
    {
        // delete
        if (!auth()->user()->hasPermission('delete_promo_codes')) {
            abort(403, 'You do not have permission to delete promo codes.');
        }
        $promoCode->delete();
        return redirect()->route('admin.promo-codes.index')->with('success', 'Promo code deleted successfully.');
    }

    // sendPromoCode
    public function sendPromoCode()
    {
        if (!auth()->user()->hasPermission('browse_promo_codes')) {
            abort(403, 'You do not have permission to send promo codes.');
        }
        $promoCodes = PromoCode::all();
        return view('admin.promo-codes.send-promo-code', compact('promoCodes'));
    }

    // sendPromoCodeEmail
    public function sendPromoCodeEmail(Request $request)
    {
        if (!auth()->user()->hasPermission('browse_promo_codes')) {
            abort(403, 'You do not have permission to send promo codes.');
        }
        $request->validate([
            'users' => 'required|array',
            'promo_code_id' => 'required|exists:promo_codes,id',
        ]);

        $promoCode = PromoCode::findOrFail($request->promo_code_id);

        // dd($request->users, $promoCode);

        dispatch(new SendPromoCodeEmailJob($request->users, $promoCode));

        return redirect()->route('admin.promo-codes.index')->with('message', 'Promo code email sent successfully!');

    }
}
