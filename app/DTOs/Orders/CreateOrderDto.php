<?php
namespace App\DTOs\Orders;
use InvalidArgumentException;

class CreateOrderDto
{
    public function __construct(
        public ?string $number = null,
        public float $total,
        public string $currency,
        public string $status = 'pending',
        public ?string $notes = null,
        public int $userId,
        public int $orderAddressId
    ) {}

    public static function fromRequest(array $data): self
    {
        if (!isset($data['total'], $data['currency'], $data['user_id'], $data['order_address_id'])) {
            throw new InvalidArgumentException('Required fields are missing: total, currency, user_id, order_address_id.');
        }

        return new self(
            number: $data['number'] ?? null,
            total: (float) $data['total'],
            currency: strtoupper((string) $data['currency']),
            status: $data['status'] ?? 'pending',
            notes: $data['notes'] ?? null,
            userId: (int) $data['user_id'],
            orderAddressId: (int) $data['order_address_id']
        );
    }

    public function toModel(): \App\Models\Order
    {
        return new \App\Models\Order([
            'number' => $this->number,
            'total' => $this->total,
            'currency' => $this->currency,
            'status' => $this->status,
            'notes' => $this->notes,
            'user_id' => $this->userId,
            'order_address_id' => $this->orderAddressId,
        ]);
    }
}
