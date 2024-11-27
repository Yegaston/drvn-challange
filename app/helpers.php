<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('current_user')) {
    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User|null
     */
    function current_user(): \App\Models\User
    {
        return Auth::user();
    }
}
