<?php

namespace App\Services;

use App\DTO\GroupDTO;
use App\Models\Group;
use App\Contracts\GroupContract;
use App\Http\Requests\GroupRequest;
use App\Exceptions\EntityNotFoundException;

class GroupEloquentService implements GroupContract
{
  public function getGroups() : array
  {
    $default = Group::default()->get()->toArray();
    $acc = auth()->user()->groups->toArray();
    $groups = array_merge($default, $acc);

    $groupsArr = [];
    foreach($groups as $group)
    {
      $groupDTO = new GroupDTO;

      $groupDTO->id = $group['id'];
      $groupDTO->name = $group['name'];

      $groupsArr[] = $groupDTO;
    }

    return ['data' => $groupsArr];
  }

  public function findGroup(int $id) : GroupDTO
  {
    $group = Group::find($id);

    if (!$group) {
      throw new EntityNotFoundException('Group not found');
    }

    $groupDTO = new GroupDTO;

    $groupDTO->id = $group->id;
    $groupDTO->name = $group->name;

    return $groupDTO;
  }

  public function addGroup(GroupRequest $request)
  {
    $group = Group::create($request->validated());
    auth()->user()->groups()->save($group);
  }

  public function updateGroup(GroupRequest $request, int $id)
  {
    $group = Group::find($id);

    if (!$group) {
      throw new EntityNotFoundException('Group not found');
    }

    $group->fill($request->validated());
    $group->save();
  }

  public function deleteGroup(int $id)
  {
    $group = Group::find($id);

    if (!$group) {
      throw new EntityNotFoundException('Group not found');
    }

    $group->delete();
  }

}
