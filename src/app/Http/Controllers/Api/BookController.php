<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function __construct(protected BookService $bookService) {}

    public function index()
    {
        return $this->bookService->index();
    }

    public function store(StoreBookRequest $request)
    {
        $book = $this->bookService->store(
            $request->validated()
        );

        return new BookResource($book);
    }
}
