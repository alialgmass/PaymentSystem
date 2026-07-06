<?php

namespace App\Services;

use App\Actions\Orders\CalculatePrice;
use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Services\OrderServiceInterface;
use App\DTOs\Orders\CreateOrderDto;
use App\DTOs\Orders\UpdateOrderDto;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CalculatePrice $calculatePrice,
    ) {}

    public function create(CreateOrderDto $dto): Order
    {
        $items = $dto->items;
        $orderTotal = ($this->calculatePrice)(...$items);

        return DB::transaction(function () use ($dto, $items, $orderTotal) {
            $order = $this->orderRepository->create([
                'number' => $this->generateOrderNumber(),
                'total' => $orderTotal->getTotal()->getAmount(),
                'currency' => 'EGP',
                'notes' => $dto->notes,
                'order_address_id' => $dto->orderAddressId,
                'user_id' => auth()->id(),
            ]);

            foreach ($items as $item) {
                $productPrice = $this->productRepository->findPrice($item->productId);

                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $item->productId,
                    'price' => $productPrice,
                    'quantity' => $item->quantity,
                    'total' => $productPrice * $item->quantity,
                ]);
            }

            return $this->orderRepository->findOrFail($order->id);
        });
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->orderRepository->getAll();
    }

    public function findOrFail(int $id): Order
    {
        return $this->orderRepository->findOrFail($id);
    }

    public function update(int $id, UpdateOrderDto $dto): Order
    {
        $order = $this->orderRepository->findOrFail($id);

        return $this->orderRepository->update($order, $dto->toArray());
    }

    public function destroy(int $id): void
    {
        $order = $this->orderRepository->findOrFail($id);
        $this->orderRepository->delete($order);
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}
