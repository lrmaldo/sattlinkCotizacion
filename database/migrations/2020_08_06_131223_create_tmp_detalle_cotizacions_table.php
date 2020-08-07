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
            $table->increments('id');
            $table->integer('tmp_cantidad');
            $table->float('tmp_precio',10,2);
            $table->integer('tmp_id_producto');
            $table->string('session_id',100)->nullable();
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