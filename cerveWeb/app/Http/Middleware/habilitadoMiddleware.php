<?php

namespace App\Http\Middleware;

use Closure;

class habilitadoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(isset(Auth::user()->deleted_at))
        {
            return view('Usuario.noHabilitado');
        }
        else
        {
        return $next($request);
        }
    }
}
