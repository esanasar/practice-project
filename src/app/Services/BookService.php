<?php

namespace App\Services;

use App\Http\Resources\BookResource;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class BookService
{
    public function __construct(protected BookRepositoryInterface $bookRepository){}

    public function index(int|null $perPage = 10)
    {
        return Cache::remember('books:all', 60, function () use ($perPage) {
            $books = $this->bookRepository->all();
            return BookResource::collection($books)->resolve();
        });
    }

    public function store(array $data)
    {
        Cache::forget("books:all");

        return $this->bookRepository->create($data);
    }

}