<?php

namespace App\Actions\Orders;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\DTOs\Orders\OrderItemDto;
use App\ValueObjects\OrderTotalValue;

class CalculatePrice
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {}

    public function __invoke(OrderItemDto ...$items): OrderTotalValue
    {
        $price = 0;

        foreach ($items as $item) {
            $productPrice = $this->productRepository->findPrice($item->productId);
            $price += $productPrice * $item->quantity;
        }

        return OrderTotalValue::create((int) round($price));
    }
}
