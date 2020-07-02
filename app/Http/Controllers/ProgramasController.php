<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Programas;
use App\Http\Validators\ProgramasValidator;

class ProgramasController extends Controller
{
    protected $validator;

    public function __construct(){
        $this->validator = new ProgramasValidator();
    }
    
    public function getProgramas()
    {
        $programas = Programas::All();
        return response()->json([
            'success' => 'true',
            'data' => $programas
        ],200);
    }

    //Post
    public function addPrograma(Request $request)
    {
        
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Programas::where('codigo',request('codigo'))->first();

        if($exists !== null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código de programa ya se encuentra registrado.'
            ],400);
        }

        $programa = new Programas();
        $programa->codigo = request('codigo');
        $programa->nombre = request('nombre');
        $programa->valor_nivel = request('valor_nivel');
        $programa->numero_niveles = request('numero_niveles');
        $programa->save();

        return response()->json([
            'success' => 'true',
            'message'=> 'Registro insertado con éxito.'
        ],200);
    }

    //get
    public function getPrograma($id)
    {
        $programa = Programas::find($id);
        return response()->json([
            'success' => 'true',
            'data' => $programa
        ],200);
    }

    //put,patch
    public function updatePrograma(Request $request, $id)
    {
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Programas::where('codigo',request('codigo'))->first();
        
        if($exists !== null && $exists->id != $id ) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código de programa ya se encuentra registrado.'
            ],400);
        }

        $programa = Programas::find($id);

        if($programa === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Programa no existe.'
            ],400);
        }

        $programa->codigo = request('codigo');
        $programa->nombre = request('nombre');
        $programa->valor_nivel = request('valor_nivel');
        $programa->numero_niveles = request('numero_niveles');
        $programa->update();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro actualizado con éxito.'
        ],200);
    }

    //delete
    public function deletePrograma($id)
    {
        $programa = Programas::find($id);

        if($programa === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Programa no existe.'
            ],400);
        }

        $programa->delete();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro eliminado con éxito.'
        ],200);
    }
}
