<?php

namespace App\Http\Controllers;

interface HttpStatusCodes
{
    // Success status codes
    const OK = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;
    // Client errors status codes
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const CONFLICT = 409;
    const UNPROCCESSABLE_ENTITY = 422;
    // Server errors status codes
    const INTERNAL_SERVER_ERROR = 500;
    const BAD_GATEWAY = 502;
}
