<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoPrecio extends Model
{
    protected $table = "historico_precios";
    
    protected $fillabel = [
                            'id',
                            'fecha_vigencia',
                            'precio',
                            'id_cerveza',
                ];


    public function cerveza()
    {
        //return $this->belongsTo('Name of the model that is related to',"foreign key"-attribute");
        return $this->belongsTo('App\Cerveza',"id_cerveza");
    
    }
}
