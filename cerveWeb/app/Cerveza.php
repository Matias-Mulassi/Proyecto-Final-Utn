<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cerveza extends Model
{
    protected $table = "cervezas";
    
    protected $fillabel = [
                            'id',
                            'nombre',
                            'descripcion',
                            'ventaLimite',
                            'desperdicio',
                            'cantidadStock',
                            'puntoPedido',
                            'loteOptimo',
                            'image',
                            'id_categoria',
    						'deleted_at'
                ];
                

  public function categoria()
  {
      //return $this->belongsTo('Name of the model that is related to',"foreign key"-attribute");
      return $this->belongsTo('App\Categoria',"id_categoria");

  }           
  
  public function historico_precios()
  {
    return $this->hasMany('App\HistoricoPrecio','id_cerveza');
  }

  public function itemsPedidos()
  {
    return $this->hasMany('App\ItemPedido','id_cerveza');
  }

  public function compras()
  {
    return $this->hasMany('App\Compra','id_cerveza');
  }
}


