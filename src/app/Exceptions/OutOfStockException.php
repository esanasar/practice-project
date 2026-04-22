<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class OutOfStockException extends Exception
{
    protected int $bookId;

    public function __construct(int $bookId)
    {
        parent::__construct("Book with ID {$bookId} is out of stock");
        $this->bookId = $bookId;
    }

    public function render()
    {
        return response()->json([
            'error' => 'this book is out of stock',
            'book_id' => $this->bookId
        ], 422);
    }
}
