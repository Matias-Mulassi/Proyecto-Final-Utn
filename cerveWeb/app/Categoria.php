<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = "categorias";
    
    protected $fillabel = [
                            'id',
                            'nombre',
                            'descripcion',
    						'deleted_at'
    					  ];
    
    public function cervezas()
    {
    	return $this->hasMany('App\Cerveza');
    }					  
}
