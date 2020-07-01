<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nit',20);
            $table->string('razon_social',80);
            $table->tinyInteger('valor_x_semestre');
            $table->tinyInteger('valor_x_materias');
            $table->string('cuenta_bancaria',30);
            $table->string('banco_cuenta_bancaria',60);
            $table->string('direccion',120);
            $table->string('barrio',60);
            $table->string('telefonos',20);
            $table->string('ciudad',60);
            $table->string('departamento',60);
            $table->string('pais',60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Empresa', function (Blueprint $table) {
            //
        });
    }
}
