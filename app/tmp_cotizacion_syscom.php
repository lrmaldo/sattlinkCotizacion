<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tmp_cotizacion_syscom extends Model
{
    protected $table = 'tmp_cotizacion_syscoms';
   
    protected $fillable = [
     'id', 'tmp_cantidad_syscom','tmp_precio_syscom',
     'tmp_id_producto_syscom', 'tmp_unidad_syscom','tmp_titulo_syscom',
     'session_id'
 ];

 /* 
  $table->bigIncrements('id');
            $table->integer('tmp_cantidad_syscom');
            $table->float('tmp_precio_syscom',10,2);
            $table->integer('tmp_id_producto_syscom')->nullable();
            $table->string('tmp_unidad_syscom')->nullable();
            $table->text('tmp_titulo_syscom')->nullable();
            $table->string('session_id',100)->nullable();
 */
}
