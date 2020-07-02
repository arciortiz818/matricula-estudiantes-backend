<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Programas;
use App\Materias;
use App\Http\Validators\MateriasValidator;

class MateriasController extends Controller
{
    protected $validator;

    public function __construct(){
        $this->validator = new MateriasValidator();
    }
    
    public function getMaterias()
    {
        $data = Materias::select('materias.*','programas.codigo as codPrograma','programas.nombre as nomPrograma')
                            ->join('programas','materias.idPrograma','=','programas.id')
                            ->get();

        $materias = $data; //$this->armarRespuesta($data);
        

        return response()->json([
            'success' => 'true',
            'data' => $materias
        ],200);
    }

    public function getMateriasxPrograma($idPrograma)
    {
        $data = Materias::select('materias.*','programas.codigo as codPrograma','programas.nombre as nomPrograma')
                            ->join('programas','materias.idPrograma','=','programas.id')
                            ->where('materias.idPrograma','=',$idPrograma)
                            ->get();

        $materias = $data; //$this->armarRespuesta($data);
        

        return response()->json([
            'success' => 'true',
            'data' => $materias
        ],200);
    }

    //Post
    public function addMateria(Request $request)
    {
        
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Programas::find(request('idPrograma'));

        if($exists === null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El programa no existe.'
            ],400);
        }

        $exists = Materias::where('codigo',request('codigo'))->first();

        if($exists !== null ) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código para la materia ya se encuentra registrado.'
            ],400);
        }

        $materia = new Materias();
        $materia->codigo = request('codigo');
        $materia->nombre = request('nombre');
        $materia->nivel = request('nivel');
        $materia->creditos = request('creditos');
        $materia->valor_credito = request('valor_credito');
        $materia->valor_materia = request('valor_materia');
        $materia->porc_descuento = request('porc_descuento');
        $materia->idPrograma = request('idPrograma');
        $materia->save();

        return response()->json([
            'success' => 'true',
            'message'=> 'Registro insertado con éxito.'
        ],200);
    }

    //get
    public function getMateria($id)
    {
        $data = Materias::select('materias.*','programas.codigo as codPrograma','programas.nombre as nomPrograma')
                            ->join('programas','materias.idPrograma','=','programas.id')
                            ->where('materias.id','=',$id)
                            ->first();

        $materia = $data; //$this->armarRespuesta($data);

        return response()->json([
            'success' => 'true',
            'data' => $materia
        ],200);
    }

    //put,patch
    public function updateMateria(Request $request, $id)
    {
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Programas::find(request('idPrograma'));

        if($exists === null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El programa no existe.'
            ],400);
        }

        $exists = Materias::where('codigo',request('codigo'))->first();

        if($exists !== null && $exists->id != $id) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código para la materia ya se encuentra registrado.'
            ],400);
        }

        $materia = Materias::find($id);

        if($materia === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Materia no existe.'
            ],400);
        }

        $materia->codigo = request('codigo');
        $materia->nombre = request('nombre');
        $materia->nivel = request('nivel');
        $materia->creditos = request('creditos');
        $materia->valor_credito = request('valor_credito');
        $materia->valor_materia = request('valor_materia');
        $materia->porc_descuento = request('porc_descuento');
        $materia->idPrograma = request('idPrograma');
        $materia->update();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro actualizado con éxito.'
        ],200);
    }

    //delete
    public function deleteMateria($id)
    {
        $materia = Materias::find($id);

        if($materia === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Materia no existe.'
            ],400);
        }
        
        $materia->delete();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro eliminado con éxito.'
        ],200);
    }

    protected function armarRespuesta($data){
        
        $tempo = [];

        foreach ($data as $row) {
            $programa = [
                'id' => $row->idPrograma,
                'codigo' => $row->codPrograma,
                'nombre' => $row->nomPrograma
            ];

            $tmp = [
                'id' => $row->id,
                'codigo' => $row->codigo,
                'nombre' => $row->nombre,
                'nivel' => $row->nivel,
                'creditos' => $row->creditos,
                'valor_credito' => $row->valor_credito,
                'valor_materia' => $row->valor_materia,
                'porc_descuento' => $row->porc_descuento,
                'programa' => $programa
            ];

            array_push($tempo,$tmp);
        }

        return $tempo;
    }
}
