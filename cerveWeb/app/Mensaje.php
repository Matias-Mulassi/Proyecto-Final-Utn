<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = "mensajes";

    protected $fillabel = [
                            'id',
                            'id_usuario',
                            'leido',
                            'procesado',
                            'cuerpo'

                        ];

    public function usuario()
    {
        //return $this->belongsTo('Name of the model that is related to',"foreign key"-attribute");
        return $this->belongsTo('App\User',"id_usuario");
    
    }
}
