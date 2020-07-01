<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Validators\CiudadesValidator;
use App\Ciudades;
use App\Departamentos;

class CiudadesController extends Controller
{
    protected $validator;

    public function __construct(){
        $this->validator = new CiudadesValidator();
    }
    
    public function getCiudades()
    {
        $data = Ciudades::select('ciudades.*','departamentos.codigo as codDepartamento','departamentos.nombre as nomDepartamento')
                            ->join('departamentos','ciudades.idDepartamento','=','departamentos.id')
                            ->get();

        $ciudades = $this->armarRespuesta($data);
        

        return response()->json([
            'success' => 'true',
            'data' => $ciudades
        ],200);
    }

    //Post
    public function addCiudad(Request $request)
    {
        
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Departamentos::find(request('idDepartamento'));

        if($exists === null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El departamento no existe.'
            ],400);
        }

        $exists = Ciudades::where('codigo',request('codigo'))->first();

        if($exists !== null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código para la ciudad ya se encuentra registrado.'
            ],400);
        }

        $ciudad = new Ciudades();
        $ciudad->codigo = request('codigo');
        $ciudad->nombre = request('nombre');
        $ciudad->iddepartamento = request('idDepartamento');
        $ciudad->save();

        return response()->json([
            'success' => 'true',
            'message'=> 'Registro insertado con éxito.'
        ],200);
    }

    //get
    public function getCiudad($id)
    {
        $data = Ciudades::select('ciudades.*','departamentos.codigo as codDepartamento','departamentos.nombre as nomDepartamento')
                            ->join('departamentos','ciudades.idDepartamento','=','departamentos.id')
                            ->where('ciudades.id','=',$id)
                            ->get();

        $ciudad = $this->armarRespuesta($data);

        return response()->json([
            'success' => 'true',
            'data' => $ciudad
        ],200);
    }

    //put,patch
    public function updateCiudad(Request $request, $id)
    {
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Departamentos::find(request('idDepartamento'));

        if($exists === null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El departamento no existe.'
            ],400);
        }

        $exists = Ciudades::where('codigo',request('codigo'))->first();

        if($exists !== null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código para la ciudad ya se encuentra registrado.'
            ],400);
        }

        $ciudad = Ciudades::find($id);

        if($ciudad === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Ciudad no existe.'
            ],400);
        }

        $ciudad->codigo = request('codigo');
        $ciudad->nombre = request('nombre');
        $ciudad->iddepartamento = request('idDepartamento');
        $ciudad->update();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro actualizado con éxito.'
        ],200);
    }

    //delete
    public function deleteCiudad($id)
    {
        $ciudad = Ciudades::find($id);

        if($ciudad === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Ciudad no existe.'
            ],400);
        }
        
        $ciudad->delete();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro eliminado con éxito.'
        ],200);
    }

    protected function armarRespuesta($data){
        
        $tempo = [];

        foreach ($data as $row) {
            $departamento = [
                'id' => $row->idDepartamento,
                'codigo' => $row->codDepartamento,
                'nombre' => $row->nomDepartamento
            ];

            $tmp = [
                'id' => $row->id,
                'codigo' => $row->codigo,
                'nombre' => $row->nombre,
                'departamento' => $departamento
            ];

            array_push($tempo,$tmp);
        }

        return $tempo;
    }
}
