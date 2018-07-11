<?php

namespace App\Exceptions;

use Exception;
use http\Env\Request;
use Throwable;

/**
 * @author Isaac Buitrago
 *
 * Class EmailInUseException Used to handle exceptions caused by
 * creating an account with an existing email.
 * @package App\Exceptions
 */
class EmailInUseException extends Exception
{
    /**
     * EmailInUseException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Log the exception
     * @param Exception $exception
     */
    public function report(Exception $exception)
    {

    }

    /**
     * Render HTTP response for exception
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(Request $request)
    {
        return response()->json(['message' => $this->getMessage(), 'status'=> 403]);
    }
}
