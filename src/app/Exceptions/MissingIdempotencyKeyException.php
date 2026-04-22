<?php

namespace App\Exceptions;

use Exception;

class MissingIdempotencyKeyException extends Exception
{
    public function render()
    {
        return response()->json([
            'error' => 'Idempotency key is required'
        ], 400);
    }
}
