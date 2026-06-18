<?php

namespace App\Contracts\Repositories;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function findOrFail(int $id): Product;

    public function findPrice(int $id): float;
}
