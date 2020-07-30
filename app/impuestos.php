<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class impuestos extends Model
{
 protected $table = "impuestos";
    protected $fillable = [
        'id', 'cantidad',

    ];
}
