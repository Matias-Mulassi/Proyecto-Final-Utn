<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoCerveza extends Model
{
    protected $table = "productos_cervezas";
  
    protected $fillabel = [
                            'id',
                            'nombre',
                            'image',
                            'deleted_at'
                            ];

    public function proveedores()
    {
        return $this->belongsToMany('App\Proveedor','cerveza_proveedor','id_producto_cerveza','id_proveedor')->withPivot('costo')->withTimestamps();
    }

}
