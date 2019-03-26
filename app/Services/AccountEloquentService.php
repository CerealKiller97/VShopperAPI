<?php

namespace App\Services;

use Exception;
use App\Models\Image;
use App\DTO\AccountDTO;
use App\Models\Account;
use App\Helpers\UploadFile;
use App\Services\BaseService;
use App\Contracts\AccountContract;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AccountRequest;
use Illuminate\Database\QueryException;
use App\Exceptions\NotVerifiedException;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\ChangeAccountPasswordRequest;

class AccountEloquentService extends BaseService implements AccountContract
{
  public function getAccount() : AccountDTO
  {
    $acc = auth()->user();

    //Creating AccountDTO and filling it with data

    $accountDTO = new AccountDTO;
    $accountDTO->id = $acc->id;
    $accountDTO->name = $acc->name;
    $accountDTO->email = $acc->email;
    $accountDTO->address = $acc->address;

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
    $src = UploadFile::move($request->image);
    $image_id = Image::create($src)->id;

     Account::create([
       'name'      => $request->name,
       'email'     => $request->email,
       'password'  => Hash::make($request->password),
       'address'   => $request->address,
       'image_id' => $image_id
     ]);
  }

  public function deactivateAccount()
  {
    /*
     $acc = auth()->user();
     $acc->update([
       'deactivate' => true
     ])
    */
  }

  public function updateAccount(UpdateAccountRequest $request, int $id)
  {
    $acc = auth()->user();
    $acc->fill($request->validated());

    $acc->save();

  }

  public function findAccount(int $id) : AccountDTO
  {
    $account = Account::find($id);

    if (!$account) {
      throw new EntityNotFoundException('Account not found');
    }

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

  public function verifyAccountByToken(string $token)
  {
    dd($token);
  }


  public function changePassword(ChangeAccountPasswordRequest $request)
  {
    $user = auth()->user();
    $user->update(['password' => Hash::make($request->password)]);
  }

}
