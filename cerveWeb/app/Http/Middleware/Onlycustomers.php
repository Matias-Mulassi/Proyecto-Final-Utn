<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;

use Closure;

class Onlycustomers
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


        if(isset(auth()->user()->deleted_at))
			{
				$message = 'Permiso denegado: Solo clientes habilitados pueden realizar pedidos';
				return redirect()->route('noHablitado')->with('message', $message);
			}

        if(auth()->user()->tipo_usuario->id != 1){

            switch (auth()->user()->id_tipo_usuario) {
                case 2:
                    $message = 'Permiso denegado: Solo clientes pueden realizar pedidos';
                    return \Redirect::route('home')->with('message', $message);
                    break;
                case 3:
                    $message = 'Permiso denegado: Solo clientes pueden realizar pedidos';
                    return \Redirect::route('home')->with('message', $message);
                    break;
            }

        }


        return $next($request);
    }
}
