<?php

namespace App\Http\Middlewares;

use App\Traits\Shared\HttpError;
use App\Traits\Shared\HttpLaravelResponse;
use App\Traits\Shared\HttpMeta;
use App\Traits\Shared\HttpResource;
use App\Traits\Shared\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleMiddleware
{
    use HttpError, HttpResource, HttpLaravelResponse, HttpMeta, HttpResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (current_user()->role->key != $role) {
            return $this->respondWithError('Unauthorized');
        }

        return $next($request);
    }
}
