<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyProductos1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('detalle_cotizacion', function (Blueprint $table) {
            $table->integer('id_cotizacion')->unsigned()->nullable(); /* foreign key detalle cotizacion */
            $table->foreign('id_cotizacion')->references('id')->on('cotizaciones')->onDelete('set null');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_cotizacion', function (Blueprint $table) {
            $table->dropForeign('detalle_cotizacion_id_cotizacion_foreign');
        });
    }
}
