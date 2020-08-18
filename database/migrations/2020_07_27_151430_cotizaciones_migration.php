<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CotizacionesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->string('folio');
            $table->string('forma');
            $table->text('comentario');
            $table->string('id_datosfiscales');
            $table->float('descuento',10,2);
            $table->float('total',10,2);
            $table->integer('id_vendedor')->unsigned()->nullable();/* foreign key vendedor */
            $table->foreign('id_vendedor')->references('id')->on('users')->onDelete('set null');
            $table->integer('id_cliente')->unsigned()->nullable();/* foreign key cliente */
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('set null');
           
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('cotizaciones');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
