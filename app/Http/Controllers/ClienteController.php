<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Usuario;
use App\Direccion;
use App\Http\Resources\Cliente as ClienteResource;
use App\Http\Resources\Direccion as DireccionResource;
use App\Http\Resources\Envio as EnvioResource;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{

	public function index(Request $request)
	{
		$nombre = $request->input('nombre');
		$documento = $request->input('documento');
		$email = $request->input('email');
		$mayorista = $request->input('mayorista');
		$perPage = $request->input('perPage');

		$query = Cliente::query()
			->when($nombre, function ($query, $nombre) {
				$query->where('nombre', 'ilike', "%$nombre%");
			})
			->when($documento, function ($query, $documento) {
				$query->where('documento', 'ilike', "%$documento%");
			})
			->when($email, function ($query, $email) {
				$query->where('email', 'ilike', "%$email%");
			})
			->when($mayorista, function ($query, $mayorista) {
				$query->where('mayorista', $mayorista);
			})
			->orderBy('id', 'desc');;

		$registros = $request->has('nopaginate') ?
		$query->get() :
		$query->paginate($perPage ?? 15);

		return ClienteResource::collection($registros);
	}

	public function show($id)
	{
		$cliente = Cliente::query()
			->with('direcciones.ciudad')
			->findOrFail($id);
		return new ClienteResource($cliente);
	}

	public function destroy($id)
	{
		$cliente = Cliente::findOrfail($id);
		$cliente->delete();
		return new ClienteResource($Cliente);
	}

	public function store(Request $request)
	{
		\DB::beginTransaction();

		$cliente = Cliente::create($request->except('direcciones'));

		if ($request->input('direcciones'))
			$cliente->direcciones()->createMany($request->input('direcciones'));

		$usuario = new Usuario([
			'nombre' => $cliente->nombre,
			'email' => $cliente->email,
			'rol' => 'cliente'
		]);

		$usuario->password = Hash::make('root');

		$cliente->usuarios()->save($usuario);

		$cliente->load('direcciones');

		\DB::commit();

		return new ClienteResource($cliente);
	}

	public function update(Request $request, $id)
	{
		$cliente = Cliente::findOrfail($id);
		$cliente->update($request->except('direcciones'));

		$direcciones = $request->input('direcciones') ?? [];
		$direccionesNuevas = [];
		$direccionesIds = [];

		\DB::beginTransaction();

		foreach ($direcciones as $direccion) {
			if (isset($direccion['id'])) {
				unset($direccion['ciudad']);
				Direccion::query()
					->whereId($direccion['id'])
					->update($direccion);
				$direccionesIds[] = $direccion['id'];
			} else {
				$direccionesNuevas[] = $direccion;
			}
		}

		$cliente
			->direcciones()
			->whereNotIn('id', $direccionesIds)
			->delete();

		if (count($direccionesNuevas))
			$cliente
				->direcciones()
				->createMany($direccionesNuevas);

		\DB::commit();

		$cliente->load('direcciones');
		return new ClienteResource($cliente);
	}

	//

	public function showDirecciones($clienteId)
	{
		$cliente = Cliente::findOrfail($clienteId);
		return DireccionResource::collection($cliente->direcciones()->get());
	}

	public function showEnvios(Request $request, $clienteId)
	{
		$perPage = $request->input('perPage');

		$cliente = Cliente::findOrfail($clienteId);
		$query = $cliente
			->enviosOrigen()
			->select(
				'id',
				'estado',
				'fecha_creacion',
				'fecha_entrega',
				'precio_total',
				'tipo_envio_id',
				'cliente_destino_id'
			)
			->with('tipoEnvio:id,nombre')
			->with('clienteDestino:id,nombre');

		$registros = $request->has('nopaginate') ?
		$query->get() :
		$query->paginate($perPage ?? 15);

		return EnvioResource::collection($registros);
	}

	// public function chart(Request $request)
	// {

	// 	$clientes = Cliente::query()
	// 		->select(['id', 'nombre'])
	// 		->take(20)
	// 		->withCount('enviosOrigen')
	// 		->get();

	// 	return EnvioResource::collection($clientes);
	// }
}
