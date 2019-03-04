<?php

namespace App\Contracts;

use App\Http\Requests\AccountRequest;

interface IAccount
{
  public function getAllAccounts();
  public function getAccountByEmailAndPassword(string $email,string $password);
  public function registerAccount(AccountRequest $request);
  public function deactivateAccount(int $id);
  public function deleteAccount(int $id);
  public function updateAccount(int $id, AccountRequest $request);
  public function findAccount(int $id);
  public function verified(string $email);

}
