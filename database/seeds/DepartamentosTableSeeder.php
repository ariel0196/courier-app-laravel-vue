<?php

use Illuminate\Database\Seeder;
use App\Departamento;


class DepartamentosTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = \Faker\Factory::create();

		foreach ($this->getDepartamentos() as $departamento) {
			foreach ($departamento['ciudades'] as $key => $ciudad ) {
				$departamento['ciudades'][$key]['tiempo_estimado'] = $faker->numberBetween(5, 10);
			}
			App\Departamento::create([ 'nombre' => $departamento['nombre'] ])
				->ciudades()
				->createMany($departamento['ciudades']);
		}
	}

	private function getDepartamentos() {
		return [
			[
				'nombre' => 'Central',
				'ciudades' => [
					[ 'nombre' => 'Asunción' ],
					[ 'nombre' => 'Luque' ],
					[ 'nombre' => 'San Lorenzo' ],
					[ 'nombre' => 'Capiatá' ],
					[ 'nombre' => 'Lambaré' ],
					[ 'nombre' => 'Fernando de la Mora' ],
					[ 'nombre' => 'Limpio' ],
					[ 'nombre' => 'Ñemby' ],
					[ 'nombre' => 'Itauguá' ],
					[ 'nombre' => 'Mariano Roque Alonso' ],
					[ 'nombre' => 'Villa Elisa' ],
					[ 'nombre' => 'Itá' ],
					[ 'nombre' => 'Areguá' ],
					[ 'nombre' => 'San Antonio' ],
					[ 'nombre' => 'Julián Augusto Saldívar' ],
					[ 'nombre' => 'Ypané' ],
					[ 'nombre' => 'Villeta' ],
					[ 'nombre' => 'Guarambaré' ],
					[ 'nombre' => 'Ypacaraí' ],
					[ 'nombre' => 'Nueva Italia' ]
				]
			],
			[
				'nombre' => 'Boquerón',
				'ciudades' => [
					[ 'nombre' => 'Mariscal José Félix Estigarribia' ],
					[ 'nombre' => 'Filadelfia' ],
					[ 'nombre' => 'Loma Plata' ]
				]
			],
			[
				'nombre' => 'Alto Paraná',
				'ciudades' => [
					[ 'nombre' => 'Ciudad del Este' ],
					[ 'nombre' => 'Presidente Franco' ],
					[ 'nombre' => 'Minga Guazú' ],
					[ 'nombre' => 'Hernandarias' ],
					[ 'nombre' => 'Itakyry' ],
					[ 'nombre' => 'Santa Rita' ],
					[ 'nombre' => 'Juan Emilio OLeary' ],
					[ 'nombre' => 'Doctor Juan León Mallorquín' ],
					[ 'nombre' => 'Minga Porá' ],
					[ 'nombre' => 'San Alberto' ],
					[ 'nombre' => 'Yguazú' ],
					[ 'nombre' => 'San Cristóbal' ],
					[ 'nombre' => 'Los Cedrales' ],
					[ 'nombre' => 'Ñacunday' ],
					[ 'nombre' => 'Doctor Raúl Peña' ],
					[ 'nombre' => 'Mbaracayú' ],
					[ 'nombre' => 'Tavapy' ],
					[ 'nombre' => 'Santa Rosa del Monday' ],
					[ 'nombre' => 'Naranjal' ],
					[ 'nombre' => 'Iruña' ],
					[ 'nombre' => 'Domingo Martínez de Irala' ],
					[ 'nombre' => 'Santa Fe del Paraná' ]
				]
			],
			[
				'nombre' => 'Amambay',
				'ciudades' => [
					[ 'nombre' => 'Pedro Juan Caballero' ],
					[ 'nombre' => 'Capitán Bado' ],
					[ 'nombre' => 'Bella Vista Norte' ],
					[ 'nombre' => 'Zanja Pytá' ],
					[ 'nombre' => 'Karapaí' ]
				]
			],
			[
				'nombre' => 'Alto Paraguay',
				'ciudades' => [
					[ 'nombre' => 'Puerto Casado' ],
					[ 'nombre' => 'Capitán Carmelo Peralta' ],
					[ 'nombre' => 'Fuerte Olimpo' ],
					[ 'nombre' => 'Bahía Negra' ]
				]
			],
			[
				'nombre' => 'Caaguazú',
				'ciudades' => [
					[ 'nombre' => 'Caaguazú' ],
					[ 'nombre' => 'Coronel Oviedo' ],
					[ 'nombre' => 'Doctor Juan Eulogio Estigarribia' ],
					[ 'nombre' => 'Yhú' ],
					[ 'nombre' => 'Repatriación' ],
					[ 'nombre' => 'Doctor Juan Manuel Frutos' ],
					[ 'nombre' => 'San José de los Arroyos' ],
					[ 'nombre' => 'San Joaquín' ],
					[ 'nombre' => 'Raúl Arsenio Oviedo' ],
					[ 'nombre' => 'Carayaó' ],
					[ 'nombre' => 'Tembiaporá' ],
					[ 'nombre' => 'Santa Rosa del Mbutuy' ],
					[ 'nombre' => 'Vaquería' ],
					[ 'nombre' => 'José Domingo Ocampos' ],
					[ 'nombre' => 'Tres de Febrero' ],
					[ 'nombre' => 'R. I. Tres Corrales' ],
					[ 'nombre' => 'Doctor Cecilio Báez' ],
					[ 'nombre' => 'Mariscal Francisco Solano López' ],
					[ 'nombre' => 'Simón Bolívar' ],
					[ 'nombre' => 'La Pastora' ],
					[ 'nombre' => 'Nueva Toledo' ],
					[ 'nombre' => 'Nueva Londres' ]
				]
			],
			[
				'nombre' => 'Caazapá',
				'ciudades' => [
					[ 'nombre' => 'San Juan Nepomuceno' ],
					[ 'nombre' => 'Abaí' ],
					[ 'nombre' => 'Caazapá' ],
					[ 'nombre' => 'Yuty' ],
					[ 'nombre' => 'Tres de Mayo' ],
					[ 'nombre' => 'Tavaí' ],
					[ 'nombre' => 'Fulgencio Yegros' ],
					[ 'nombre' => 'General Higinio Morínigo' ],
					[ 'nombre' => 'Buena Vista' ],
					[ 'nombre' => 'Doctor Moisés Santiago Bertoni' ],
					[ 'nombre' => 'Maciel' ]
				]
			],
			[
				'nombre' => 'Canindeyú',
				'ciudades' => [
					[ 'nombre' => 'Curuguaty' ],
					[ 'nombre' => 'Salto del Guairá' ],
					[ 'nombre' => 'Yasy Cañy' ],
					[ 'nombre' => 'Villa Ygatimí' ],
					[ 'nombre' => 'Ybyrarobaná' ],
					[ 'nombre' => 'Nueva Esperanza' ],
					[ 'nombre' => 'General Francisco Caballero Álvarez' ],
					[ 'nombre' => 'Yby Pytá' ],
					[ 'nombre' => 'Corpus Christi' ],
					[ 'nombre' => 'La Paloma del Espíritu Santo' ],
					[ 'nombre' => 'Katueté' ],
					[ 'nombre' => 'Ypejhú' ],
					[ 'nombre' => 'Itanará' ],
					[ 'nombre' => 'Maracaná' ]
				]
			],
			[
				'nombre' => 'Concepción',
				'ciudades' => [
					[ 'nombre' => 'Concepción' ],
					[ 'nombre' => 'Horqueta' ],
					[ 'nombre' => 'Yby Yaú' ],
					[ 'nombre' => 'Loreto' ],
					[ 'nombre' => 'Belén' ],
					[ 'nombre' => 'San Lázaro' ],
					[ 'nombre' => 'Azotey' ],
					[ 'nombre' => 'Sargento José Félix López' ],
					[ 'nombre' => 'San Alfredo' ],
					[ 'nombre' => 'Paso Barreto' ],
					[ 'nombre' => 'San Carlos del Apa' ],
					[ 'nombre' => 'Arroyito' ]
				]
			],
			[
				'nombre' => 'Cordillera',
				'ciudades' => [
					[ 'nombre' => 'Caacupé' ],
					[ 'nombre' => 'Tobatí' ],
					[ 'nombre' => 'Piribebuy' ],
					[ 'nombre' => 'Arroyos y Esteros' ],
					[ 'nombre' => 'Eusebio Ayala' ],
					[ 'nombre' => 'Emboscada' ],
					[ 'nombre' => 'Atyrá' ],
					[ 'nombre' => 'Altos' ],
					[ 'nombre' => 'Caraguatay' ],
					[ 'nombre' => 'San Bernardino' ],
					[ 'nombre' => 'Itacurubí de la Cordillera' ],
					[ 'nombre' => 'Isla Pucú' ],
					[ 'nombre' => 'Valenzuela' ],
					[ 'nombre' => 'Juan de Mena' ],
					[ 'nombre' => 'Primero de Marzo' ],
					[ 'nombre' => 'Santa Elena' ],
					[ 'nombre' => 'San José Obrero' ],
					[ 'nombre' => 'Mbocayaty del Yhaguy' ],
					[ 'nombre' => 'Nueva Colombia' ],
					[ 'nombre' => 'Loma Grande' ]
				]
			],
			[
				'nombre' => 'Guairá',
				'ciudades' => [
					[ 'nombre' => 'Villarrica' ],
					[ 'nombre' => 'Independencia' ],
					[ 'nombre' => 'Paso Yobái' ],
					[ 'nombre' => 'Capitán Mauricio José Troche' ],
					[ 'nombre' => 'Borja' ],
					[ 'nombre' => 'Iturbe' ],
					[ 'nombre' => 'Mbocayaty del Guairá' ],
					[ 'nombre' => 'General Eugenio Alejandrino Garay' ],
					[ 'nombre' => 'Itapé' ],
					[ 'nombre' => 'José A. Fassardi' ],
					[ 'nombre' => 'Coronel Martínez' ],
					[ 'nombre' => 'Félix Pérez Cardozo' ],
					[ 'nombre' => 'Natalicio Talavera' ],
					[ 'nombre' => 'Yataity del Guairá' ],
					[ 'nombre' => 'Ñumí' ],
					[ 'nombre' => 'Tebicuary' ],
					[ 'nombre' => 'San Salvador' ],
					[ 'nombre' => 'Doctor Bottrell' ]
				]
			],
			[
				'nombre' => 'Itapúa',
				'ciudades' => [
					[ 'nombre' => 'Encarnación' ],
					[ 'nombre' => 'Cambyretá' ],
					[ 'nombre' => 'San Pedro del Paraná' ],
					[ 'nombre' => 'Tomás Romero Pereira' ],
					[ 'nombre' => 'Edelira' ],
					[ 'nombre' => 'San Rafael del Paraná' ],
					[ 'nombre' => 'Natalio' ],
					[ 'nombre' => 'Coronel José Félix Bogado' ],
					[ 'nombre' => 'Carlos Antonio López' ],
					[ 'nombre' => 'Alto Verá' ],
					[ 'nombre' => 'Itapúa Poty' ],
					[ 'nombre' => 'Obligado' ],
					[ 'nombre' => 'Mayor Julio Dionisio Otaño' ],
					[ 'nombre' => 'Hohenau' ],
					[ 'nombre' => 'Capitán Meza' ],
					[ 'nombre' => 'Bella Vista' ],
					[ 'nombre' => 'Capitán Miranda' ],
					[ 'nombre' => 'Yatytay' ],
					[ 'nombre' => 'General Artigas' ],
					[ 'nombre' => 'Fram' ],
					[ 'nombre' => 'San Cosme y Damián' ],
					[ 'nombre' => 'San Juan del Paraná' ],
					[ 'nombre' => 'Trinidad' ],
					[ 'nombre' => 'Pirapó' ],
					[ 'nombre' => 'Carmen del Paraná' ],
					[ 'nombre' => 'General Delgado' ],
					[ 'nombre' => 'Nueva Alborada' ],
					[ 'nombre' => 'Jesús' ],
					[ 'nombre' => 'José Leandro Oviedo' ],
					[ 'nombre' => 'La Paz' ]
				]
			],
			[
				'nombre' => 'Misiones',
				'ciudades' => [
					[ 'nombre' => 'San Ignacio Guazú' ],
					[ 'nombre' => 'San Juan Bautista' ],
					[ 'nombre' => 'Santa Rosa de Lima' ],
					[ 'nombre' => 'Ayolas' ],
					[ 'nombre' => 'Santa María de Fe' ],
					[ 'nombre' => 'Santiago' ],
					[ 'nombre' => 'San Miguel' ],
					[ 'nombre' => 'San Patricio' ],
					[ 'nombre' => 'Villa Florida' ],
					[ 'nombre' => 'Yabebyry' ]
				]
			],
			[
				'nombre' => 'Ñeembucú',
				'ciudades' => [
					[ 'nombre' => 'Pilar' ],
					[ 'nombre' => 'Alberdi' ],
					[ 'nombre' => 'San Juan Bautista del Ñeembucú' ],
					[ 'nombre' => 'Cerrito' ],
					[ 'nombre' => 'Mayor José de Jesús Martínez' ],
					[ 'nombre' => 'General José Eduvigis Díaz' ],
					[ 'nombre' => 'Tacuaras' ],
					[ 'nombre' => 'Villa Oliva' ],
					[ 'nombre' => 'Laureles' ],
					[ 'nombre' => 'Humaitá' ],
					[ 'nombre' => 'Isla Umbú' ],
					[ 'nombre' => 'Villalbín' ],
					[ 'nombre' => 'Guazú Cuá' ],
					[ 'nombre' => 'Paso de Patria' ],
					[ 'nombre' => 'Desmochados' ],
					[ 'nombre' => 'Villa Franca' ]
				]
			],
			[
				'nombre' => 'Paraguarí',
				'ciudades' => [
					[ 'nombre' => 'Carapeguá' ],
					[ 'nombre' => 'Yaguarón' ],
					[ 'nombre' => 'Ybycuí' ],
					[ 'nombre' => 'Paraguarí' ],
					[ 'nombre' => 'Quiindy' ],
					[ 'nombre' => 'Pirayú' ],
					[ 'nombre' => 'Acahay' ],
					[ 'nombre' => 'Mbuyapey' ],
					[ 'nombre' => 'San Roque González de Santa Cruz' ],
					[ 'nombre' => 'Escobar' ],
					[ 'nombre' => 'Caapucú' ],
					[ 'nombre' => 'Quyquyhó' ],
					[ 'nombre' => 'Ybytymí' ],
					[ 'nombre' => 'General Bernardino Caballero' ],
					[ 'nombre' => 'Sapucai' ],
					[ 'nombre' => 'La Colmena' ],
					[ 'nombre' => 'Tebicuarymí' ],
					[ 'nombre' => 'María Antonia' ]
				]
			],
			[
				'nombre' => 'Presidente Hayes',
				'ciudades' => [
					[ 'nombre' => 'Villa Hayes' ],
					[ 'nombre' => 'Teniente Primero Manuel Irala Fernández' ],
					[ 'nombre' => 'Benjamín Aceval' ],
					[ 'nombre' => 'Puerto Pinasco' ],
					[ 'nombre' => 'Nanawa' ],
					[ 'nombre' => 'José Falcón' ],
					[ 'nombre' => 'Teniente Esteban Martínez' ],
					[ 'nombre' => 'General José María Bruguez' ]
				]
			],
			[
				'nombre' => 'San Pedro',
				'ciudades' => [
					[ 'nombre' => 'San Estanislao' ],
					[ 'nombre' => 'Capiibary' ],
					[ 'nombre' => 'Santa Rosa del Aguaray' ],
					[ 'nombre' => 'San Pedro de Ycuamandiyú' ],
					[ 'nombre' => 'Guayaibí' ],
					[ 'nombre' => 'Choré' ],
					[ 'nombre' => 'General Isidoro Resquín' ],
					[ 'nombre' => 'Liberación' ],
					[ 'nombre' => 'General Elizardo Aquino' ],
					[ 'nombre' => 'Tacuatí' ],
					[ 'nombre' => 'Yrybucuá' ],
					[ 'nombre' => 'Yataity del Norte' ],
					[ 'nombre' => 'Lima' ],
					[ 'nombre' => 'Itacurubí del Rosario' ],
					[ 'nombre' => 'Villa del Rosario' ],
					[ 'nombre' => '25 de Diciembre' ],
					[ 'nombre' => 'Unión' ],
					[ 'nombre' => 'Nueva Germania' ],
					[ 'nombre' => 'Antequera' ],
					[ 'nombre' => 'San Pablo' ],
					[ 'nombre' => 'San Vicente Pancholo' ]
				]
			]
		];
	}
}
