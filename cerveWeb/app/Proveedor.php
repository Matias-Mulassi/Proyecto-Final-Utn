<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
  protected $table = "proveedores";
  
  protected $fillabel = [
                          'id',
                          'cuit',
                          'razonSocial',
                          'email',
                          'telefono',
                          'deleted_at'
                        ];

  public function productos_cervezas()
  {
      return $this->belongsToMany('App\ProductoCerveza','proveedores_cervezas','id_proveedor','id_producto_cerveza');
  }


}
