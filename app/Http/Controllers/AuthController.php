<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Str;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$client = new Client();
		$uri = 'http://juicee-gridsome-design/oauth/token';
		$form_params = [
			'client_id' => config('services.passport.client_id'),
			'client_secret' => config('services.passport.client_secret'),
			'email' => $request->email,
			'password' => $request->password,
			'grant_type' => 'password'
		];
		$result = $client->post($uri, [
			'form_params' => [
				'client_id' => config('services.passport.client_id'),
				'client_secret' => config('services.passport.client_secret'),
				'email' => $request->email,
				'password' => $request->password,
				'grant_type' => 'password'
			]
		]);
		$request = new GuzzleHttp\Psr7\Request(
			'POST',
			$uri,
			[
				'Authorization' => 'Bearer ' . $token,
				'Content-Type' => 'application/x-www-form-urlencoded'

			],
			http_build_query($form_params, null, '&')
		);

		return reponse()->json([
			'response' => $result
		]);
	}
}
