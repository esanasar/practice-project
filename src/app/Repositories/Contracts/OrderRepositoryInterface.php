<?php

namespace App\Repositories\Contracts;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function findByKey(string $key);
    public function create(array $data);
    public function createItems(Order $order, array $items);
}