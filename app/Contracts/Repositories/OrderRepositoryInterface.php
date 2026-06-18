<?php

namespace App\Contracts\Repositories;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function create(array $data): Order;

    public function getAll(): LengthAwarePaginator;

    public function findOrFail(int $id): Order;

    public function update(Order $order, array $data): Order;

    public function delete(Order $order): void;
}
