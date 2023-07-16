<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckRole
{

    public function handle(Request $request, Closure $next, $roles  ): Response
    {
        dd(in_array($roles));
        if (!auth()->check() || auth()->user()->role !== $role) {
            abort(403, 'Unauthorized');
        }
        // dd($request->user()->hasRole($role));
        // dd(auth()->user()->role);
        // dd($request->user()->hasRole(auth()->user()->role));
        // if (!Auth::check() || !$request->user()->hasRole(auth()->user()->role)) {
        //     abort(403, 'Unauthorized');

        // }
  
        return $next($request);
    
    }



}
