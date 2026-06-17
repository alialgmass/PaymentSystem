<?php

namespace App\Actions\Orders;

use App\Models\Product;
use App\ValueObjects\OrderTotalValue;

class CalculatePrice
{
    public function calculate(array $items): OrderTotalValue
    {
        $price = 0;
        foreach ($items as $item) {
            $price += $this->getProductPrice($item['id']) * $item['quantity'];
        }
        return OrderTotalValue::create($price);
    }

    private function getProductPrice($id):float
    {
        return Product::query()->findOrFail($id)->price;
    }
}
