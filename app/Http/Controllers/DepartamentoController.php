<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Http\Resources\Departamento as DepartamentoResource;
use App\Http\Resources\Ciudad as CiudadResource;

class DepartamentoController extends Controller
{
    public function index(Request $request) {

    	$nombre = $request->input('nombre');
    	$perPage = $request->input('per_page');

    	$query = Departamento::query()
    		->when($nombre, function ($q, $nombre) {
    			$q->where('nombre', 'ilike', "%$nombre%");
    		});

    	$registros = $request->has('nopaginate') ?
			$query->get() :
			$query->paginate($perPage ?? 15);

        return DepartamentoResource::collection($registros);
    }

    public function show($id) {
        $departamento = Departamento::findOrFail($id);
        return new DepartamentoResource($departamento);
    }

    public function destroy($id) {
        $departamento = Departamento::findOrfail($id);
        $departamento->delete();
        return new DepartamentoResource($departamento);
    }

    public function store(Request $request) {
        $departamento = Departamento::create($request->all());
        return new DepartamentoResource($departamento);
    }

    public function update(Request $request, $id) {
        $departamento = Departamento::findOrfail($id);
        $departamento->update($request->all());
        return new DepartamentoResource($departamento);
    }

    //

    public function showCiudades($departamentoId) {
        $departamento = Departamento::findOrfail($departamentoId);
        return new CiudadResource($departamento->ciudades()->get());
    }
}
