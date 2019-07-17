<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\{
    ImageRequest,
    ImageBatchRequest

};
use App\Contracts\ProductImageContract;
use App\Exceptions\{
    BatchDeleteException,
    EntityNotFoundException

};
use \Illuminate\Http\JsonResponse as Response;
use Log;

class ProductImagesController extends ApiController
{
    private $service;

    /**
     * ProductImagesController constructor.
     *
     * @param ProductImageContract $service
     */
    public function __construct(ProductImageContract $service)
    {
        $this->service = $service;
    }

    /**
     * @param ImageRequest $request
     * @param int          $id
     *
     * @return Response
     */
    public function add(ImageRequest $request, int $id): Response
    {
        try {
            $this->service->addPicturesToProduct($request, $id);
            return $this->Created('Successfully added new picture to product');
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
     * @return Response
     */
    public function delete(ImageBatchRequest $request, int $id): Response
    {
        try {
            $this->service->deletePicturesFromProduct($request, $id);
            return $this->NoContent();
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (BatchDeleteException $e) {
            Log::error($e->getMessage());
            return $this->Conflitct($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }
}
