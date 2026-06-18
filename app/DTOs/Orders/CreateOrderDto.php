<?php

namespace App\DTOs\Orders;

use InvalidArgumentException;

class CreateOrderDto
{
    public function __construct(
        public readonly int $orderAddressId,
        public readonly array $items,
        public readonly ?string $notes = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        if (!isset($data['order_address_id'])) {
            throw new InvalidArgumentException('order_address_id is required.');
        }

        return new self(
            orderAddressId: (int) $data['order_address_id'],
            items: array_map(
                static fn (array $item) => OrderItemDto::fromArray($item),
                $data['items'] ?? [],
            ),
            notes: $data['notes'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'notes' => $this->notes,
            'order_address_id' => $this->orderAddressId,
        ];
    }
}
