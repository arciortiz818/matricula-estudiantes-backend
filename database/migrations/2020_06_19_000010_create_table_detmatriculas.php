<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDetmatriculas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DetMatriculas', function (Blueprint $table) {
            $table->id();
            $table->double('valor_materia',18,2);
            $table->double('descuento_materia',18,2);
            $table->integer('creditos');
            $table->unsignedBigInteger('idMatricula');
            $table->unsignedBigInteger('idMateria');
            $table->timestamps();
            
            //Foráneas
            $table->foreign('idMatricula')->references('id')->on('Matriculas');
            $table->foreign('idMateria')->references('id')->on('Materias');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('DetMatriculas', function (Blueprint $table) {
            //
        });
    }
}
