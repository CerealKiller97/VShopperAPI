<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\StorageTypeDTO;
use App\Exceptions\EntityNotFoundException;
use App\Models\StorageType;
use App\Helpers\PagedResponse;
use App\Http\Requests\{
    PagedRequest,
    StorageTypeRequest

};
use App\Contracts\StorageTypeContract;

class StorageTypeEloquentService extends BaseService implements StorageTypeContract
{
    /**
     * @param PagedRequest $request
     *
     * @return PagedResponse
     */
    public function getStorageTypes(PagedRequest $request): PagedResponse
    {
        $page = $request->getPaging()->page;
        $perPage = $request->getPaging()->perPage;
        $name = $request->getPaging()->name;

        $storageTypes = new StorageType;
        $account_id = auth()->user()->id;

        $acc = $storageTypes->where('account_id', $account_id);
        $items = $this->generatePagedResponse($acc, $perPage, $page, $name)->toArray();
        $storageTypesCount = auth()->user()->storageTypes->count();

        $default = StorageType::default()->get()->toArray();
        $acc = auth()->user()->storageTypes->toArray();
        $storageTypes = array_merge($default, $acc);
        $storageTypesTotal = count($storageTypes);

        $storageTypesArr = [];
        foreach ($storageTypes as $storageType) {
            $storageTypeDTO = new StorageTypeDTO;

            $storageTypeDTO->id = $storageType['id'];
            $storageTypeDTO->name = $storageType['name'];

            $storageTypesArr[] = $storageTypeDTO;
        }

        return new PagedResponse($storageTypesArr, $storageTypesTotal, $page);
    }

    /**
     * @param int $id
     *
     * @return StorageTypeDTO
     * @throws EntityNotFoundException
     */
    public function findStorageType(int $id): StorageTypeDTO
    {
        $acc = auth()->user()->storageTypes;
        $storageType = StorageType::find($id);

        $this->policy->can($acc, $storageType, 'Storage type');

        $storageTypeDTO = new StorageTypeDTO;

        $storageTypeDTO->id = $storageType->id;
        $storageTypeDTO->name = $storageType->name;

        return $storageTypeDTO;
    }

    /**
     * @param StorageTypeRequest $request
     */
    public function addStorageType(StorageTypeRequest $request): void
    {
        $storageType = StorageType::create($request->validated());
        auth()->user()->storageTypes()->save($storageType);
    }

    /**
     * @param StorageTypeRequest $request
     * @param int                $id
     *
     * @throws EntityNotFoundException
     */
    public function updateStorageType(StorageTypeRequest $request, int $id): void
    {
        $acc = auth()->user()->storageTypes;
        $storageType = StorageType::find($id);

        $this->policy->can($acc, $storageType, 'Storage type');

        $storageType->fill($request->validated());
        $storageType->save();
    }

    /**
     * @param int $id
     *
     * @throws EntityNotFoundException
     */
    public function deleteStorageType(int $id): void
    {
        $acc = auth()->user()->storageTypes;
        $storageType = StorageType::find($id);

        $this->policy->can($acc, $storageType, 'Storage type');

        $storageType->delete();
    }
}
