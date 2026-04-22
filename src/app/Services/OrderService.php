<?php

namespace App\Services;

use App\Exceptions\OutOfStockException;
use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderService
{

    public function __construct(protected BookRepositoryInterface $book, protected OrderRepositoryInterface $order)
    {
    }

    public function store(array $items, string $orderKey)
    {
        if ($existingOrder = $this->order->findByKey($orderKey)) {
            return $existingOrder;
        }

        try {

            return DB::transaction(function () use ($items, $orderKey){
                $totalPrice = 0;
                $orderItems = [];

               foreach ($items as $item){
                   $bookId = $item['book_id'];
                   $quantity = $item['quantity'];

                   Cache::lock("book:$bookId",5)->block(3, function () use(
                       $bookId,
                       $quantity,
                       &$totalPrice,
                       &$orderItems
                   ){
                       $success =$this->book->decrementStock($bookId, $quantity);

                       if (!$success) {
                           throw new OutOfStockException($bookId);
                       }

                       $book = $this->book->find($bookId);

                       $totalPrice += $book->price * $quantity;

                       $orderItems[] = [
                         'book_id' => $bookId,
                         'price' => $book->price,
                         'quantity' => $quantity
                       ];
                   });
               }

               $order = $this->order->create([
                   'idempotency_key' => $orderKey,
                   'total_price' => $totalPrice
               ]);

               $this->order->createItems($order, $orderItems);

               return $order;
            });

        } catch (\Illuminate\Database\QueryException $exception) {

            if ($exception->getCode() == 23000){
                return $this->order->findByKey($orderKey);
            }

            throw $exception;
        }
    }

}