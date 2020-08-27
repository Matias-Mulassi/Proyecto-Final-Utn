<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use App\Pedido;

use Closure;

class PrioridadMiddleware
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
        switch (auth()->user()->prioridad) {
            case 1:
                $message = 'Usted no posee beneficios de compras en cuenta Corriente, debe pagar su pedido';
                return \Redirect::route('catalogoCervezas')->with('messageError', $message);
                break;
            case 2:
            $pedidos = Pedido::where('id_usuario','=',auth()->user()->id)->where('deleted_at',null)->get();
                if(count($pedidos)>=1)
                {
                    $message = 'Usted excedió la cantidad de pedidos a realizar sin abonar. Abone sus facturas vencidas';
                    return \Redirect::route('catalogoCervezas')->with('messageError', $message);
                    break;
                }
                else
                {
                    return $next($request);
                    break;
                }
            
            case 3:
                $pedidos = Pedido::where('id_usuario','=',auth()->user()->id)->where('deleted_at',null)->get();
                if(count($pedidos)>=3)
                {
                    $message = 'Usted excedió la cantidad de pedidos a realizar sin abonar. Abone sus facturas vencidas';
                    return \Redirect::route('catalogoCervezas')->with('messageError', $message);
                    break;
                }
                else
                {
                    return $next($request);
                    break;
                }
                
        }

        return $next($request);
    }
}
