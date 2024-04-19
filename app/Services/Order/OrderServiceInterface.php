<?php

namespace App\Services\Order;

use App\Dto\OrderDto;
use App\Models\Order;

interface OrderServiceInterface {
    public function createOrder(OrderDto $payload): ?Order;
    public function findOrderById(string $id): ?Order;
    public function findAllOrders(): array;
}