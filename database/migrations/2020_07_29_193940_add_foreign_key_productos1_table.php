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
       /*  Schema::table('productos', function (Blueprint $table) {
            $table->integer('id_proveedores')->unsigned()->nullable();
            $table->foreign('id_proveedores')->references('id')->on('proveedores')->onDelete('set null');
        }); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       /*  Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign('productos_id_proveedores_foreign');
        }); */
    }
}
