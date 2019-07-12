<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\DiscountHasNoPrice;
use App\Http\Requests\DiscountRequest;
use App\Contracts\ProductDiscountContract;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\InvalidDiscountException;
use Log;
use QueryException;

class DiscountsController extends ApiController
{
    private $service;

    public function __construct(ProductDiscountContract $service)
    {
        $this->service = $service;
    }

    /**
     * Add a discount to specific product.
     *
     * @queryParam id int required Represents an id of a product
     * @bodyParam amount int required Represents an amount of discount
     * @bodyParam valid_from date required Represents start date of discount
     * @bodyParam valid_until date required Represents end date of discount
     * @bodyParam group_id int  Represents an id of group that you will assign this discount to
     *
     *
     * @response 201 {
     *   "message": "Successfully added new discount to product"
     * }
     *
     * @response 404 {
     *   "error" : "Product not found."
     * }
     *
     * @response 409 {
     *   "error" : "Product doesn't have initial price."
     * }
     *
     * @response 500 {
     *   "error" : "Server error, please try later."
     * }
     *
     */
    public function add(DiscountRequest $request, int $id)
    {
        try {
            $this->service->addDiscountToProduct($request, $id);
            return $this->Created('Successfully added new discount to product');
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (DiscountHasNoPrice $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (InvalidDiscountException $e) {
            Log::error($e->getMessage());
            return $this->Conflitct($e->getMessage());
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }

    /**
     * Update a discount to specific product.
     *
     * @queryParam id int required Represents an id of a product
     * @bodyParam amount int required Represents an amount of discount
     * @bodyParam valid_from date required Represents start date of discount
     * @bodyParam valid_until date required Represents end date of discount
     * @bodyParam group_id int  Represents an id of group that you will assign this discount to
     *
     *
     * @response 204 {
     *
     * }
     *
     * @response 404 {
     *   "error" : "Product not found."
     * }
     *
     * @response 409 {
     *   "error" : "Product doesn't have initial price."
     * }
     *
     * @response 409 {
     *   "error" : "Discount must be lower than current price."
     * }
     *
     * @response 500 {
     *   "error" : "Server error, please try later."
     * }
     *
     */
    public function update(DiscountRequest $request, int $id)
    {
        try {
            $this->service->upateDiscountFromProduct($request, $id);
            return $this->NoContent();
        } catch (EntityNotFoundException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (InvalidDiscountException $e) {
            Log::error($e->getMessage());
            return $this->NotFound($e->getMessage());
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->ServerError();
        }
    }
}
