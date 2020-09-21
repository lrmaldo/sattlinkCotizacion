<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class DetalleCotizacionMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_cotizacion', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->integer('cantidad');
            $table->float('precio',10,2);
            $table->integer('id_producto')->unsigned()->nullable();
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade'); 
            /* set null */
            
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
        Schema::dropIfExists('detalle_cotizacion');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
