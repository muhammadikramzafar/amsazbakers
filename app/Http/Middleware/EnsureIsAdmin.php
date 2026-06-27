<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->hasAnyRole(['super-admin', 'admin', 'content-editor'])) {
            abort(403, 'You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}
