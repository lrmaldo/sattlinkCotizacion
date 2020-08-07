<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tmp_detalle_cotizacion extends Model
{
    protected $table = 'tmp_detalle_cotizacion';
   
    protected $fillable = [
     'id', 'tmp_cantidad','tmp_precio',
     'tmp_id_producto',
     'session_id'
 ];
 /* 
            $table->integer('tmp_cantidad');
            $table->float('tmp_precio',10,2);
            $table->integer('tmp_id_producto');
            $table->string('session_id',100)->nullable();
 */
}
