<?php

namespace App\ValueObjects;

readonly class Money
{
    public function __construct(
        private int $amount,
        private string $currency
    ) {}
    public static function make(int $amount, string $currency): Money{
        return new self($amount, $currency);
    }

    public function add(self $money): self
    {
        return new self(
            $this->amount + $money->amount,
            $this->currency
        );
    }

    public function multiply(float $factor): self
    {
        return new self(
            (int) round($this->amount * $factor),
            $this->currency
        );
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}
