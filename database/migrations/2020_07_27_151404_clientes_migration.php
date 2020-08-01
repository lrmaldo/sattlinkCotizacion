<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ClientesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->string('nombre');
            $table->string('rfc')->nullable();
            $table->string('estatus')->default('activo')->comment('activar o desactivar producto');
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono');
            $table->double('descuento',8,2);
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
        Schema::dropIfExists('clientes');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
