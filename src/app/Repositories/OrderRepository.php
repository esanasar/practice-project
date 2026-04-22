<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{

    public function findByKey(string $key)
    {
        return Order::where('idempotency_key', $key)->first();
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function createItems(Order $order, array $items)
    {
        return $order->items()->createMany($items);
    }

}