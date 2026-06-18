<?php

namespace App\Contracts\Services;

use App\DTOs\Orders\CreateOrderDto;
use App\DTOs\Orders\UpdateOrderDto;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderServiceInterface
{
    public function create(CreateOrderDto $dto): Order;

    public function getAll(): LengthAwarePaginator;

    public function findOrFail(int $id): Order;

    public function update(int $id, UpdateOrderDto $dto): Order;

    public function destroy(int $id): void;
}
