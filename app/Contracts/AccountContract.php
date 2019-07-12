<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\AccountDTO;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\ChangeAccountPasswordRequest;

interface AccountContract
{
    public function getAccount(): AccountDTO;

    public function findAccount(int $id): AccountDTO;

    public function getAccountByEmailAndPassword(string $email, string $password): AccountDTO;

    public function registerAccount(AccountRequest $request): void;

    public function deactivateAccount(): void;

    public function updateAccount(UpdateAccountRequest $request, int $id): void;

    public function verified(string $email): bool;

    public function verifyAccountByToken(string $token): void;

    public function changePassword(ChangeAccountPasswordRequest $request): void;
}
