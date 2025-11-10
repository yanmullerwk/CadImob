<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HandleActivateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Se estiver logado e desativado
        if ($user && $user->activate === 'N') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Sua conta foi desativada. Contate o administrador.',
            ]);
        }

        return $next($request);
    }
}
