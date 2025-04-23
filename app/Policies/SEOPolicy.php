<?php

namespace App\Policies;

use App\Models\SEO;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class SEOPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user) {
        Log::debug('viewAny');
        // 
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SEO  $seo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SEO $seo) {
        Log::debug('view');
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user) {
        Log::debug('create');
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SEO  $seo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SEO $seo) {
        Log::debug('update');
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SEO  $seo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SEO $seo) {
        Log::debug('delete');
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SEO  $seo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SEO $seo) {
        Log::debug('restore');
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SEO  $seo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SEO $seo) {
        Log::debug('forceDelete');
        //
    }
}
