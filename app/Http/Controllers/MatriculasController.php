<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Validators\MatriculasValidator;
use App\Matriculas;
use App\DetMatriculas;
use App\Estudiantes;
use App\Programas;
use App\Materias;

class MatriculasController extends Controller
{
    protected $validator;

    public function __construct(){
        // $this->validator = new MatriculasValidator();
    }

    public function getMatriculaByDocEstudiante($docEstudiante){
        $matricula = Matriculas::select('matriculas.*')
        ->join('estudiantes','matriculas.idEstudiante','=','estudiantes.id')
        ->join('programas','matriculas.idPrograma','=','programas.id')
        ->where('estudiantes.documento','=',$docEstudiante)
        ->first();

        if(!$matricula){
            return response()->json([
                'success' => 'true',
                'data' => []
            ],200);
        }

        $estudiante = Estudiantes::find($matricula->idEstudiante);

        $programa = Programas::find($matricula->idPrograma);

        $detalle = DetMatriculas::select('detMatriculas.valor_materia','detMatriculas.descuento_materia','detMatriculas.creditos','detMatriculas.idMateria','materias.codigo as codMateria','materias.nombre as nomMateria','materias.nivel')
        ->join('Materias','detMatriculas.idMateria','=','Materias.id')
        ->where('detMatriculas.idMatricula','=',$matricula->id)
        ->get();

        $data = [
            'estudiante' => $estudiante,
            'programa' => $programa,
            'matricula' => $matricula,
            'detalle' => $detalle
        ];

        return response()->json([
            'success' => 'true',
            'data' => $data
        ],200);

    }
    
    public function addMatricula()
    {
        $valor_por_carrera = false;      //Debe ser una variable global para el periodo
        $materias_a_matricular = Materias::find(request('detalle'));
        $programa = Programas::find(request('idPrograma'));
        $total_matricula = 0;
        $total_descuento = 0;   
        if($valor_por_carrera){
            
            $total_matricula = $programa->valor_nivel;
            $total_descuento = (($programa->valor_nivel * $programa->porc_descuento) / 100);
        }else{
            
            foreach($materias_a_matricular as $item){
                $total_matricula = $total_matricula + $item->valor_materia;
                $total_descuento = $total_descuento + (($item->valor_materia * $item->porc_descuento) / 100);
            }
        }

        $matricula = new Matriculas();
        $matricula->fecha_matricula = date('Y-m-d');
        $matricula->fecha_limite = date('Y-m-d'); //Debe ser una variable global para el periodo
        $matricula->periodo = '202002'; //Debe ser una variable global para el periodo
        $matricula->pagado = 0;
        $matricula->idEstudiante = request('idEstudiante');
        $matricula->idPrograma = request('idPrograma');
        $matricula->valor_matricula = $total_matricula;
        $matricula->valor_descuento = $total_descuento; 
        
        if(!$matricula->save()){
            return response()->json([
                'success' => 'false',
                'message' => 'Error matriculando.'
            ],200);
        }
        
        foreach($materias_a_matricular as $item){
            $detMatricula = new DetMatriculas();
            $detMatricula->idMateria = $item->id;
            $detMatricula->idMatricula = $matricula->id;
            $detMatricula->valor_materia = $item->valor_materia;
            $detMatricula->descuento_materia = ($item->valor_materia * $item->porc_descuento) / 100;
            $detMatricula->creditos = $item->creditos;
            $detMatricula->save();
        }
        

        return response()->json([
            'success' => 'true',
            'message' => 'Matriculado correctamente'
        ],200);
    }

    public function editMatricula($idMatricula){
        $matricula = Matriculas::find($idMatricula);
        if($matricula === null){
            return response()->json([
                'success' => 'false',
                'message' => 'Matricula que se intenta editar no existe.'
            ],400);
        }

        $valor_por_carrera = false;      //Debe ser una variable global para el periodo
        $programa = Programas::find($matricula->idPrograma);
        $materias_a_matricular = Materias::find(request('detalle'));
        $total_matricula = 0;
        $total_descuento = 0;   
        if($valor_por_carrera){
            
            $total_matricula = $programa->valor_nivel;
            $total_descuento = (($programa->valor_nivel * $programa->porc_descuento) / 100);
        }else{
            
            foreach($materias_a_matricular as $item){
                $total_matricula = $total_matricula + $item->valor_materia;
                $total_descuento = $total_descuento + (($item->valor_materia * $item->porc_descuento) / 100);
            }
        }

        $matricula->fecha_matricula = date('Y-m-d');
        $matricula->fecha_limite = date('Y-m-d'); //Debe ser una variable global para el periodo
        $matricula->periodo = '202002'; //Debe ser una variable global para el periodo
        $matricula->pagado = 0;
        // $matricula->idEstudiante = request('idEstudiante');
        // $matricula->idPrograma = request('idPrograma');
        $matricula->valor_matricula = $total_matricula;
        $matricula->valor_descuento = $total_descuento; 
        
        if(!$matricula->update()){
            return response()->json([
                'success' => 'false',
                'message' => 'Error actualizando matricula.'
            ],400);
        }

        DetMatriculas::where('idMatricula','=',$idMatricula)->delete();
        
        foreach($materias_a_matricular as $item){
            $detMatricula = new DetMatriculas();
            $detMatricula->idMateria = $item->id;
            $detMatricula->idMatricula = $matricula->id;
            $detMatricula->valor_materia = $item->valor_materia;
            $detMatricula->descuento_materia = ($item->valor_materia * $item->porc_descuento) / 100;
            $detMatricula->creditos = $item->creditos;
            $detMatricula->save();
        }
        

        return response()->json([
            'success' => 'true',
            'message' => 'Matriculado correctamente'
        ],200);


    }

    
}
