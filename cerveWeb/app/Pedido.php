<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = "pedidos";

    protected $fillabel = [
                            'id',
                            'estado',
                            'fecha_entrega',
                            'id_usuario',
                            'deleted_at'
];


public function usuario()
  {
      //return $this->belongsTo('Name of the model that is related to',"foreign key"-attribute");
      return $this->belongsTo('App\User',"id_usuario");

  }

public function itemsPedidos()
{
  return $this->hasMany('App\ItemPedido','id_pedido');
}

}
