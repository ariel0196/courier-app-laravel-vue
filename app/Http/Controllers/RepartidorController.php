<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repartidor;
use App\Http\Resources\Repartidor as RepartidorResource;
use App\Http\Resources\Envio as EnvioResource;

class RepartidorController extends Controller
{
    public function index(Request $request)
    {
    	$nombre = $request->input('nombre');
    	$perPage = $request->input('per_page');

    	$query = Repartidor::query()
    		->when($nombre, function ($q, $nombre) {
    			$q->where('nombre', 'ilike', "%$nombre%");
    		});

    	$registros = $request->has('nopaginate') ?
			$query->get() :
			$query->paginate($perPage ?? 15);

        return RepartidorResource::collection($registros);
    }

    public function show($id)
    {
        return new RepartidorResource(Repartidor::findOrfail($id));
    }

    public function destroy($id)
    {
        $ciudad = Repartidor::findOrfail($id);
        $ciudad->delete();
        return new RepartidorResource($ciudad);
    }

    public function store(Request $request)
    {
        $ciudad = Repartidor::create($request->all());
        return new RepartidorResource($ciudad);
    }

    public function update(Request $request, $id)
    {
        $ciudad = Repartidor::findOrfail($id);
        $ciudad->update($request->all());
        return new RepartidorResource($ciudad);
    }

    //

    public function showEnvios($repartidorId) {
        $repartidor = Repartidor::findOrfail($repartidorId);
        return EnvioResource::collection($repartidor->envios()->get());
    }
}
