<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Http\Resources\Usuario as UsuarioResource;

class UsuarioController extends Controller
{
	public function index(Request $request)
	{
		$nombre = $request->input('nombre');
		$perPage = $request->input('per_page');

		$query = Usuario::query()
			->when($nombre, function ($q, $nombre) {
				$q->where('nombre', 'ilike', "%$nombre%");
			});

		$registros = $request->has('nopaginate') ?
			$query->get() :
			$query->paginate($perPage ?? 15);

		return UsuarioResource::collection($registros);
	}

	public function show($id)
	{
		return new UsuarioResource(Usuario::findOrfail($id));
	}

	public function destroy($id)
	{
		$ciudad = Usuario::findOrfail($id);
		$ciudad->delete();
		return new UsuarioResource($ciudad);
	}

	public function store(Request $request)
	{
		$ciudad = Usuario::create($request->all());
		return new UsuarioResource($ciudad);
	}

	public function update(Request $request, $id)
	{
		$ciudad = Usuario::findOrfail($id);
		$ciudad->update($request->all());
		return new UsuarioResource($ciudad);
	}
}
