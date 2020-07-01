<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materias extends Model
{
    protected $table = 'materias';

    protected $attributes = [
        'valor_credito' => 0,
        'valor_materia' => 0,
        'porc_descuento' => 0
    ];

}
