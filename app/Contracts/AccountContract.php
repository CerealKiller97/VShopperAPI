<?php

namespace App\Contracts;

use App\DTO\AccountDTO;
use Illuminate\Http\Request;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\ChangeAccountPasswordRequest;

interface AccountContract
{
  public function getAccount() : AccountDTO;
  public function findAccount(int $id) : AccountDTO;
  public function getAccountByEmailAndPassword(string $email, string $password) : AccountDTO;
  public function registerAccount(AccountRequest $request);
  public function deactivateAccount();
  public function updateAccount(UpdateAccountRequest $request, int $id);
  public function verified(string $email) : bool;
  public function verifyAccountByToken(string $token);
  public function changePassword(ChangeAccountPasswordRequest $request);
}
