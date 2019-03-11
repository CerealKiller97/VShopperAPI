<?php

namespace App\Contracts;

use App\Http\Requests\GroupRequest;

interface GroupContract
{
  public function getGroups();
  public function findGroup(int $id);
  public function addGroup(GroupRequest $request);
  public function updateGroup(GroupRequest $request, int $id);
  public function removeGroup(int $id);
}
