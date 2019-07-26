<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Direccion;
use App\Http\Resources\Direccion as DireccionResource;

class DireccionController extends Controller
{
    public function index(Request $request)
    {
    	$nombre = $request->input('nombre');
    	$clienteId = $request->input('cliente_id');
    	$perPage = $request->input('per_page');

    	$query = Direccion::query()
    		->when($nombre, function ($q, $nombre) {
    			$q->where('nombre', 'ilike', "%$nombre%");
    		})
    		->when($clienteId, function ($q, $clienteId) {
    			$q->where('cliente_id', '=', $clienteId);
    		});

		$registros = $request->has('nopaginate') ?
			$query->get() :
			$query->paginate($perPage ?? 15);

        return DireccionResource::collection($registros);
    }

    public function show($id)
    {
        return new DireccionResource(Direccion::findOrfail($id));
    }

    public function destroy($id)
    {
        $ciudad = Direccion::findOrfail($id);
        $ciudad->delete();
        return new DireccionResource($ciudad);
    }

    public function store(Request $request)
    {
        $ciudad = Direccion::create($request->all());
        return new DireccionResource($ciudad);
    }

    public function update(Request $request, $id)
    {
        $ciudad = Direccion::findOrfail($id);
        $ciudad->update($request->all());
        return new DireccionResource($ciudad);
    }
}
