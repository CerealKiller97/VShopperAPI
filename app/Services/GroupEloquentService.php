<?php

namespace App\Services;

use App\DTO\GroupDTO;
use App\Models\Group;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Contracts\GroupContract;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\PagedRequest;

class GroupEloquentService extends BaseService implements GroupContract
{
  public function getGroups(PagedRequest $request) // : PagedResponse
  {
    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;
    $name = $request->getPaging()->name;

    $group = new Group;
    $account_id =  auth()->user()->id;

    $acc = $group->where('account_id', $account_id);
    $items = $this->generatePagedResponse($acc, $perPage, $page, $name);

    $default = Group::default()->get();

    $final = $default->merge($items);

    $groupCount = $final->count();

    $groupsArr = [];

    foreach($final as $group)
    {
      $groupDTO = new GroupDTO;

      $groupDTO->id = $group->id;
      $groupDTO->name = $group->name;

      $groupsArr[] = $groupDTO;
    }

    return new PagedResponse($groupsArr, $groupCount, $page);
  }

  public function findGroup(int $id) : GroupDTO
  {
    $acc = auth()->user()->groups;
    $group = Group::find($id);

    $this->policy->can($acc, $group, 'Group');

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
    $acc = auth()->user()->groups;
    $group = Group::find($id);

    $this->policy->can($acc, $group, 'Group');

    $group->fill($request->validated());
    $group->save();
  }

  public function deleteGroup(int $id)
  {
    $acc = auth()->user()->groups;
    $group = Group::find($id);

    $this->policy->can($acc, $group, 'Group');

    $group->delete();
  }

}
