<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamentos;
use App\Paises;
use App\Http\Validators\DepartamentosValidator;


class DepartamentosController extends Controller
{
    protected $validator;

    public function __construct(){
        $this->validator = new DepartamentosValidator();
    }
    
    public function getDepartamentos()
    {
        $data = Departamentos::select('departamentos.*','paises.codigo as codPais','paises.nombre as nomPais')
                            ->join('paises','departamentos.idPais','=','paises.id')
                            ->get();

        $departamentos = $this->armarRespuesta($data);
        

        return response()->json([
            'success' => 'true',
            'data' => $departamentos
        ],200);
    }

    //Post
    public function addDepartamento(Request $request)
    {
        
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Paises::find(request('idPais'));

        if($exists === null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El país no existe.'
            ],400);
        }

        $exists = Departamentos::where('codigo',request('codigo'))->first();

        if($exists !== null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código para el departamento ya se encuentra registrado.'
            ],400);
        }

        $departamento = new Departamentos();
        $departamento->codigo = request('codigo');
        $departamento->nombre = request('nombre');
        $departamento->idpais = request('idPais');
        $departamento->save();

        return response()->json([
            'success' => 'true',
            'message'=> 'Registro insertado con éxito.'
        ],200);
    }

    //get
    public function getDepartamento($id)
    {
        $data = Departamentos::select('departamentos.*','paises.codigo as codPais','paises.nombre as nomPais')
                            ->join('paises','departamentos.idPais','=','paises.id')
                            ->where('departamentos.id','=',$id)
                            ->get();

        $departamento = $this->armarRespuesta($data);

        return response()->json([
            'success' => 'true',
            'data' => $departamento
        ],200);
    }

    //put,patch
    public function updateDepartamento(Request $request, $id)
    {
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Paises::find(request('idPais'));

        if($exists === null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El país no existe.'
            ],400);
        }

        $exists = Departamentos::where('codigo',request('codigo'))->first();

        if($exists !== null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El código para el departamento ya se encuentra registrado.'
            ],400);
        }

        $departamento = Departamentos::find($id);

        if($departamento === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Departamento no existe.'
            ],400);
        }

        $departamento->codigo = request('codigo');
        $departamento->nombre = request('nombre');
        $departamento->idpais = request('idPais');
        $departamento->update();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro actualizado con éxito.'
        ],200);
    }

    //delete
    public function deleteDepartamento($id)
    {
        $departamento = Departamentos::find($id);

        if($departamento === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Departamento no existe.'
            ],400);
        }

        $departamento->delete();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro eliminado con éxito.'
        ],200);
    }

    protected function armarRespuesta($data){
        
        $tempo = [];

        foreach ($data as $row) {
            $pais = [
                'id' => $row->idPais,
                'codigo' => $row->codPais,
                'nombre' => $row->nomPais
            ];

            $tmp = [
                'id' => $row->id,
                'codigo' => $row->codigo,
                'nombre' => $row->nombre,
                'pais' => $pais
            ];

            array_push($tempo,$tmp);
        }

        return $tempo;
    }
}
