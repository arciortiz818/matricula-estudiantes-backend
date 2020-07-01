<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoDocumento;
use App\Http\Validators\TipoDocumentoValidator;

class TipoDocumentoController extends Controller
{
    protected $validator;

    public function __construct(){
        $this->validator = new TipoDocumentoValidator();
    }
    
    public function getTiposDocumento()
    {
        $tiposDocumento = TipoDocumento::All();
        return response()->json([
            'success' => 'true',
            'data' => $tiposDocumento
        ],200);
    }

    //Post
    public function addTipoDocumento(Request $request)
    {
        
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = TipoDocumento::where('codigo',request('codigo'))->first();

        if($exists !== null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código para el tipo de documento ya se encuentra registrado.'
            ],400);
        }

        $tipoDocumento = new TipoDocumento();
        $tipoDocumento->codigo = request('codigo');
        $tipoDocumento->nombre = request('nombre');
        $tipoDocumento->save();

        return response()->json([
            'success' => 'true',
            'message'=> 'Registro insertado con éxito.'
        ],200);
    }

    //get
    public function getTipoDocumento($id)
    {
        $tipoDocumento = TipoDocumento::find($id);
        return response()->json([
            'success' => 'true',
            'data' => $tipoDocumento
        ],200);
    }

    //put,patch
    public function updateTipoDocumento(Request $request, $id)
    {
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = TipoDocumento::where('codigo',request('codigo'))->first();

        if($exists !== null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código para el tipo de documento ya se encuentra registrado.'
            ],400);
        }

        $tipoDocumento = TipoDocumento::find($id);

        if($tipoDocumento === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Tipo Documento no existe.'
            ],400);
        }

        $tipoDocumento->codigo = request('codigo');
        $tipoDocumento->nombre = request('nombre');
        $tipoDocumento->update();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro actualizado con éxito.'
        ],200);
    }

    //delete
    public function deleteTipoDocumento($id)
    {
        $tipoDocumento = TipoDocumento::find($id);

        if($tipoDocumento === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Tipo Documento no existe.'
            ],400);
        }
        
        $tipoDocumento->delete();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro eliminado con éxito.'
        ],200);
    }
}
