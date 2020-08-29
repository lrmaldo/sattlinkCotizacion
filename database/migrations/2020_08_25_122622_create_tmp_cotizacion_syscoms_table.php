<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmpCotizacionSyscomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_cotizacion_syscoms', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigIncrements('id');
            $table->integer('tmp_cantidad_syscom');
            $table->float('tmp_precio_syscom',10,2);
            $table->integer('tmp_id_producto_syscom')->nullable();
            $table->string('tmp_unidad_syscom')->nullable();
            $table->text('tmp_titulo_syscom')->nullable();
            $table->string('session_id',100)->nullable();
            //$table->tinyInteger('syscom')->comment('sirve para diferenciar si es de syscom o no');
            //$table->integer('id_producto_syscom_s')->nullable()->comment('se almacena el id del producto syscom para futuras actualizaciones');
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
        Schema::dropIfExists('tmp_cotizacion_syscoms');
    }
}
