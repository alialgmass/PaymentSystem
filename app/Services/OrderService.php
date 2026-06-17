<?php

namespace App\Services;


use App\DTOs\Orders\CreateOrderDto;
use App\DTOs\Orders\UpdateOrderDto;
use App\Models\Order;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function create(CreateOrderDto $dto): Order
    {
        $data=array_merge($dto->toArray(),[
            'price'=>
        ]);
        $order= Order::query()->create($data);

        return $order;
    }

    public function getAll()
    {
        return Order::with(['user', 'address', 'items.product', 'payments.attempts'])
            ->paginate();
    }

    public function findOrFail(int $id): Order
    {
        return Order::with(['user', 'address', 'items.product', 'payments.attempts'])
            ->findOrFail($id);
    }

    public function update(int $id, UpdateOrderDto $dto): Order
    {
        $order = Order::findOrFail($id);
        $order->fill($dto->toArray());
        $order->save();

        return $order;
    }

    public function destroy(int $id): void
    {
        $order = Order::findOrFail($id);
        $order->delete();
    }
}
