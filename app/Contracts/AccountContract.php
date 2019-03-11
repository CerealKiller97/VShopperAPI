<?php

namespace App\Contracts;

use App\DTO\AccountDTO;
use App\Http\Requests\AccountRequest;

interface AccountContract
{
  public function getAccount() : AccountDTO;
  public function findAccount(int $id) : AccountDTO;
  public function getAccountByEmailAndPassword(string $email,string $password) : AccountDTO;
  public function registerAccount(AccountRequest $request);
  public function deactivateAccount(int $id);
  public function updateAccount(AccountRequest $request, int $id);
  public function verified(string $email) : bool;
  public function changePassword(int $id, string $password);
}
