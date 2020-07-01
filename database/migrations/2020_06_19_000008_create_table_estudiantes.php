<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEstudiantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('documento',20)->unique();
            $table->string('nombre1',60);
            $table->string('nombre2',60);
            $table->string('apellido1',60);
            $table->string('apellido2',60);
            $table->string('direccion',120)->nullable();
            $table->string('barrio',60)->nullable();
            $table->string('telefono_casa',15)->nullable();
            $table->string('telefono_oficina',15)->nullable();
            $table->string('celular',15)->nullable();
            $table->string('email',80);
            $table->date('fecha_nacimiento');
            $table->unsignedBigInteger('idTipo_Documento');
            $table->unsignedBigInteger('idDepartamento');
            $table->unsignedBigInteger('idCiudad');
            $table->unsignedBigInteger('idPais');
            $table->timestamps();

            //Llaves foráneas
            $table->foreign('idTipo_Documento')->references('id')->on('TipoDocumento');
            $table->foreign('idDepartamento')->references('id')->on('Departamentos');
            $table->foreign('idCiudad')->references('id')->on('Ciudades');
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
        Schema::drop('Estudiantes', function (Blueprint $table) {
            //
        });
    }
}
