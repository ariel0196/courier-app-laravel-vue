<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Usuario;

class AuthController extends Controller
{
	public function login (Request $request) {

		$usuario = Usuario::where('email', $request->email)->first();

		if ($usuario) {

			if (Hash::check($request->password, $usuario->password)) {

				$usuario->token = Hash::make('secret');
				$usuario->save();
				return response(['user' => $usuario], 200);

			} else {

				$response = "Contraseña incorrecta.";
				return response($response, 422);
			}

		} else {

			$response = 'El Usuario no existe.';
			return response($response, 422);
		}
	}

	public function logout (Request $request) {

		$usuario = Usuario::where('email', $request->email)->first();

		if ($usuario) {

			$usuario->token = null;
			$usuario->save();
			return response($usuario, 200);

		} else {

			$response = 'usuario does not exist';
			return response($response, 422);
		}
	}
}
