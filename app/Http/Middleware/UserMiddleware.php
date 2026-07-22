<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Si admin essaie d'accéder aux pages user → rediriger vers admin
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Accès réservé aux utilisateurs.');
        }

        return $next($request);
    }
}