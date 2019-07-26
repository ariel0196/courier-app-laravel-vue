<?php

use Illuminate\Http\Request;
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

Route::get("/", function (Request $request) {
	return response()->json(["message" => "Courier REST API"]);
});

Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');


Route::apiResource('ciudades', 'CiudadController');
Route::get('ciudades/{id}/direcciones', 'CiudadController@showDirecciones');

Route::apiResource('clientes', 'ClienteController');
Route::get('clientes/{id}/envios', 'ClienteController@showEnvios');
Route::get('clientes/{id}/direcciones', 'ClienteController@showDirecciones');

Route::apiResource('departamentos', 'DepartamentoController');
Route::get('departamentos/{id}/ciudades', 'DepartamentoController@showCiudades');

Route::get('envios/chart', 'EnvioController@chart');
Route::apiResource('envios', 'EnvioController');

Route::get('facturas/chart', 'FacturaController@chart');
Route::apiResource('facturas', 'FacturaController');
Route::get('facturas/{id}/envios', 'FacturaController@showEnvios');

Route::apiResource('repartidores', 'RepartidorController');
Route::get('repartidores/{id}/envios', 'RepartidorController@showEnvios');

Route::apiResource('tipos_envio', 'TipoEnvioController');

Route::apiResource('facturas', 'FacturaController');

Route::apiResource('usuarios', 'UsuarioController');

Route::apiResource('direcciones', 'DireccionController');



