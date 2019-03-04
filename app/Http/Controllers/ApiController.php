<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class ApiController extends Controller
{
    protected $service;
    // Sucess status codes

    protected const OK = 200;
    protected const CREATED = 201;
    protected const NO_CONTENT = 204;
    // Client errors status codes
    protected const BAD_REQUEST = 400;
    protected const UNAUTHORIZED = 401;
    protected const FORBIDDEN = 403;
    protected const NOT_FOUND = 404;
    protected const METHOD_NOT_ALLOWED = 405;
    protected const CONFLICT = 409;
    protected const UNPROCCESSABLE_ENTITY = 422;
    // Server errors status codes
    protected const INTERNAL_SERVER_ERROR = 500;
    protected const BAD_GATEWAY = 502;

   public function __construct($service)
   {
      $this->service = $service;
   }

}
