<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = "compras";
    
    protected $fillabel = [
                            'id',
                            'fecha',
                            'cantidad',
                            'total',
                            'efectiva',
                            'id_proveedor',
                            'id_cerveza',
                ];


    public function proveedor()
    {
        //return $this->belongsTo('Name of the model that is related to',"foreign key"-attribute");
        return $this->belongsTo('App\Proveedor',"id_proveedor");
    
    }

    public function cerveza()
    {
        //return $this->belongsTo('Name of the model that is related to',"foreign key"-attribute");
        return $this->belongsTo('App\Cerveza',"id_cerveza");
    
    }
}
