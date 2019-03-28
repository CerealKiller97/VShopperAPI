<?php

namespace App\Http\Controllers;

use Exception;
use App\DTO\AccountDTO;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Mail\AccountVerification;
use App\Contracts\AccountContract;
use App\Http\Requests\AccountRequest;
use App\Http\Controllers\ApiController;
use App\Http\Resources\AccountResource;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\ChangeAccountPasswordRequest;


class AccountsController extends ApiController
{
  public function __construct(AccountContract $service)
  {
    parent::__construct($service);
    $this->service = $service;
  }

    /**
     * Get authenticated user's info
     *
     * @response 200 {
     *  "id": 6,
        "name": "Test Test",
        "email": "test@test.com",
        "address": "adress"
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
     * @response 201 {
         "message": "Successfully registered!"
     * }
     * @response 500 {
     *    "error": "Server error please try again"
     * }
     */
    public function store(AccountRequest $request)
    {
      try {
        $this->service->registerAccount($request);
        // \Mail::to($request->email)->queue(new AccountVerification($account));
        return $this->Created('Successfully registered!');
      } catch (\QueryException $e) {
        \Log::error($e);
        return $this->ServerError();
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        return $this->ServerError();
      }
    }

    /**
     * Get specific account info
     *
     * @queryParam id required The id of the account
     *
     * @response 200 {
     *  "id": 6,
        "name": "Test Test",
        "email": "test@test.com",
        "address": "adress"
     * }
     * @response 404 {
     *   "message": "Account not found"
     * }
     * @response 500 {
     *   "error": "Server error, plase try again"
     * }
     */
    public function show(int $id)
    {
      try {
        $user = $this->service->findAccount($id);
        return $this->Ok($user);
      } catch (EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return $this->NotFound($e->getMessage());
      } catch (Exception $e) {
        \Log::error($e->getMessage());
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
     *  @response 404 {
     *   "message": "Account not found"
     * }
     * @response 500 {
     *   "error": "Server error, plase try again"
     * }
     */
    public function update(UpdateAccountRequest $request, $id)
    {
      try {
        $this->service->updateAccount($request, $id);
        return $this->NoContent();
      } catch (EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return $this->NotFound($e->getMessage());
      } catch(\QueryException $e) {
        \Log::error($e->getMessage());
        return $this->ServerError();
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        return $this->ServerError();
      }
    }

    /**
     * Deactivate authenticated user's account
     * @response 204 {
     * }
     *
     * }
     *  @response 404 {
     *   "message": "Account not found"
     * }
     * @response 500 {
     *   "error": "Server error, plase try again"
     * }
     */

    public function destroy(int $id)
    {
      try {
        $account->delete();
        return $this->NoContent();
      } catch (Exception $e) {
        \Log::error($e->getMessage());
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
     * @response 500 {
     *   "error": "Server error, plase try again"
     * }
     */

    public function changePasswrod(ChangeAccountPasswordRequest $request)
    {
      try {
        $this->service->changePassword($request);
        return $this->NoContent();
      }  catch(\QueryException $e) {
        \Log::error($e->getMessage());
        return $this->ServerError();
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        return $this->ServerError();
      }
    }
}
