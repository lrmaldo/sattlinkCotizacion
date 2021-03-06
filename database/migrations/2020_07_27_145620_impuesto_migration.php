<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImpuestoMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impuesto', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->float('cantidad',8,2);
            $table->float('tipo_cambio_syscom',8,2)->nullable()->comment('tipo de cambio de syscom se guarda cada vez que se consulta');
            $table->integer('utilidad')->nullable()->comment('porcentaje de utilidad de ganancia de syscom');
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
        Schema::dropIfExists('impuesto');
    }
}
