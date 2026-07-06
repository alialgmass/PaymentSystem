<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'status' => $this->status,
            'total' => $this->total,
            'currency' => $this->currency,
            'notes' => $this->notes,
            'item_count' => $this->items->count(),
            'paid_amount' => $this->payments
                ->where('status', 'paid')
                ->sum('amount'),
            'remaining_amount' => $this->total - $this->payments
                ->where('status', 'paid')
                ->sum('amount'),
            'user' => new OrderUserResource($this->whenLoaded('user')),
            'address' => new OrderAddressResource($this->whenLoaded('address')),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'payments' => OrderPaymentResource::collection($this->whenLoaded('payments')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
