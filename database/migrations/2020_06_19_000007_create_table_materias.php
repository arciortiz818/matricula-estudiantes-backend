<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMaterias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Materias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',10);
            $table->string('nombre',60);
            $table->integer('nivel');
            $table->integer('creditos');
            $table->double('valor_credito',18,2);
            $table->double('valor_materia',18,2);
            $table->integer('porc_descuento');
            $table->unsignedBigInteger('idPrograma');
            $table->timestamps();
            
            //Foráneas
            $table->foreign('idPrograma')->references('id')->on('Programas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Materias', function (Blueprint $table) {
            //
        });
    }
}
