<?php

namespace App\Http\Validators;
use Illuminate\Http\Request;
use Validator;

class MatriculasValidator
{
    private $rules;
    private $messages;

    public function __construct(){
        $this->rules = [
            'codigo' => 'required',
            'nombre' => 'required'
        ];
        $this->messages = [
            'required' => 'El campo :attribute es requerido.'
        ];
    }

    public function validar(Request $req){
        $validator = Validator::make($req->all(),$this->rules,$this->messages);

        if($validator->fails()){
            return [
                'success' => 'false',
                'message' => 'Error de validación.',
                'errors' => $validator->errors()
            ];
        }
        return null;
    }

    
}
