<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ProductosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->string('nombre');
            $table->string('codigo')->nullable();
            $table->string('unidad')->comment('tipo de unidad');
            $table->string('estatus')->default('activo')->comment('activar o desactivar producto');
            $table->float('precio');
           
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
        Schema::dropIfExists('productos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
