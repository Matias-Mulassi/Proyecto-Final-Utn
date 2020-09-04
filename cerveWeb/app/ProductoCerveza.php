<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoCerveza extends Model
{
    protected $table = "productos_cervezas";
  
    protected $fillabel = [
                            'id',
                            'nombre',
                            'costo',
                            'image',
                            'deleted_at'
                            ];

    public function proveedores()
    {
        return $this->belongsToMany('App\Proveedor');
    }

}
