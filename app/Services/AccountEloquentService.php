<?php

namespace App\Services;

use Exception;
use App\Models\Account;
use App\Contracts\IAccount;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AccountRequest;

class AccountEloquentService  implements IAccount
{
  public function getAllAccounts()
  {
    return Account::all();
  }

  public function getAccountByEmailAndPassword($email, $password)
  {
    $user = Account::where([
      ['email', $email],
      ['password', Hash::make($password)]
    ])->first();

    if (!$user) {
      throw new Exception('No user found', 404);
    }
    return $user;

  }

  public function registerAccount(AccountRequest $request)
  {

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

  public function findAccount(int $id)
  {

  }

  public function verified(string $email)
  {
    $auth = Account::where([
      ['email', '=', $email],
      ['email_verified_at', '!=', null]
    ])->first();

      if (!$auth)
      {
        throw new Exception('Your account is not verified!', 500);
      }
  }
}
