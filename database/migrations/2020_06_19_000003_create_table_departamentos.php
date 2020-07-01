<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDepartamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',10);
            $table->string('nombre',60);
            $table->unsignedBigInteger('idPais');

            //Foráneas
            $table->foreign('idPais')->references('id')->on('Paises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Departamentos', function (Blueprint $table) {
            //
        });
    }
}
