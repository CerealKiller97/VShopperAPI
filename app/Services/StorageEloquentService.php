<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\StorageDTO;
use App\Exceptions\EntityNotFoundException;
use App\Models\Storage;
use App\Helpers\PagedResponse;
use App\Contracts\StorageContract;
use App\Http\Requests\{
    StorageRequest,
    StorageSearchRequest

};
use StdClass;

class StorageEloquentService extends BaseService implements StorageContract
{
    /**
     * @param StorageSearchRequest $request
     *
     * @return PagedResponse
     */
    public function getStorages(StorageSearchRequest $request): PagedResponse
    {
        $page = $request->getPaging()->page;
        $perPage = $request->getPaging()->perPage;

        $storages = new Storage;
        $account_id = auth()->user()->id;

        $acc = $storages->where('account_id', $account_id);
        $items = $this->generatePagedResponse($acc, $perPage, $page);
        $storagesCount = auth()->user()->storages->count();

        $storagesArr = [];

        foreach ($items as $storage) {
            $storageDTO = new StorageDTO;

            $storageDTO->id = $storage->id;
            $storageDTO->address = $storage->address;
            $storageDTO->size = $storage->size;
            $storageDTO->storage_name = $storage->type->name;

            $tmp = $storage->images;
            $images = $tmp->map(function ($item) {
                $image = new StdClass;
                $image->id = $item->id;
                $image->src = $item->src;

                return $image;
            });

            $storageDTO->images = $images;
            $storagesArr[] = $storageDTO;
        }

        return new PagedResponse($storagesArr, $storagesCount, $page);
    }

    /**
     * @param int $id
     *
     * @return StorageDTO
     * @throws EntityNotFoundException
     */
    public function findStorage(int $id): StorageDTO
    {
        $acc = auth()->user()->storages;
        $storage = Storage::find($id);

        $this->policy->can($acc, $storage, 'Storage');

        $storageDTO = new StorageDTO;

        $storageDTO->id = $storage->id;
        $storageDTO->address = $storage->address;
        $storageDTO->size = $storage->size;
        $storageDTO->storage_name = $storage->type->name;

        $storageImages = $storage->images;

        $images = $storageImages->map(function ($item) {
            $image = new StdClass;
            $image->id = $item->id;
            $image->src = $item->src;

            return $image;
        });

        $storageDTO->images = $images;

        return $storageDTO;
    }

    /**
     * @param StorageRequest $request
     */
    public function addStorage(StorageRequest $request): void
    {
        auth()->user()->storages()->create($request->validated());
    }

    /**
     * @param StorageRequest $request
     * @param int            $id
     *
     * @throws EntityNotFoundException
     */
    public function updateStorage(StorageRequest $request, int $id): void
    {
        $acc = auth()->user()->storages;
        $storage = Storage::find($id);

        $this->policy->can($acc, $storage, 'Storage');

        $storage->fill($request->validated());
        $storage->save();
    }

    /**
     * @param int $id
     *
     * @throws EntityNotFoundException
     */
    public function deleteStorage(int $id): void
    {
        $acc = auth()->user()->storages;
        $storage = Storage::find($id);

        $this->policy->can($acc, $storage, 'Storage');

        $storage->delete();
    }
}
