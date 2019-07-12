<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\GroupDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\PagedRequest;

interface GroupContract
{
    public function getGroups(PagedRequest $request): PagedResponse;

    public function findGroup(int $id): GroupDTO;

    public function addGroup(GroupRequest $request): void;

    public function updateGroup(GroupRequest $request, int $id): void;

    public function deleteGroup(int $id): void;
}

