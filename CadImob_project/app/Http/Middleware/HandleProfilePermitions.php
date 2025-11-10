<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HandleProfilePermitions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$profiles): Response
    {
        if(!Auth::check()){
            redirect(route('login'));
        }

        $user = Auth::user();
        
        foreach($profiles as $profile){
            if($user->profile == $profile){
                return $next($request);
            }
        }
        
        abort(403, "Acesso não autorizado");
    }
}
