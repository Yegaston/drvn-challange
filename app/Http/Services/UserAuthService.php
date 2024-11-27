<?php

namespace App\Http\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserAuthService
{
    public function login(array $data)
    {
        return Auth::attempt($data);
    }

    public function register(array $data)
    {
        $data['role_id'] = Role::getUserRoleId();
        return User::create($data);
    }

    public function changeUserRole(User $user, string $role)
    {
        $user->role_id = Role::where('key', $role)->first()->id;
        $user->save();
        return $user;
    }
}
