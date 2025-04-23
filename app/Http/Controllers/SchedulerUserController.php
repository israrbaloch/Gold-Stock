<?php

namespace App\Http\Controllers;

use App\Models\SchedulerUser;
use App\Http\Requests\StoreSchedulerUserRequest;
use App\Http\Requests\UpdateSchedulerUserRequest;

class SchedulerUserController extends Controller {
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
     * @param  \App\Http\Requests\StoreSchedulerUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchedulerUserRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchedulerUser  $schedulerUser
     * @return \Illuminate\Http\Response
     */
    public function show(SchedulerUser $schedulerUser) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchedulerUser  $schedulerUser
     * @return \Illuminate\Http\Response
     */
    public function edit(SchedulerUser $schedulerUser) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSchedulerUserRequest  $request
     * @param  \App\Models\SchedulerUser  $schedulerUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSchedulerUserRequest $request, SchedulerUser $schedulerUser) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchedulerUser  $schedulerUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchedulerUser $schedulerUser) {
        //
    }
}
