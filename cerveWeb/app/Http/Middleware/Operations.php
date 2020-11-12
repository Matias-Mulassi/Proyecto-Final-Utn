<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;

use Closure;

class Operations
{
    /**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
    public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

    /**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */



    public function handle($request, Closure $next)
    {

        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        if(auth()->user()->tipo_usuario->id != 2 | auth()->user()->tipo_usuario->id !=3){

			if(isset(auth()->user()->deleted_at))
			{
				$message = 'Permiso denegado: No posee permisos para entrar a esta sección';
				return redirect()->route('noHablitado')->with('message', $message);
			}
            switch (auth()->user()->id_tipo_usuario) {
                case 1:
                    $message = 'Permiso denegado: No posee permisos para entrar a esta sección';
                    return \Redirect::route('catalogoCervezas')->with('message', $message);
                    break;
            }

        }


        return $next($request);
    }
}
