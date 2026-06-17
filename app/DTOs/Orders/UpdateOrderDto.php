<?php

namespace App\DTOs\Orders;

use InvalidArgumentException;

class UpdateOrderDto
{
    public function __construct(
        public ?string $number = null,
        public ?float $total = null,
        public ?string $currency = null,
        public ?string $status = null,
        public ?string $notes = null,
        public ?int $userId = null,
        public ?int $orderAddressId = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            number: $data['number'] ?? null,
            total: isset($data['total']) ? (float) $data['total'] : null,
            currency: isset($data['currency']) ? strtoupper((string) $data['currency']) : null,
            status: $data['status'] ?? null,
            notes: $data['notes'] ?? null,
            userId: isset($data['user_id']) ? (int) $data['user_id'] : null,
            orderAddressId: isset($data['order_address_id']) ? (int) $data['order_address_id'] : null
        );
    }

    public function toArray(): array
    {
        $data = [
            'number' => $this->number,
            'total' => $this->total,
            'currency' => $this->currency,
            'status' => $this->status,
            'notes' => $this->notes,
            'user_id' => $this->userId,
            'order_address_id' => $this->orderAddressId,
        ];

        return array_filter($data, fn ($value) => !is_null($value));
    }
}
