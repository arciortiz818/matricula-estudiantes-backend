<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCiudades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Ciudades', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',10);
            $table->string('nombre',60);
            $table->unsignedBigInteger('idDepartamento');

            //Foráneas
            $table->foreign('idDepartamento')->references('id')->on('Departamentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Ciudades', function (Blueprint $table) {
            //
        });
    }
}
