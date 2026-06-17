<?php
namespace App\DTOs\Orders;
use App\Models\Order;
use InvalidArgumentException;

class CreateOrderDto
{
    public function __construct(
        public ?string $notes = null,
        public int $orderAddressId,
        public array $items,
    ) {}

    public static function fromRequest(array $data): self
    {
        if (!isset( $data['order_address_id'])) {
            throw new InvalidArgumentException('Required fields are missing: total, currency, user_id, order_address_id.');
        }

        return new self(
            notes: $data['notes'] ?? null,
            orderAddressId: (int) $data['order_address_id'],
            items: $data['items'] ?? null,
        );
    }
    public function toArray(): array
    {
        return [
            'notes' => $this->notes,
            'orderAddressId' => $this->orderAddressId,
            'items' => $this->items,
            'number'=>time(),
            'user_id'=>auth()->id(),
            'currency'=>'EGP',
        ];
    }
}
