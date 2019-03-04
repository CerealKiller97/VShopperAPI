<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Mail\AccountVerification;
use App\Contracts\AccountContract;
use App\Http\Requests\AccountRequest;
use App\Http\Controllers\ApiController;
use App\Http\Resources\AccountResource;
use App\Exceptions\EntityNotFoundException;


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
      return response()->json($this->service->getAllAccounts(), SELF::OK);
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
        return response()->json('Server error!', 500);
        \Log::error($e);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
      try {
        $account->delete();
        return response()->json('Successfully deleted', 204);
      } catch (Exception $e) {
        \Log::error($e->getMessage());
        return response()->json('Server error!', 400);
      }
    }

    public function profile()
    {
      return $this->service->profile(request());
    }
}
