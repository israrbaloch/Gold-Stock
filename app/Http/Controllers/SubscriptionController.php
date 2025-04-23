<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use Auth;
use Illuminate\Http\Request;

class SubscriptionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubscriptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriptionRequest $request) {

        // check is is auth
        if (Auth::check()) {
            // check if the user is already subscribed
            if (Auth::user()->subscribed) {
                return response()->json(['message' => 'You are already subscribed'], 400);
            } else {
                Auth::user()->subscribed = true;
                Auth::user()->save();
            }
        } else {
            $subscription = new Subscription();
            $subscription->email = $request->email;
            $subscription->save();
        }

        return response()->json($subscription, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubscriptionRequest  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription) {
        $subscription->subscribed = false;
        $subscription->save();

        return response()->json([
            'message' => 'Subscription deleted successfully'
        ], 200);
    }

    public function subscribe(Request $request) {

        // check is is auth
        if (Auth::check()) {
            switch ($request->type) {
                case 'news':
                    if (Auth::user()->news_subscribed) {
                        return response()->json(['message' => 'You are already subscribed'], 400);
                    } else {
                        Auth::user()->news_subscribed = true;
                    }
                    break;
                case 'blogs':
                    if (Auth::user()->blogs_subscribed) {
                        return response()->json(['message' => 'You are already subscribed'], 400);
                    } else {
                        Auth::user()->blogs_subscribed = true;
                    }
                    break;
                case 'promo':
                    if (Auth::user()->promo_subscribed) {
                        return response()->json(['message' => 'You are already subscribed'], 400);
                    } else {
                        Auth::user()->promo_subscribed = true;
                    }
                    break;
                default:
                    return response()->json(['message' => 'Invalid subscription type'], 400);
                    break;
            }
            Auth::user()->save();
        }

        return response()->json([
            'message' => 'Subscription created successfully'
        ], 201);
    }

    public function unsubscribe(Request $request) {

        // check is is auth
        if (Auth::check()) {
            switch ($request->type) {
                case 'news':
                    if (!Auth::user()->news_subscribed) {
                        return response()->json(['message' => 'You are already unsubscribed'], 400);
                    } else {
                        Auth::user()->news_subscribed = false;
                    }
                    break;
                case 'blogs':
                    if (!Auth::user()->blogs_subscribed) {
                        return response()->json(['message' => 'You are already unsubscribed'], 400);
                    } else {
                        Auth::user()->blogs_subscribed = false;
                    }
                    break;
                case 'promo':
                    if (!Auth::user()->promo_subscribed) {
                        return response()->json(['message' => 'You are already unsubscribed'], 400);
                    } else {
                        Auth::user()->promo_subscribed = false;
                    }
                    break;
                default:
                    return response()->json(['message' => 'Invalid subscription type'], 400);
                    break;
            }
            Auth::user()->save();
        }

        return response()->json([
            'message' => 'Subscription deleted successfully'
        ], 200);
    }
}
