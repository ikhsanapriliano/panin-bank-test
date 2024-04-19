<?php

namespace App\Services\Order;

use App\Dto\OrderDto;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\DB;

class OrderService {
    private OrderRepository $orderRepository;
    private ProductService $productService;

    public function __construct(OrderRepository $orderRepository, ProductService $productService) {
        $this->orderRepository = $orderRepository;
        $this->productService = $productService;
    }

    public function createOrder(OrderDto $payload): ?Order 
    {
        $product = $this->productService->findProductById($payload->productId);
        if ($product === null) {
            return null;
        }

        if ($product->stock < $payload->quantity) {
            return "invalid quantity";
        }

        $payload->totalPrice = $product->price * $payload->quantity;

        DB::beginTransaction();
        $data = $this->orderRepository->create($payload);
        $product->update([
            'stock' => $product->stock - $payload->quantity
        ]);
        DB::commit();

        return $data;
    }

    public function findOrderById(string $id): ?Order
    {
        $data = $this->orderRepository->findById($id);
        return $data;
    }

    public function findAllOrders(): array
    {
        $data = $this->orderRepository->findAll();
        return $data;
    }
}