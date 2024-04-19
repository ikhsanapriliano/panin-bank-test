<?php

namespace App\Http\Controllers;

use App\Dto\OrderDto;
use App\Dto\ResponseDto;
use App\Models\Order;
use App\Services\Order\OrderService;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function createOrder(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'productId' => 'required',
                'quantity' => 'required|numeric|min:1',
            ]);
    
            $payload = new OrderDto($request->productId, $request->userId, $request->quantity);
    
            $data = $this->orderService->createOrder($payload);
            $message = "success";
            $resStatus = 201;
    
            if ($data === null) {
                $message = "product with id $payload->productId not found";
                $resStatus = 404;
            }

            $response = new ResponseDto($message, $data);
    
            return response()->json($response, $resStatus);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function findOrderById(Request $request, string $id): JsonResponse
    {
        try {  
            $data = $this->orderService->findOrderById($id);
            $message = "success";
            $resStatus = 201;

            $userId = $request->userId;
            if ($userId != $data->user_id) {
                $message = "forbidden resource";
                $response = new ResponseDto($message, null);

                return response()->json($response, 403);
            }

            if ($data === null) {
                $message = "product with id $id not found";
                $resStatus = 404;
            }

            if ($data === "invalid quantity") {
                $message = "quantity exceeds available product stock";
                $resStatus = 400;
            }
    
            $response = new ResponseDto($message, $data);
    
            return response()->json($response, $resStatus);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function findAllOrders(): JsonResponse
    {
        try { 
            $data = $this->orderService->findAllOrders();
            $message = "success";
            $resStatus = 201;
    
            $response = new ResponseDto($message, $data);
    
            return response()->json($response, $resStatus);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
