<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserRoleRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserAuthResource;
use App\Http\Services\UserAuthService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends BaseController
{

    private UserAuthService $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    public function login(LoginUserRequest $request)
    {
        $response = $this->userAuthService->login($request->all());

        if (!$response) {
            return $this->respondWithError('Wrong credentials');
        }

        return $this->respondWithItem(current_user(), UserAuthResource::class);
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->userAuthService->register($request->all());

        return $this->respondWithItem($user, UserAuthResource::class);
    }

    public function logout()
    {
        Auth::logout();
        return $this->respondWithSuccess('Logged out successfully');
    }

    public function refresh()
    {
        return $this->respondWithItem(current_user(), UserAuthResource::class);
    }

    public function changeUserRole(User $user, ChangeUserRoleRequest $request)
    {
        $this->userAuthService->changeUserRole($user, $request->role);
        return $this->respondWithItem($user, UserAuthResource::class);
    }
}
