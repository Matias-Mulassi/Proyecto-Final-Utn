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
                            'precio',
                            'image',
                            'id_categoria',
    						'deleted_at'
                ];
                

  public function categoria()
  {
      //return $this->belongsTo('Name of the model that is related to',"foreign key"-attribute");
      return $this->belongsTo('App\Categoria',"id_categoria");

  }                
}


