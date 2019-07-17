<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use DB;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use App\Contracts\AccountContract;
use Illuminate\Http\JsonResponse as Response;

class AuthController extends ApiController
{
    private $service;

    public function __construct(AccountContract $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function login(Request $request): Response
    {
        // try {
        //     $this->service->verified($request->username);
        // } catch (NotVerifiedException $e) {
        //     return response()->json($e->getMessage());
        // }

        // $auth = \DB::table('accounts')->where([
        //     ['email', '=', $request->username],
        //     ['email_verified_at', '!=', null]
        // ])->first();

        // if (!$auth) {
        //     return response()->json('Your account is not verified!', 500);
        // }


        $http = new Client();
        try {
            $response = $http->post(config('services.passport.login_endpoint'), ['form_params' => ['grant_type' => 'password', 'client_id' => config('services.passport.client_id'), 'client_secret' => config('services.passport.client_secret'), 'username' => $request->username, 'password' => $request->password,]]);
            // $cookie_name = 'token';
            // $groupToken = Crypt::encrypt('1');
            // setcookie($cookie_name, $groupToken, time() + (86400 * 30), "/"); // 86400 = 1 day
            $data = $response->getBody();
            dd($data);
        } catch (BadResponseException $e) {
            if ($e->getCode() === 400) {
                return $this->BadRequest('Invalid Request. Please enter a username or a password.');
            } else if ($e->getCode() === 401) {
                return $this->Unauthorized('You credentials are incorrect. Please try again.');
            }
            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    }

    /**
     * @return Response
     */
    public function register(): Response
    {

    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        try {
            DB::table('oauth_access_tokens')->where('user_id', auth()->user()->id)->delete();

            return $this->Ok('Logged out successfully');
        } catch (Exception $e) {
            return $this->ServerError();
        }
    }
}
