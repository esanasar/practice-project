<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MissingIdempotencyKeyException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function store(StoreOrderRequest $request)
    {
        $key = $request->header('idempotency_key');

        $order = $this->orderService->store($request->items, $key);

        return new OrderResource($order);
    }
}
