<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data): Order
    {
        return Order::query()->create($data);
    }

    public function getAll(): LengthAwarePaginator
    {
        return Order::with(['user', 'address', 'items.product', 'payments.attempts'])
            ->paginate();
    }

    public function findOrFail(int $id): Order
    {
        return Order::with(['user', 'address', 'items.product', 'payments.attempts'])
            ->findOrFail($id);
    }

    public function update(Order $order, array $data): Order
    {
        $order->fill($data);
        $order->save();

        return $order;
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }
}
