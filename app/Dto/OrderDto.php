<?php

namespace App\Dto;

use DateTime;

class OrderDto {
    public string $orderDate;
    public string $productId;
    public string $userId;
    public int $quantity;
    public int $totalPrice;

    public function __construct(string $productId, string $userId, int $quantity)
    {
        $date = new DateTime();
        $this->orderDate = $date->format('Y-m-d H:i:s');
        $this->productId = $productId;
        $this->userId = $userId;
        $this->quantity = $quantity;
    }
}