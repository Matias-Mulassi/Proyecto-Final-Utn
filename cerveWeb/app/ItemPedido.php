<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $table = "items_pedidos";

    protected $fillabel = [
                            'id',
                            'cantidad',
                            'id_pedido',
                            'id_cerveza',
                            'deleted_at'
];

public function pedido()
    {
        //return $this->belongsTo('Name of the model that is related to',"foreign key"-attribute");
        return $this->belongsTo('App\Pedido',"id_pedido");

    }

public function cerveza()
{
    //return $this->belongsTo('Name of the model that is related to',"foreign key"-attribute");
    return $this->belongsTo('App\Cerveza',"id_cerveza");

}

}
