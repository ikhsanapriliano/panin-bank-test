<?php

namespace App\Repositories\Order;

use App\Dto\OrderDto;
use App\Models\Order;

interface OrderRepositoryInterface {
    public function create(OrderDto $payload): Order;
    public function findById(string $id): ?Order;
    public function findAll(): array;
}