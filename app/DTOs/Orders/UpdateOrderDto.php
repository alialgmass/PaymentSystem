<?php

namespace App\DTOs\Orders;

class UpdateOrderDto
{
    public function __construct(
        public readonly ?string $number = null,
        public readonly ?float $total = null,
        public readonly ?string $currency = null,
        public readonly ?string $status = null,
        public readonly ?string $notes = null,
        public readonly ?int $userId = null,
        public readonly ?int $orderAddressId = null,
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
            orderAddressId: isset($data['order_address_id']) ? (int) $data['order_address_id'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'number' => $this->number,
            'total' => $this->total,
            'currency' => $this->currency,
            'status' => $this->status,
            'notes' => $this->notes,
            'user_id' => $this->userId,
            'order_address_id' => $this->orderAddressId,
        ], static fn ($value) => $value !== null);
    }
}
