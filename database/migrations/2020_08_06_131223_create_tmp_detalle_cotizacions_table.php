<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmpDetalleCotizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_detalle_cotizacion', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigIncrements('id');
            $table->integer('tmp_cantidad');
            $table->float('tmp_precio',10,2);
            $table->integer('tmp_id_producto')->nullable();
            $table->string('session_id',100)->nullable();
          //  $table->tinyInteger('syscom')->comment('sirve para diferenciar si es de syscom o no');
            //$table->integer('id_producto_syscom')->nullable()->comment('se almacena el id del producto syscom para futuras actualizaciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmp_detalle_cotizacion');
    }
}
