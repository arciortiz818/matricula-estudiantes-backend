<?php

namespace App\Http\Validators;
use Illuminate\Http\Request;
use Validator;

class EstudiantesValidator
{
    private $rules;
    private $messages;

    public function __construct(){
        $this->rules = [
            'documento' => 'required',
            'nombre1' => 'required',
            'nombre2' => 'required',
            'apellido1' => 'required',
            'apellido2' => 'required',
            'direccion' => 'required',
            'barrio' => 'nullable',
            'telefono_cas' => 'nullable',
            'telefono_oficina' => 'nullable',
            'celular' => 'nullable',
            'email' => 'required|email',
            'fecha_nacimiento' => 'nullable|dateformat:Y-m-d',
            'idTipo_Documento' => 'required',
            'idDepartamento' => 'required',
            'idCiudad' => 'required',
            'idPais' => 'required'
        ];
        $this->messages = [
            'required' => 'El campo :attribute es requerido.',
            'email' => 'El campo :attribute debe ser un email válido.'
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
