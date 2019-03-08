<?php

namespace App\Services;

use Exception;
use App\DTO\AccountDTO;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Contracts\AccountContract;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AccountRequest;
use Illuminate\Database\QueryException;
use App\Exceptions\NotVerifiedException;
use App\Exceptions\EntityNotFoundException;

class AccountEloquentService implements AccountContract
{
  public function getAllAccounts()
  {
    $accounts =  Account::all();
    $accountDTO = null;
    $data = [];

    foreach ($accounts as $acc) {
      $accountDTO = new AccountDTO();
      $accountDTO->id = $acc->id;
      $accountDTO->name = $acc->name;
      $accountDTO->email = $acc->email;
      $accountDTO->address = $acc->address;
      $data[] = $accountDTO;
    }
    // if data length > 0 return array else empty [] TODO:: ask Luka
    return $data;
  }

  public function getAccountByEmailAndPassword($email, $password)
  {
    $user = Account::where([
      ['email', $email],
      ['password', Hash::make($password)]
    ])->first();

    if (!$user) {
      throw new EntityNotFoundException('No Account found');
    }
    return $user;

  }

  public function registerAccount(AccountRequest $request)
  {
    try {
      Account::create($request->validated());
    } catch(QueryException $e) {
      \Log::error($e->getMessage());
    }
  }

  public function deactivateAccount($id)
  {

  }

  public function deleteAccount(int $id)
  {

  }

  public function updateAccount($id, AccountRequest $request)
  {

  }

  public function findAccount(int $id) : AccountDTO
  {
    $account = Account::find($id);

    if (!$account)
      throw new EntityNotFoundException('Account not found');

    $accountDTO = new AccountDTO();
    $accountDTO->id = $account->id;
    $accountDTO->name = $account->name;
    $accountDTO->email = $account->email;
    $accountDTO->address = $account->address;

    return $accountDTO;
  }

  public function verified(string $email)
  {
    $auth = Account::where([
      ['email', '=', $email],
      ['email_verified_at', '!=', null]
    ])->first();

    if (!$auth)
      throw new NotVerifiedException('Your account is not verified!');

    return true;
  }

  public function profile() : AccountDTO
  {
    $acc = request()->user();
    //dd($acc);
    // Creating AccountDTO and filling it with data
    $accountDTO = new AccountDTO();
    $accountDTO->id = $acc->id;
    $accountDTO->name = $acc->name;
    $accountDTO->email = $acc->email;
    $accountDTO->address = $acc->address;
    // Return AccountDTO object back to front

    //FIX:: The Response content must be a string or object implementing __toString(), \"object\" given
    return $accountDTO;
  }
}
