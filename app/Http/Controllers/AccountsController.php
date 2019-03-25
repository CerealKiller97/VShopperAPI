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
      return response()->json($this->service->getAccount(), SELF::OK);
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
        return response()->json('Successfully registered!', SELF::CREATED);
      } catch (\QueryException $e) {
        \Log::error($e);
        return response()->json('Server error!', 500);
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
        return response()->json($user, SELF::OK);
      } catch (EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return response()->json($e->getMessage());
      } catch (Exception $e) {
        \Log::error($e->getMessage());
        return response()->json($e->getMessage());
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
        return response()->json(null, SELF::NO_CONTENT);
      } catch (EntityNotFoundException $e) {
        \Log::error($e->getMessage());
        return response()->json($e->getMessage(), SELF::NOT_FOUND);
      } catch(\QueryException $e) {
        \Log::error($e->getMessage());
        return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        return response()->json('Server Error', SELF::INTERNAL_SERVER_ERROR);
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
        return response()->json('Successfully deleted', 204);
      } catch (Exception $e) {
        \Log::error($e->getMessage());
        return response()->json('Server error!', 400);
      }
    }

    public function changePasswrod(ChangeAccountPasswordRequest $request)
    {
      try {
        $this->service->changePassword($request);
        return response()->json(null, SELF::NO_CONTENT);
      }  catch(\QueryException $e) {
        \Log::error($e->getMessage());
        return response()->json($e->getMessage(), SELF::INTERNAL_SERVER_ERROR);
      } catch(Exception $e) {
        \Log::error($e->getMessage());
        return response()->json($e->getMessage(), SELF::INTERNAL_SERVER_ERROR);
      }
    }
}
