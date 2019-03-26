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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return $this->Ok($this->service->getAccount());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Change account's password.
     *
     * @param  ChangeAccountPasswordRequest  $request
     * @return void
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
