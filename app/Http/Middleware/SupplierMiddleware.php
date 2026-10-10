<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SupplierMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array(session('login_type'), ['supplier', 'subsupplier'])) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}