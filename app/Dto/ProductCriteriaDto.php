<?php

namespace App\Dto;

class ProductCriteriaDto {
    public ?int $minPrice;
    public ?int $minStock;

    public function __construct(?int $price, ?int $stock)
    {
        $this->minPrice = $price;
        $this->minStock = $stock;
    }
}