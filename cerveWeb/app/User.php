<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['id', 'nombre', 'apellido', 'email', 'password','id_tipo_usuario','deleted_at', 'cuitcuil', 'razonSocial', 'condicionIVA', 'direcciónEntrega', 'prioridad', 'telefono', 
];
    


    public function tipo_usuario()
    {
        //return $this->belongsTo('Name of the model that is related to',"foreign key"-attribute");
        return $this->belongsTo('App\TiposUsuarios',"id_tipo_usuario");

    }

    public function pedidos()
    {
    	return $this->hasMany('App\Pedido','id_pedido');
    }	

    public function mensajes()
    {
    	return $this->hasMany('App\Mensaje','id_mensaje');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
