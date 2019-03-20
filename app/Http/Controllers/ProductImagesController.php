<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\ProductContract;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\ApiController;

class ProductImagesController extends ApiController
{
    public function __construct(ProductContract $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    public function add(Request $request, int $id)
    {
        dd($request->all());
    }

    public function delete(Request $request, int $id)
    {
        dd($id);
    }
}
