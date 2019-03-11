<?php

namespace App\Contracts;

use App\DTO\AccountDTO;
use App\Http\Requests\AccountRequest;

interface AccountContract
{
  public function getAccount() : AccountDTO;
  public function getAccountByEmailAndPassword(string $email,string $password);
  public function registerAccount(AccountRequest $request);
  public function deactivateAccount(int $id);
  public function updateAccount(int $id, AccountRequest $request);
  public function findAccount(int $id) : AccountDTO;
  public function verified(string $email);
  public function changePassword(int $id, string $password);
}
