<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'provider' => ['required', 'in:google.com,own'],
            'id_token' => ['required_if:provider,==,google.com'],
            'user_name' => ['required', 'email', 'exists:users,email'],
            'password' => ['required_if:provider,==,portal'],
        ]);

        try {

            $user = User::where('email', $request->user_name)->first();

            // $client = new Google_Client(['client_id' => env('WEB_GOOGLE_CLIENT_ID')]);

            //TODO:We will add after if ($request->provider == 'google.com' && $client->verifyIdToken($request->id_token)) {
            if ($request->provider == 'google.com') {
                $user = User::where('email', $request->user_name)->first();
                return response([
                    RESPONSE_MESSAGE => AUTH_CONFIRMED_MESSAGES,
                    RESPONSE_DATA => [
                        'user' => $user,
                        'access_token' => $user->createToken('authToken')->accessToken
                    ],
                ], Response::HTTP_OK);
            } else if ($request->provider == 'own' && Hash::check($request->password, $user->password)) {
                return response([
                    RESPONSE_MESSAGE => AUTH_CONFIRMED_MESSAGES,
                    RESPONSE_DATA => [
                        'user' => $user,
                        'access_token' => $user->createToken('authToken')->accessToken
                    ],
                ], Response::HTTP_OK);
            } else {
                return response([
                    RESPONSE_MESSAGE => AUTH_CONFIRMED_MESSAGES,
                    RESPONSE_ERRORS => [
                        Str::lower(RESPONSE_MESSAGE) => USERNAME_AND_PASSWORD_INCORRECT_MESSAGES
                    ],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}