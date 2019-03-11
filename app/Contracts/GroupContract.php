<?php

namespace App\Contracts;

use App\DTO\GroupDTO;
use App\Http\Requests\GroupRequest;

interface GroupContract
{
  public function getGroups() : array;
  public function findGroup(int $id) : GroupDTO;
  public function addGroup(GroupRequest $request);
  public function updateGroup(GroupRequest $request, int $id);
  public function removeGroup(int $id);
}
