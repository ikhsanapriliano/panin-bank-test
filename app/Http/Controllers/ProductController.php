<?php

namespace App\Http\Controllers;

use App\Dto\ProductCriteriaDto;
use App\Dto\ProductDto;
use App\Dto\ResponseDto;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function createProduct(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric'
            ]);
    
            $payload = new ProductDto($request->name, $request->description, $request->price, $request->stock);
    
            $data = $this->productService->createProduct($payload);
            $message = "success";
            $resStatus = 201;
    
            $response = new ResponseDto($message, $data);
    
            return response()->json($response, $resStatus);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function findProductById(string $id): JsonResponse
    {
        try {
            $data = $this->productService->findProductById($id);

            $message = "success";
            $resStatus = 200;

            if ($data === null) {
                $message = "data with id $data not found";
                $resStatus = 404;
            }

            $response = new ResponseDto($message, $data);
            
            return response()->json($response, $resStatus);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function findManyProducts(Request $request): JsonResponse
    {
        try {
            $data = [];
            if (empty($request->query('minPrice')) && empty($request->query('maxPrice'))) {
                $data = $this->productService->findAllProducts();
            } else  {
                $criteria = new ProductCriteriaDto($request->query('minPrice'), $request->query('maxPrice'));
                $data = $this->productService->findProductsByCriteria($criteria);
            }
            $message = "success";
    
            $response = new ResponseDto($message, $data);
            $resStatus = 200;
    
            return response()->json($response, $resStatus);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateProduct(string $id, Request $request): JsonResponse
    {   
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric'
            ]);
    
            $payload = new ProductDto($request->name, $request->description, $request->price, $request->stock);
    
            $data = $this->productService->updateProduct($id, $payload);
    
            $message = "data with id $id successfully updated";
            $resStatus = 200;
    
            if (!$data) {
                $message = "data with id $id not found";
                $resStatus = 404;
            }
    
            $response = new ResponseDto($message, $data);
    
            return response()->json($response, $resStatus);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteProduct(string $id): JsonResponse
    {
        try {
            $data = $this->productService->deleteProduct($id);
        
            $message = "data with id $id successfully deleted";
            $resStatus = 200;
    
            if (!$data) {
                $message = "data with id $id not found";
                $resStatus = 404;
            }

            $response = new ResponseDto($message, $data);
    
            return response()->json($response, $resStatus);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
