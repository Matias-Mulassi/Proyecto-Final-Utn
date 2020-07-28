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
    						'deleted_at'
    					  ];
}
