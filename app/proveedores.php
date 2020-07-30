<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proveedores extends Model
{
    protected $table = "proveedores";
    protected $fillable = [
        'id', 'nombre',
        'estatus',
       
    ];

}
