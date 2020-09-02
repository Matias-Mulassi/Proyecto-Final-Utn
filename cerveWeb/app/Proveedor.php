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
}
