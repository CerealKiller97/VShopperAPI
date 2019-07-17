<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use App\Contracts\AccountContract;
use App\Http\Requests\{
    AccountRequest,
    UpdateAccountRequest,
    ChangeAccountPasswordRequest

};
use App\Exceptions\EntityNotFoundException;
use Log;
use QueryException;
use \Illuminate\Http\JsonResponse as Response;

class AccountsController extends ApiController
{
    private $service;

    public function __construct(AccountContract $service)
    {
        $this->service = $service;
    }

    /**
     * Get authenticated user's info
     *
     * @response 200 {
     *  "id": 6,
     * "name": "Test Test",
     * "email": "test@test.com",
     * "address": "adress"
     * }
     */
    public function index()
    {
        return $this->Ok($this->service->getAccount());
    }

    /**
     * Add new account
     *
     * @bodyParam name string required Represents name of a account
     * @bodyParam email string required Represents email of a account
     * @bodyParam password string required Represents password of a account
     * @bodyParam address string required Represents address of a account
     * @bodyParam image image required Represents an image of a account
     *
     *
     * @response  201 {
     * "message": "Successfully registered!"
     * }
     * @response  500 {
     *    "error": "Server error please try again"
     * }
     *
     * @param AccountRequest $request
     *
     * @return Response
     */
    public function store(AccountRequest $request): Response
    {
        try {
            $this->service->registerAccount($request);
            // \Mail::to($request->email)->queue(new AccountVerification($account));
            return $this->Created('Successfully registered!');
        } catch (QueryException $e) {
            Log::error($e);
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Get specific account info
     *
     * @queryParam id required The id of the account
     *
     * @response   200 {
     *  "id": 6,
     * "name": "Test Test",
     * "email": "test@test.com",
     * "address": "adress"
     * }
     * @response   404 {
     *   "message": "Account not found"
     * }
     * @response   500 {
     *   "error": "Server error, plase try again"
     * }
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        try {
            $user = $this->service->findAccount($id);
            return $this->Ok($user);
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Update the authenticated user's account
     *
     * @bodyParam name string required Represents name of a account
     * @bodyParam address string required Represents address of a account
     * @bodyParam image Formdata required Represents image file of a account
     *
     * @response  204{
     *
     * }
     * @response  404 {
     *   "message": "Account not found"
     * }
     * @response  500 {
     *   "error": "Server error, plase try again"
     * }
     *
     * @param UpdateAccountRequest $request
     * @param                      $id
     *
     * @return Response
     */
    public function update(UpdateAccountRequest $request, $id): Response
    {
        try {
            $this->service->updateAccount($request, $id);
            return $this->NoContent();
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Deactivate authenticated user's account
     *
     * @response 204 {
     * }
     *
     * }
     * @response 404 {
     *   "message": "Account not found"
     * }
     * @response 500 {
     *   "error": "Server error, plase try again"
     * }
     *
     * @param int $id
     *
     * @return Response
     */

    public function destroy(int $id): Response
    {
        try {
            Account::find($id)->delete();
            //$account->delete();
            return $this->NoContent();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Change account password
     *
     * @response  204{
     *
     * }
     *
     * @response  500 {
     *   "error": "Server error, plase try again"
     * }
     *
     * @param ChangeAccountPasswordRequest $request
     *
     * @return Response
     */

    public function changePassword(ChangeAccountPasswordRequest $request): Response
    {
        try {
            $this->service->changePassword($request);
            return $this->NoContent();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }
}
