<?php

namespace App\Http\Middleware;

use App\Traits\Shared\HttpError;
use App\Traits\Shared\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleMiddleware
{
    use HttpError, HttpResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (current_user()->role_id != $role) {
            return $this->respondWithError('Unauthorized');
        }

        return $next($request);
    }
}
