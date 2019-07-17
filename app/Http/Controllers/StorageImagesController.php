<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\{
    ImageRequest,
    ImageBatchRequest

};
use App\Contracts\StorageImageContract;
use App\Exceptions\{
    BatchDeleteException,
    EntityNotFoundException

};
use Illuminate\Http\JsonResponse as Response;
use Log;

class StorageImagesController extends ApiController
{
    private $service;

    /**
     * StorageImagesController constructor.
     *
     * @param StorageImageContract $service
     */
    public function __construct(StorageImageContract $service)
    {
        $this->service = $service;
    }

    /**
     * @param ImageRequest $request
     * @param int          $id
     *
     * @return JsonResponse
     */
    public function add(ImageRequest $request, int $id): Response
    {
        try {
            $this->service->addPicturesToStorage($request, $id);
            return $this->Created('Successfully added new picture to storage');
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * @param ImageBatchRequest $request
     * @param int               $id
     *
     * @return JsonResponse
     */
    public function delete(ImageBatchRequest $request, int $id): Response
    {
        try {
            $this->service->deletePicturesToStorage($request, $id);
            return $this->NoContent();
        } catch (BatchDeleteException $e) {
            Log::error($e->getMessage());
            return $this->Conflitct($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }
}
