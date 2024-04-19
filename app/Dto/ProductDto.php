<?php

namespace App\Dto;

class ProductDto {
    public string $name;
    public string $description;
    public int $price;
    public int $stock;
    
    public function __construct(string $name, string $description, int $price, int $stock)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
    }
}