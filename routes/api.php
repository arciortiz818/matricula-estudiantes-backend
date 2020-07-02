<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['jwt.verify']], function(){
    
    
});

Route::group(['middleware' => [], 'prefix' => 'auth'], function(){
    Route::post('login','AuthController@authenticate');
    Route::post('refresh','AuthController@refresh');
    Route::post('get-authenticated-user','AuthController@getAuthenticatedUser');
    Route::post('register','AuthController@register');
});

Route::group(['middleware' => [], 'prefix' => 'admin/paises'], function(){
    Route::get('','PaisesController@getPaises');
    Route::post('','PaisesController@addPais');
    Route::get('{id}','PaisesController@getPais');
    Route::put('{id}','PaisesController@updatePais');
    Route::delete('{id}','PaisesController@deletePais');
});

Route::group(['middleware' => [], 'prefix' => 'admin/departamentos'], function(){
    Route::get('','DepartamentosController@getDepartamentos');
    Route::post('','DepartamentosController@addDepartamento');
    Route::get('{id}','DepartamentosController@getDepartamento');
    Route::put('{id}','DepartamentosController@updateDepartamento');
    Route::delete('{id}','DepartamentosController@deleteDepartamento');
});

Route::group(['middleware' => [], 'prefix' => 'admin/ciudades'], function(){
    Route::get('','CiudadesController@getCiudades');
    Route::post('','CiudadesController@addCiudad');
    Route::get('{id}','CiudadesController@getCiudad');
    Route::put('{id}','CiudadesController@updateCiudad');
    Route::delete('{id}','CiudadesController@deleteCiudad');
});

Route::group(['middleware' => [], 'prefix' => 'admin/tipos-documento'], function(){
    Route::get('','TipoDocumentoController@getTiposDocumento');
    Route::post('','TipoDocumentoController@addTipoDocumento');
    Route::get('{id}','TipoDocumentoController@getTipoDocumento');
    Route::put('{id}','TipoDocumentoController@updateTipoDocumento');
    Route::delete('{id}','TipoDocumentoController@deleteTipoDocumento');
});

Route::group(['middleware' => [], 'prefix' => 'admin/estudiantes'], function(){
    Route::get('','EstudiantesController@getEstudiantes');
    Route::post('','EstudiantesController@addEstudiante');
    Route::get('{id}','EstudiantesController@getEstudiante');
    Route::get('documento/{documento}','EstudiantesController@getEstudianteByDocumento');
    Route::put('{id}','EstudiantesController@updateEstudiante');
    Route::delete('{id}','EstudiantesController@deleteEstudiante');
});

Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'admin/programas'], function(){
    Route::get('','ProgramasController@getProgramas');
    Route::post('','ProgramasController@addPrograma');
    Route::get('{id}','ProgramasController@getPrograma');
    Route::put('{id}','ProgramasController@updatePrograma');
    Route::delete('{id}','ProgramasController@deletePrograma');
});

Route::group(['middleware' => [], 'prefix' => 'admin/materias'], function(){
    Route::get('','MateriasController@getMaterias');
    Route::get('programa/{idPrograma}','MateriasController@getMateriasxPrograma');
    Route::post('','MateriasController@addMateria');
    Route::get('{id}','MateriasController@getMateria');
    Route::put('{id}','MateriasController@updateMateria');
    Route::delete('{id}','MateriasController@deleteMateria');
});