<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoEnvio;
use App\Http\Resources\TipoEnvio as TipoEnvioResource;

class TipoEnvioController extends Controller
{
    public function index(Request $request)
    {
    	$nombre = $request->input('nombre');
    	$perPage = $request->input('per_page');

    	$query = TipoEnvio::query()
    		->when($nombre, function ($q, $nombre) {
    			$q->where('nombre', 'ilike', "%$nombre%");
    		});

		$registros = $request->has('nopaginate') ?
			$query->get() :
			$query->paginate($perPage ?? 15);

        return TipoEnvioResource::collection($registros);
    }

    public function show($id)
    {
        return new TipoEnvioResource(TipoEnvio::findOrfail($id));
    }

    public function destroy($id)
    {
        $ciudad = TipoEnvio::findOrfail($id);
        $ciudad->delete();
        return new TipoEnvioResource($ciudad);
    }

    public function store(Request $request)
    {
        $ciudad = TipoEnvio::create($request->all());
        return new TipoEnvioResource($ciudad);
    }

    public function update(Request $request, $id)
    {
        $ciudad = TipoEnvio::findOrfail($id);
        $ciudad->update($request->all());
        return new TipoEnvioResource($ciudad);
    }
}
