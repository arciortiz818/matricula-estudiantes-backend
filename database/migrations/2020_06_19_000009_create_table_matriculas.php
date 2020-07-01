<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMatriculas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Matriculas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_matricula');
            $table->date('fecha_limite');
            $table->double('valor_matricula',18,2);
            $table->double('valor_descuento',18,2);
            $table->tinyInteger('pagado');
            $table->unsignedBigInteger('idEstudiante');
            $table->unsignedBigInteger('idPrograma');
            $table->timestamps();

            //Foráneas
            $table->foreign('idEstudiante')->references('id')->on('Estudiantes');
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
        Schema::drop('Matriculas', function (Blueprint $table) {
            //
        });
    }
}
