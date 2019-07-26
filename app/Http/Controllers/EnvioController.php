<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Envio;
use App\Http\Resources\Envio as EnvioResource;

class EnvioController extends Controller
{
	public function index(Request $request)
	{
		$nombreCliente = $request->input('nombre_cliente');
		$estados = $request->input('estados') ?
			explode(',', $request->input('estados')) : null;
		$fechaCreacionInicial = $request->input('fecha_creacion_inicial');
		$fechaCreacionFinal = $request->input('fecha_creacion_final');
		$fechaEntregaInicial = $request->input('fecha_entrega_inicial');
		$fechaEntregaFinal = $request->input('fecha_entrega_final');
		$fechaFacturacionInicial = $request->input('fecha_facturacion_inicial');
		$fechaFacturacionFinal = $request->input('fecha_facturacion_final');
		$clienteId = $request->input('cliente_id');
		$facturaId = $request->input('factura_id');

		$perPage = $request->input('per_page');

		$query = Envio::query()
			->when($nombreCliente, function ($query, $nombre) {
				$query->whereHas('clienteOrigen', function ($query) use ($nombre) {
					$query->where('nombre', 'ilike', "%$nombre%");
				});
			})
			->when($estados, function ($query, $estados) {
				$query->whereIn('estado', $estados);
			})
			->when($fechaEntregaInicial, function ($query, $fecha) {
				$query->where('fecha_entrega', '>', $fecha);
			})
			->when($fechaEntregaFinal, function ($query, $fecha) {
				$query->where('fecha_entrega', '<', $fecha);
			})
			->when($fechaCreacionInicial, function ($query, $fecha) {
				$query->where('fecha_creacion', '>', $fecha);
			})
			->when($fechaCreacionFinal, function ($query, $fecha) {
				$query->where('fecha_creacion', '<', $fecha);
			})
			->when($fechaFacturacionInicial, function ($query, $fecha) {
				$query->where('fecha_facturacion', '>', $fecha);
			})
			->when($fechaFacturacionFinal, function ($query, $fecha) {
				$query->where('fecha_facturacion', '<', $fecha);
			})
			->when($clienteId, function ($query, $id) {
				$query->where('cliente_origen_id', '=', $id);
			})
			->when($facturaId, function ($query, $id) {
				$query->whereNull('factura_id');
			})
			->with([
				'clienteDestino:id,nombre',
				'clienteOrigen:id,nombre',
				'tipoEnvio:id,nombre',
				'factura:id,numero'
			])
			->orderBy('id', 'desc');

		$registros = $request->has('nopaginate') ?
			$query->get() :
			$query->paginate($perPage ?? 15);

		return EnvioResource::collection($registros);
	}

	public function show($id)
	{
		$envio = Envio::query()
			->with('clienteOrigen')
			->with('ciudadOrigen')
			->with('direccionOrigen')
			->with('clienteDestino')
			->with('ciudadDestino')
			->with('direccionDestino')
			->with('repartidor')
			->with('tipoEnvio')
			->with('factura')
			->findOrfail($id);
		return new EnvioResource($envio);
	}

	public function store(Request $request)
	{
		\DB::beginTransaction();

		$envio = Envio::create($request->all());

		\DB::commit();

		return new EnvioResource($envio);

		try {

			$client = new \GuzzleHttp\Client([
				'base_uri' => 'http://localhost:8081/',
				'cookies' => true
			]);

			$response = $client->post(
				'bonita/loginservice', [
					'form_params' => [
						'username' => 'lguanes',
						'password' => 'lguanes',
						'redirect' => 'false'
					]
				]
			);

			$data = $response->getHeader('Set-Cookie')[2];
			parse_str($data, $data);
			$token = explode(';', $data['X-Bonita-API-Token'])[0];

			$response = $client->get('bonita/API/bpm/process?p=0&c=10');

			$id = json_decode($response->getBody(), true)[0]['id'];

			$response = $client->post(
				'bonita/API/bpm/case', [
					'headers' => [
						'X-Bonita-API-Token' => $token
					],
					'json' => [
						'processDefinitionId' => $id,
						'variables' => [
							[
								'name' => 'envioId',
								'value' => $envio->id
							],
							[
								'name' => 'nombreCliente',
								'value' => $envio->clienteOrigen->nombre
							],
							[
								'name' => 'direccionEnvio',
								'value' => $envio->direccionDestino->descripcion
							]
						]
					]
				]
			);

		} catch (\GuzzleHttp\Exception\RequestException $e) {

			\DB::rollback();

			return response()->json([
				'error' => 'Error en al enviar request a bonita.'
			], 500);
		}

		return new EnvioResource($envio);
	}

	public function update(Request $request, $id)
	{
		$ciudad = Envio::findOrfail($id);
		$ciudad->update($request->all());
		return new EnvioResource($ciudad);
	}

	public function destroy($id)
	{
		$ciudad = Envio::findOrfail($id);
		$ciudad->delete();
		return new EnvioResource($ciudad);
	}

	public function chart () {
		$envios = Envio::query()
			->whereIn('estado', ['entregado', 'facturado', 'cobrado'])
			->select([
				'ciudad_origen_id',
				\DB::raw("DATE_PART('day', fecha_entrega - fecha_creacion) as tiempo_real"),
				'fecha_creacion',
				'fecha_entrega'
			])
			->with('ciudadOrigen')
			->get();

		$total = $envios->count();
		$negativos = 0;
		$positivos = 0;

		foreach($envios as $envio) {
			if ($envio->tiempo_real > $envio->ciudadOrigen->tiempo_estimado) {
				$negativos++;
			} else {
				$positivos++;
			}
		}

		return new EnvioResource([
			[ 'key' => 'positivos: ' . (($positivos / $total) * 100) . '%', 'value' => $positivos ],
			[ 'key' => 'negativos:' . (($negativos / $total) * 100) . '%', 'value' => $negativos]
		]);
	}

	// public function chart() {
	// 	$data = Envio::query()
	// 		->select('estado', \DB::raw('count(*) as total'))
	// 		->groupBy('estado')
	// 		->get();
	// 	return new EnvioResource($data);
	// }

}
