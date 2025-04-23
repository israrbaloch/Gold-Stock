<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // Display a listing of accounts
    public function index()
    {
        $accounts = Account::paginate(10);
        return view('admin.accounts.index', compact('accounts'));
    }

    // Show the form for creating a new account
    public function create()
    {
        return view('admin.accounts.create');
    }

    // Store a newly created account
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'number' => 'required|string',
            // Add other fields as needed
        ]);

        Account::create($data);
        return redirect()->route('admin.accounts.index')->with('success', 'Account created successfully!');
    }

    // Display the specified account
    public function show(Account $account)
    {
        return view('admin.accounts.show', compact('account'));
    }

    // Show the form for editing the specified account
    public function edit(Account $account)
    {
        return view('admin.accounts.edit', compact('account'));
    }

    // Update the specified account
    public function update(Request $request, Account $account)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'number' => 'required|string',
            // Add other fields as needed
        ]);

        $account->update($data);
        return redirect()->route('admin.accounts.index')->with('success', 'Account updated successfully!');
    }

    // Remove the specified account
    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Account deleted successfully!');
    }
}

