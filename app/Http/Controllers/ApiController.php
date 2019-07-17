<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse as Response;

abstract class ApiController extends Controller implements HttpStatusCodes
{
    /* Inspiration ASP to make this status code methods */

    // Success response methods

    /**
     * @param  $message
     *
     * @return Response
     */
    protected function Ok($message): Response
    {
        return response()->json($message, static::OK);
    }

    /**
     * @param string $message
     *
     * @return Response
     */
    protected function Created(string $message): Response
    {
        return response()->json(['message' => $message], static::CREATED);
    }

    /**
     * @return Response
     */
    protected function NoContent(): Response
    {
        return response()->json(null, static::NO_CONTENT);
    }

    // Client response methods

    /**
     * @param string $error
     *
     * @return Response
     */
    protected function BadRequest(string $error): Response
    {
        return response()->json(['error' => $error], static::BAD_REQUEST);
    }

    /**
     * @param string $error
     *
     * @return Response
     */
    protected function Unauthorized(string $error): Response
    {
        return response()->json(['error' => $error], static::UNAUTHORIZED);
    }

    /**
     * @param string $error
     *
     * @return Response
     */
    protected function Conflict(string $error): Response
    {
        return response()->json(['error' => $error], static::CONFLICT);
    }

    /**
     * @param string $error
     *
     * @return Response
     */
    protected function NotFound(string $error): Response
    {
        return response()->json(['error' => $error], static::NOT_FOUND);
    }

    // Server response methods

    /**
     * @param string $error
     *
     * @return Response
     */
    protected function ServerError(string $error = 'Server error, please try later.'): Response
    {
        return response()->json(['error' => $error], static::INTERNAL_SERVER_ERROR);
    }
}
