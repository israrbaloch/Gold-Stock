<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionListRequest;
use App\Http\Requests\UpdateSubscriptionListRequest;
use App\Models\SubscriptionList;
use App\Models\SubscriptionListUser;
use App\Models\User;
use Illuminate\Http\Request;
use Log;

class SubscriptionListController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $all = SubscriptionList::all();
        return view('admin.mails.subscription.index')
            ->with('subscriptionLists', $all);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.mails.subscription.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubscriptionListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriptionListRequest $request) {
        Log::info('Creating subscription list');
        $subscriptionList = SubscriptionList::create($request->validated());

        $users = $request->users;
        $users = json_decode($request->users);
        if (!$users) {
            Log::error('Invalid users');
            return response()->json([
                'message' => 'Invalid users',
            ], 400);
        }

        foreach ($users as $user) {
            $user = User::where('id', $user)->first();
            if (!$user) {
                Log::error('User not found');
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }
            SubscriptionListUser::create([
                'subscription_list_id' => $subscriptionList->id,
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('voyager.subscription_lists.index')->with('success', 'Subscription list created successfully.');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\SubscriptionList  $subscriptionList
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(SubscriptionList $subscriptionList) {
    //     return view('admin.mails.subscription.show')->with('subscriptionList', $subscriptionList);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubscriptionList  $subscriptionList
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (auth()->user()) {
            $subscriptionList = SubscriptionList::where('id', $id)->first();
            return view('admin.mails.subscription.update')->with('subscriptionList', $subscriptionList);
        } else {
            return redirect("/admin/login");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubscriptionListRequest  $request
     * @param  \App\Models\SubscriptionList  $subscriptionList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if (auth()->user()) {
            $request->validate([
                'name' => 'required',
                'users' => 'required',
            ]);
            $subscriptionList = SubscriptionList::where('id', $id)->first();
            $subscriptionList->name = $request->name;
            $subscriptionList->save();

            $users = $request->users;
            $users = json_decode($request->users);
            if (!$users) {
                Log::error('Invalid users');
                return response()->json([
                    'message' => 'Invalid users',
                ], 400);
            }

            SubscriptionListUser::where('subscription_list_id', $subscriptionList->id)->delete();
            foreach ($users as $user) {
                $user = User::where('id', $user)->first();
                if (!$user) {
                    Log::error('User not found');
                    return response()->json([
                        'message' => 'User not found',
                    ], 404);
                }
                SubscriptionListUser::create([
                    'subscription_list_id' => $subscriptionList->id,
                    'user_id' => $user->id,
                ]);
            }

            return response()->json([
                'message' => 'Subscription list updated successfully.',
            ], 200);
        } else {
            return redirect("/admin/login");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubscriptionList  $subscriptionList
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubscriptionList $subscriptionList) {
        $subscriptionList->delete();
        return redirect()->route('voyager.subscription_lists.index')->with('success', 'Subscription list deleted successfully.');
    }
}
