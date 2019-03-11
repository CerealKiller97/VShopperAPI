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
  public function getAccount() : AccountDTO
  {
    $acc = request()->user();

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

  public function getAccountByEmailAndPassword($email, $password) : AccountDTO
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
    Account::create($request->validated());
  }

  public function deactivateAccount($id)
  {

  }

  public function updateAccount(AccountRequest $request, int $id)
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

  public function verified(string $email) : bool
  {
    $auth = Account::where([
      ['email', '=', $email],
      ['email_verified_at', '!=', null]
    ])->first();

    if (!$auth)
      throw new NotVerifiedException('Your account is not verified!');

    return true;
  }

  public function changePassword(int $id, string $password)
  {

  }
}
