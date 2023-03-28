<?php

namespace Cjpanilag\SimpleNotifications\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class UndefinedUserException
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class UndefinedUserException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return simpleResponse()
            ->failed()
            ->message('Failed to create a notification. User is undefined.')
            ->generate();
    }
}
