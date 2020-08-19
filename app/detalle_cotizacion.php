<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_cotizacion extends Model
{
   protected $table = 'detalle_cotizacion';
   
   protected $fillable = [
    'id', 'cantidad','precio',
    'id_producto'/* foreign key */
];
public function producto(){
    return $this->belongsTo(productos::class,'id_producto');
}

}
