<?php

namespace App\Contracts;

use App\DTO\AccountDTO;
use App\Http\Requests\AccountRequest;

interface AccountContract
{
  public function getAccount() : AccountDTO;
  public function getAccountByEmailAndPassword(string $email,string $password) : AccountDTO;
  public function registerAccount(AccountRequest $request) : void;
  public function deactivateAccount(int $id) : void;
  public function deleteAccount(int $id) : void;
  public function updateAccount(int $id, AccountRequest $request) : void;
  public function findAccount(int $id) : AccountDTO;
  public function verified(string $email) :boolean;
  public function changePassword(int $id, string $password);
}
