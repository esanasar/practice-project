<?php

namespace App\Repositories\Contracts;

interface BookRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function decrementStock(int $id, int $qty): bool;
    public function create(array $data);


}