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

    /**
     *
     * Sucess status code functions
     *
     */

   //  public function ok($data)
   //  {
   //     return response()->json($data, SELF::OK);
   //  }

   //  public function created($data)
   //  {
   //     return response()->json($data, SELF::CREATED);
   //  }

   //  public function noContent($data)
   //  {
   //     return response()->json($data, SELF::NO_CONTENT);
   //  }

   //  /**
   //   *
   //   * Client errors status codes funcitons
   //   *
   //   */

   //  public function badRequest($data)
   //  {
   //     return response()->json($data, SELF::BAD_REQUEST);
   //  }

   //  public function unauthorized($data)
   //  {
   //     return response()->json($data, SELF::UNAUTHORIZED);
   //  }

   //  public function forbidden($data)
   //  {
   //     return response()->json($data, SELF::FORBIDDEN);
   //  }

   //  public function notFound($data)
   //  {
   //     return response()->json($data, SELF::NOT_FOUND);
   //  }

   //  public function methodNotAllowed($data)
   //  {
   //     return response()->json($data, SELF::METHOD_NOT_ALLOWED);
   //  }

   //  public function conflict($data)
   //  {
   //     return response()->json($data, SELF::CONFLICT);
   //  }

   //  public function unproccessableEntity($data)
   //  {
   //     return response()->json($data, SELF::UNPROCCESSABLE_ENTITY);
   //  }

   //  public function internalServerError($data)
   //  {
   //     return response()->json($data, SELF::INTERNAL_SERVER_ERROR);
   //  }

   //  public function badGateway($data)
   //  {
   //     return response()->json($data, SELF::BAD_GATEWAY);
   //  }
}
