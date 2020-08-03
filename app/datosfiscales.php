<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class datosfiscales extends Model
{
    protected $table = "datosfiscales";
    protected $fillable = [
        'id', 'nombre',
        'rfc',
        'direccion'
        
    ];
}
