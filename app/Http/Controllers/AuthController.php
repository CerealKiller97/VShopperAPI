<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Contracts\IAccount;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\ApiController;

class AuthController extends ApiController
{

    public function __construct(IAccount $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        try {
            $this->service->verified($request->username);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), self::INTERNAL_SERVER_ERROR);
        }
        // $auth = \DB::table('accounts')->where([
        //     ['email', '=', $request->username],
        //     ['email_verified_at', '!=', null]
        // ])->first();

        // if (!$auth) {
        //     return response()->json('Your account is not verified!', 500);
        // }

        $http = new \GuzzleHttp\Client;
        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    }

    public function register()
    {

    }

    public function logout()
    {
        \DB::table('oauth_access_tokens')
            ->where('user_id', auth()->user()->id)
            ->delete();
        return response()->json('Logged out successfully', 200);
    }
}
