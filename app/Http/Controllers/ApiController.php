<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse as Response;

abstract class ApiController extends Controller implements HttpStatusCodes
{
    /* Inspiration ASP to make this status code methods */

    // Success response methods

    protected function Ok($message): Response
    {
        return response()->json($message, static::OK);
    }

    protected function Created(string $message): Response
    {
        return response()->json(['message' => $message], static::CREATED);
    }

    protected function NoContent(): Response
    {
        return response()->json(null, static::NO_CONTENT);
    }

    // Client response methods
    protected function BadRequest(string $error): Response
    {
        return response()->json(['error' => $error], static::BAD_REQUEST);
    }

    protected function Unauthorized(string $error): Response
    {
        return response()->json(['error' => $error], static::UNAUTHORIZED);
    }

    protected function Conflict(string $error): Response
    {
        return response()->json(['error' => $error], static::CONFLICT);
    }

    protected function NotFound(string $error): Response
    {
        return response()->json(['error' => $error], static::NOT_FOUND);
    }

    // Server response methods

    protected function ServerError(string $error = 'Server error, please try later.'): Response
    {
        return response()->json(['error' => $error], static::INTERNAL_SERVER_ERROR);
    }
}
