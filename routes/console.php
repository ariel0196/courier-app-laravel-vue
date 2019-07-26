<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Storage;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('test', function () {

	// echo App\Cliente::query()
	// 	->has('enviosOrigen')
	// 	->get();

	// DB::beginTransaction();

	// $client = new \GuzzleHttp\Client();
	// $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

	// echo $response->getStatusCode(); # 200
	// echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
	// echo $response->getBody(); # '{'id': 1420053, 'name': 'guzzle', ...}'

	// DB::rollBack();

	// First
	try {
		$client = new Client([
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

		echo $response->getStatusCode();
		$data = $response->getHeader('Set-Cookie')[2];
		parse_str($data, $data);

		$token = explode(';', $data['X-Bonita-API-Token'])[0];
		echo $token;
		echo '  -  ';


		$response = $client->get('bonita/API/bpm/process?p=0&c=10');

		$id = json_decode($response->getBody(), true)[0]['id'];

		echo $id;

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
							'value' => '20'
						],
						[
							'name' => 'nombreCliente',
							'value' => 'Ariel Alvarez'
						],
						[
							'name' => 'direccionEnvio',
							'value' => 'Avenida Siempre Viva 123'
						]
					]
				]
			]
		);

		print_r(json_decode($response->getBody(), true));

	} catch (\GuzzleHttp\Exception\RequestException $e) {

		echo 'Error en al enviar request a bonita.';
	}

})->describe('testing things');
