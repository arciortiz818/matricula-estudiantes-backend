<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProgramas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Programas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',20);
            $table->string('nombre',60);
            $table->double('valor_nivel',18,2);
            $table->integer('numero_niveles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Programas', function (Blueprint $table) {
            //
        });
    }
}
