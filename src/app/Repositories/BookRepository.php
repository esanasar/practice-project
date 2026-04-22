<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    public function all()
    {
        return Book::all();
    }

    public function find(int $id)
    {
        return Book::findOrFail($id);
    }

    public function decrementStock(int $id, int $quantity) : bool
    {
        return Book::where('id', $id)
            ->where('stock', '>=', $quantity)
            ->decrement('stock', $quantity) > 0;
    }

    public function create(array $data)
    {
        return Book::create($data);
    }



}