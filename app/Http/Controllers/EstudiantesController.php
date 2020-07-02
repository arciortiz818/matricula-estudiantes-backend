<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paises;
use App\Departamentos;
use App\Ciudades;
use App\TipoDocumento;
use App\Estudiantes;

use App\Http\Validators\EstudiantesValidator;

class EstudiantesController extends Controller
{
    protected $validator;

    public function __construct(){
        $this->validator = new EstudiantesValidator();
    }
    
    public function getEstudiantes()
    {
        $data = Estudiantes::select('estudiantes.*')
                                ->join('tipodocumento','estudiantes.idPais','=','tipodocumento.id')                        
                                ->join('paises','estudiantes.idPais','=','paises.id')
                                ->join('departamentos','estudiantes.idDepartamento','=','departamentos.id')
                                ->join('ciudades','estudiantes.idCiudad','=','ciudades.id')
                                ->get();

        $estudiantes = $data; //$this->armarRespuesta($data);

        return response()->json([
            'success' => 'true',
            'data' => $estudiantes
        ],200);
    }

    //Post
    public function addEstudiante(Request $request)
    {
        
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $exists = Estudiantes::where('documento',request('documento'))->first();

        if($exists !== null) {
            return response()->json([
                'success' => 'false',
                'message' => 'El documento del estudiante ya se encuentra registrado.'
            ],400);
        }

        $tipoDocumento = TipoDocumento::find(request('idTipo_Documento'));
        if($tipoDocumento === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Tipo de Documento no existe.',
                'ID' => request('idTipo_Documento')
            ],400);
        }

        $pais = Paises::find(request('idPais'));
        if($pais === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Pais no existe.'
            ],400);
        }

        $departamento = Departamentos::find(request('idDepartamento'));
        if($departamento === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Departamento no existe.'
            ],400);
        }

        $ciudad = Ciudades::find(request('idCiudad'));
        if($ciudad === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Ciudad no existe.'
            ],400);
        }

        $estudiante = new Estudiantes();
        $estudiante->documento = request('documento');
        $estudiante->nombre1 = request('nombre1');
        $estudiante->nombre2 = request('nombre2');
        $estudiante->apellido1 = request('apellido1');
        $estudiante->apellido2 = request('apellido2');
        $estudiante->barrio = request('barrio');
        $estudiante->direccion = request('direccion');
        $estudiante->telefono_casa = request('telefono_casa');
        $estudiante->telefono_oficina = request('telefono_oficina');
        $estudiante->celular = request('celular');
        $estudiante->email = request('email');
        $estudiante->fecha_nacimiento = request('fecha_nacimiento');
        $estudiante->idTipo_Documento = request('idTipo_Documento');
        $estudiante->idDepartamento = request('idDepartamento');
        $estudiante->idCiudad = request('idCiudad');
        $estudiante->idPais = request('idPais');
        $estudiante->save();

        return response()->json([
            'success' => 'true',
            'message'=> 'Registro insertado con éxito.'
        ],200);
    }

    //get
    public function getEstudiante($id)
    {
        $data = Estudiantes::select('estudiantes.*')
                                ->join('tipodocumento','estudiantes.idPais','=','tipodocumento.id')                        
                                ->join('paises','estudiantes.idPais','=','paises.id')
                                ->join('departamentos','estudiantes.idDepartamento','=','departamentos.id')
                                ->join('ciudades','estudiantes.idCiudad','=','ciudades.id')
                                ->where('estudiantes.id','=',$id)
                                ->first();

        $estudiante = $data; //$this->armarRespuesta($data);

        return response()->json([
            'success' => 'true',
            'data' => $estudiante
        ],200);
    }

    public function getEstudianteByDocumento($documento)
    {
        $data = Estudiantes::select('estudiantes.*','tipodocumento.codigo as codTipoDocumento','tipodocumento.nombre as nomTipoDocumento','paises.codigo as codPais','paises.nombre as nomPais','departamentos.codigo as codDepartamento','departamentos.nombre as nomDepartamento','ciudades.codigo as codCiudad','ciudades.nombre as nomCiudad')
                                ->join('tipodocumento','estudiantes.idPais','=','tipodocumento.id')                        
                                ->join('paises','estudiantes.idPais','=','paises.id')
                                ->join('departamentos','estudiantes.idDepartamento','=','departamentos.id')
                                ->join('ciudades','estudiantes.idCiudad','=','ciudades.id')
                                ->where('estudiantes.documento','=',$documento)
                                ->first();

        $estudiante = $data;//$this->armarRespuesta($data);

        return response()->json([
            'success' => 'true',
            'data' => $estudiante
        ],200);
    }

    //put,patch
    public function updateEstudiante(Request $request, $id)
    {
        $validated = $this->validator->validar($request);
        if($validated !== null){
            return response()->json($validated,400);
        }

        $tipoDocumento = TipoDocumento::find(request('idTipo_Documento'));
        if($tipoDocumento === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Tipo de Documento no existe.'
            ],400);
        }

        $pais = Paises::find(request('idPais'));
        if($pais === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Pais no existe.'
            ],400);
        }

        $departamento = Departamentos::find(request('idDepartamento'));
        if($departamento === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Departamento no existe.'
            ],400);
        }

        $ciudad = Ciudades::find(request('idCiudad'));
        if($ciudad === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Ciudad no existe.'
            ],400);
        }

        $estudiante = Estudiantes::find($id);

        if($estudiante === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Estudiante no existe.'
            ],400);
        }

        $estudiante->documento = request('documento');
        $estudiante->nombre1 = request('nombre1');
        $estudiante->nombre2 = request('nombre2');
        $estudiante->apellido1 = request('apellido1');
        $estudiante->apellido2 = request('apellido2');
        $estudiante->barrio = request('barrio');
        $estudiante->direccion = request('direccion');
        $estudiante->telefono_casa = request('telefono_casa');
        $estudiante->telefono_oficina = request('telefono_oficina');
        $estudiante->celular = request('celular');
        $estudiante->email = request('email');
        $estudiante->fecha_nacimiento = request('fecha_nacimiento');
        $estudiante->idTipo_Documento = request('idTipo_Documento');
        $estudiante->idDepartamento = request('idDepartamento');
        $estudiante->idCiudad = request('idCiudad');
        $estudiante->idPais = request('idPais');
        $estudiante->save();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro actualizado con éxito.'
        ],200);
    }

    //delete
    public function deleteEstudiante($id)
    {
        $estudiante = Estudiantes::find($id);

        if($estudiante === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Estudiante no existe.'
            ],400);
        }

        $estudiante->delete();

        return response()->json([
            'success' => 'true',
            'message' => 'Registro eliminado con éxito.'
        ],200);
    }

    protected function armarRespuesta($data){
        
        $tempo = [];

        foreach ($data as $row) {
            $tipo_documento = [
                'id' => $row->idTipo_Documento,
                'codigo' => $row->codTipoDocumento,
                'nombre' => $row->nomTipoDocumento
            ];

            $pais = [
                'id' => $row->idPais,
                'codigo' => $row->codPais,
                'nombre' => $row->nomPais
            ];

            $departamento = [
                'id' => $row->idDepartamento,
                'codigo' => $row->codDepartamento,
                'nombre' => $row->nomDepartamento
            ];

            $ciudad = [
                'id' => $row->idCiudad,
                'codigo' => $row->codCiudad,
                'nombre' => $row->nomCiudad
            ];

            $tmp = [
                'id' => $row->id,
                'documento' => $row->documento,
                'nombre1' => $row->nombre1,
                'nombre2' => $row->nombre2,
                'apellido1' => $row->apellido1,
                'apellido2' => $row->apellido2,
                'barrio' => $row->barrio,
                'direccion' => $row->direccion,
                'telefonoCasa' => $row->telefono_casa,
                'telefonoOficina' => $row->telefono_oficina,
                'celular' => $row->celular,
                'email' => $row->email,
                'fechaNacimiento' => $row->fecha_nacimiento,
                'tipoDocumento' => $tipo_documento,
                'ciudad' => $ciudad,
                'departamento' => $departamento,
                'pais' => $pais
            ];

            array_push($tempo,$tmp);
        }

        return $tempo;
    }

}
