<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleCotizacionSyscomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_cotizacion_syscoms', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigIncrements('id');
            $table->integer('cantidad');
            $table->float('precio',10,2);
            $table->float('precio_dolar',10,2)->nullable();
            $table->integer('id_producto_syscom')->nullable();
            $table->string('session_id',100)->nullable();
            $table->string('unidad_syscom')->nullable();
            $table->text('titulo_syscom')->nullable();
            $table->integer('id_cotizacion')->unsigned()->nullable(); /* foreign key detalle cotizacion */
            $table->foreign('id_cotizacion')->references('id')->on('cotizaciones')->onDelete('set null');
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
        Schema::dropIfExists('detalle_cotizacion_syscoms');
    }
}
