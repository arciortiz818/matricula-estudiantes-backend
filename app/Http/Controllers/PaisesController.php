<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paises;
use App\Http\Validators\PaisesValidator;

class PaisesController extends Controller
{
    protected $validator;

    public function __construct(){
        $this->validator = new PaisesValidator();
    }
    
    public function getPaises()
    {
        $paises = Paises::All();
        return response()->json([
            'success' => 'true',
            'data' => $paises
        ],200);
    }

    //Post
    public function addPais(Request $request)
    {
        
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Paises::where('codigo',request('codigo'))->first();

        if($exists !== null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código de país ya se encuentra registrado.'
            ],400);
        }

        $pais = new Paises();
        $pais->codigo = request('codigo');
        $pais->nombre = request('nombre');
        $pais->save();

        return response()->json([
            'success' => 'true',
            'message'=> 'Registro insertado con éxito.'
        ],200);
    }

    //get
    public function getPais($id)
    {
        $pais = Paises::find($id);
        return response()->json([
            'success' => 'true',
            'data' => $pais
        ],200);
    }

    //put,patch
    public function updatePais(Request $request, $id)
    {
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Paises::where('codigo',request('codigo'))->first();

        if($exists !== null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código de país ya se encuentra registrado.'
            ],400);
        }

        $pais = Paises::find($id);

        if($pais === null){
            return response()->json([
                'success' => 'false',
                'message' => 'País no existe.'
            ],400);
        }

        $pais->codigo = request('codigo');
        $pais->nombre = request('nombre');
        $pais->update();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro actualizado con éxito.'
        ],200);
    }

    //delete
    public function deletePais($id)
    {
        $pais = Paises::find($id);

        if($pais === null){
            return response()->json([
                'success' => 'false',
                'message' => 'País no existe.'
            ],400);
        }

        $pais->delete();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro eliminado con éxito.'
        ],200);
    }

    
    
}
