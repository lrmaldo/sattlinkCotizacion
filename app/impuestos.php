<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class impuestos extends Model
{
 protected $table = "impuesto";
    protected $fillable = [
        'id', 'cantidad',

    ];
}
