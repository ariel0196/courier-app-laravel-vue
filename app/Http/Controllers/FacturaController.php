<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Factura, Envio};
use App\Http\Resources\Factura as FacturaResource;
use App\Http\Resources\Envio as EnvioResource;

class FacturaController extends Controller
{
	public function index(Request $request)
	{
		$clienteId = $request->input('cliente_id');
		$nombreCliente = $request->input('nombre_cliente');
		$estados = $request->input('estados') ?
			explode(',', $request->input('estados')) : null;
		$fechaCreacionMin = $request->input('fecha_creacion_min');
		$fechaCreacionMax = $request->input('fecha_creacion_max');
		$fechaCobroMin = $request->input('fecha_entrega_min');
		$fechaCobroMax = $request->input('fecha_entrega_max');
		$perPage = $request->input('per_page');

		$query = Factura::query()
			->when($clienteId, function ($query, $clienteId) {
				$query->where('cliente_id', $clienteId);
			})
			->when($nombreCliente, function ($query, $nombre) {
				$query->whereHas('cliente', function ($query) use ($nombre) {
					$query->where('nombre', 'ilike', "%$nombre%");
				});
			})
			->when($estados, function ($query, $estados) {
				$query->whereIn('estado', $estados);
			})
			->when($fechaCreacionMin, function ($query, $fecha) {
				$query->where('fecha_creacion', '>', $fecha);
			})
			->when($fechaCreacionMax, function ($query, $fecha) {
				$query->where('fecha_creacion', '<', $fecha);
			})
			->when($fechaCobroMin, function ($query, $fecha) {
				$query->where('fecha_facturacion', '>', $fecha);
			})
			->when($fechaCobroMax, function ($query, $fecha) {
				$query->where('fecha_facturacion', '<', $fecha);
			})
			->with('cliente')
			->orderBy('id', 'desc');;

		$registros = $request->has('nopaginate') ?
		$query->get() :
		$query->paginate($perPage ?? 15);

		return FacturaResource::collection($registros);
	}

	public function show($id)
	{
		$factura = Factura::query()
			->with('cliente')
			->with('envios.tipoEnvio:id,nombre')
			->with('envios.clienteDestino:id,nombre')
			->findOrfail($id);
		return new FacturaResource($factura);
	}

	public function destroy($id)
	{
		$ciudad = Factura::findOrfail($id);
		$ciudad->delete();
		return new FacturaResource($ciudad);
	}

	// public function store(Request $request)
	// {
	// 	$numero = Factura::query()
	// 		->orderBy('id', 'desc')
	// 		->first()
	// 		->numero;

	// 	if ($numero) $request->merge(['numero' => $numero + 1]);

	// 	$factura = Factura::create($request->all());
	// 	return new FacturaResource($factura);
	// }

	public function store(Request $request)
	{
		$envios = $request->input('envios');

		\DB::beginTransaction();

		$factura = Factura::create($request->except('envios'));

		Envio::query()
			->whereIn('id', collect($envios)->map(function ($e) { return $e['envio_id']; } ))
			->update([
				'factura_id' => $factura->id,
				'estado' => 'facturado'
			]);

		\DB::commit();

		$factura->load('envios');

		return new FacturaResource($factura);
	}


	public function update(Request $request, $id)
	{
		$envios = $request->input('envios');
		$facturaId = $request->input('id');
		$estado = $request->input('estado');

		$factura = Factura::findOrFail($id);

		$ids = collect($envios)->map(function ($e) { return $e['id']; } );

		\DB::beginTransaction();

		// Desasociar envios ya existes eliminados
		$factura
			->envios()
			->whereNotIn('id', $ids)
			->update([
				'factura_id' => null,
				'estado' => 'entregado'
			]);

		Envio::query()
			->whereIn('id', $ids)
			->update([
				'factura_id' => $facturaId,
				'estado' => $estado == 	'emitida' ? 'facturado' : 'cobrado'
			]);

		$factura->update($request->all());

		\DB::commit();

		$factura->load('envios');

		return new FacturaResource($factura);
	}

	public function showEnvios($facturaId) {
		$factura = Factura::findOrfail($facturaId);
		return EnvioResource::collection($factura->envios()->all());
	}

	public function chart(Request $request)
	{

		$meses = Factura::query()
			->select([
				\DB::raw("to_char(fecha_creacion,'Mon') as nombre"),
				\DB::raw("count(*) filter ( where (fecha_cobro::date - fecha_creacion::date) <= 10 ) as dentro"),
				\DB::raw("count(*) filter ( where ((fecha_cobro::date - fecha_creacion::date) > 10) or ((fecha_cobro::date - fecha_creacion::date) is null) )	as fuera"),
			])
			->groupBy('nombre')
			->get();
		return FacturaResource::collection($meses);
	}
}
