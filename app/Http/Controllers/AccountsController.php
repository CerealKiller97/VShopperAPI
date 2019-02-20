<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Mail\AccountVerification;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return AccountResource::collection(Account::all());
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
        $account = Account::create($request->validated());
        \Mail::to($account->email)->queue(new AccountVerification($account));
        return response()->json('Successfully registered!', 201);
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
    public function show(Account $account)
    {
      try {
        return response()->json(new AccountResource($account), 200);
      } catch (Exception $ex) {
        Log::error($ex);
        return response()->json('No user found', 404);
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
}
