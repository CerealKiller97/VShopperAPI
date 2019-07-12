<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\GroupDTO;
use App\Exceptions\EntityNotFoundException;
use App\Models\Group;
use App\Helpers\PagedResponse;
use App\Contracts\GroupContract;
use App\Http\Requests\{
    PagedRequest,
    GroupRequest

};

class GroupEloquentService extends BaseService implements GroupContract
{
    /**
     * @param PagedRequest $request
     *
     * @return PagedResponse
     */
    public function getGroups(PagedRequest $request): PagedResponse
    {
        $page = $request->getPaging()->page;
        $perPage = $request->getPaging()->perPage;
        $name = $request->getPaging()->name;

        $group = new Group;
        $account_id = auth()->user()->id;

        $acc = $group->where('account_id', $account_id);
        $items = $this->generatePagedResponse($acc, $perPage, $page, $name);

        $default = Group::default()->get();

        $final = $default->merge($items);

        $groupCount = $final->count();

        $groupsArr = [];

        foreach ($final as $group) {
            $groupDTO = new GroupDTO;

            $groupDTO->id = $group->id;
            $groupDTO->name = $group->name;

            $groupsArr[] = $groupDTO;
        }

        return new PagedResponse($groupsArr, $groupCount, $page);
    }

    /**
     * @param int $id
     *
     * @return GroupDTO
     * @throws EntityNotFoundException
     */
    public function findGroup(int $id): GroupDTO
    {
        $acc = auth()->user()->groups;
        $group = Group::find($id);

        $this->policy->can($acc, $group, 'Group');

        $groupDTO = new GroupDTO;

        $groupDTO->id = $group->id;
        $groupDTO->name = $group->name;

        return $groupDTO;
    }

    /**
     * @param GroupRequest $request
     */
    public function addGroup(GroupRequest $request): void
    {
        $group = Group::create($request->validated());
        auth()->user()->groups()->save($group);
    }

    /**
     * @param GroupRequest $request
     * @param int          $id
     *
     * @throws EntityNotFoundException
     */
    public function updateGroup(GroupRequest $request, int $id): void
    {
        $acc = auth()->user()->groups;
        $group = Group::find($id);

        $this->policy->can($acc, $group, 'Group');

        $group->fill($request->validated());
        $group->save();
    }

    /**
     * @param int $id
     *
     * @throws EntityNotFoundException
     */
    public function deleteGroup(int $id): void
    {
        $acc = auth()->user()->groups;
        $group = Group::find($id);

        $this->policy->can($acc, $group, 'Group');

        $group->delete();
    }
}
