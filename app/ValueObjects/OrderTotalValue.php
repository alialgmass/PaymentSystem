<?php

namespace App\ValueObjects;

class OrderTotalValue
{


    private function __construct(private Money $price, private Money $vat, private Money $total)
    {

    }

    public static function create(int $price, string $currency = 'EGP')
    {
        $price = Money::make($price, $currency);
        $vat =$price->multiply(.15);
        $total = $price->add($vat);
        return new self(
            $price,
            $vat,
            $total
        );
    }
    public function getPrice(): Money
    {
        return $this->price;
    }
    public function getVat(): Money
    {
        return $this->vat;
    }
    public function getTotal(): Money{
        return $this->total;
    }
}
