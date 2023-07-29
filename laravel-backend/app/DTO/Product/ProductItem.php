<?php

declare(strict_types=1);

namespace App\DTO\Product;

class ProductItem
{
    public string $id;

    public string $serial = '';

    public string $name = '';

    public float $price = 0.0;

    public int $unitsInStock = 0;

    public string $category = '-';
}
