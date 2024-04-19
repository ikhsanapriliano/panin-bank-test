<?php

namespace App\Repositories\Order;

use App\Dto\OrderDto;
use App\Models\Order;
use Ramsey\Uuid\Rfc4122\UuidV4;

class OrderRepository implements OrderRepositoryInterface {
    private Order $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }

    public function create(OrderDto $payload): Order 
    {
        $data = $this->order->create([
            'id' => UuidV4::uuid4()->toString(),
            'order_date' => $payload->orderDate,
            'product_id' => $payload->productId,
            'user_id' => $payload->userId,
            'quantity' => $payload->quantity,
            'total_price' => $payload->totalPrice
        ]);

        return $data;
    }

    public function findById(string $id): ?Order 
    {
        $data = $this->order->find($id);
        return $data;
    }

    public function findAll(): array 
    {
        $data = $this->order->paginate(3)->toArray();
        return $data;
    }
}