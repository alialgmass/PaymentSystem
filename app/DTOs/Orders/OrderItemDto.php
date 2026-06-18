<?php

namespace App\DTOs\Orders;

class OrderItemDto
{
    public function __construct(
        public readonly int $productId,
        public readonly int $quantity,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            productId: (int) ($data['id'] ?? $data['product_id']),
            quantity: (int) ($data['quantity'] ?? 1),
        );
    }
}
