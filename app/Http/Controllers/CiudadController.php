<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciudad;
use App\Http\Resources\Ciudad as CiudadResource;
use App\Http\Resources\Direccion as DireccionResource;

class CiudadController extends Controller
{
	public function index(Request $request)
	{
		$nombre = $request->input('nombre');
		$perPage = $request->input('per_page');

		$query = Ciudad::query()
			->when($nombre, function ($query, $nombre) {
				$query->where('nombre', 'ilike', "%$nombre%");
			})
			->with('departamento');

		$registros = $request->has('nopaginate') ?
			$query->get() :
			$query->paginate($perPage ?? 15);

		return CiudadResource::collection($registros);
	}

	public function show($id)
	{
		$ciudad = Ciudad::query()
			->with('departamento')
			->findOrfail($id);
		return new CiudadResource($ciudad);
	}

	public function destroy($id)
	{
		$ciudad = Ciudad::findOrfail($id);
		$ciudad->delete();
		return new CiudadResource($ciudad);
	}

	public function store(Request $request)
	{
		$ciudad = Ciudad::create($request->all());
		return new CiudadResource($ciudad);
	}

	public function update(Request $request, $id)
	{
		$ciudad = Ciudad::findOrfail($id);
		$ciudad->update($request->all());
		return new CiudadResource($ciudad);
	}

    //

	public function showDirecciones($ciudadId)
	{
		$ciudad = Ciudad::findOrfail($ciudadId);
		return DireccionResource::collection($ciudad->direcciones()->get());
	}
}
