<?php

namespace App\Services\Product;

use App\Dto\ProductCriteriaDto;
use App\Dto\ProductDto;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;

class ProductService implements ProductServiceInterface {
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(ProductDto $payload): Product 
    {
        $data = $this->productRepository->create($payload);
        return $data;
    }
    
    public function findProductById(string $id): ?Product 
    {
        $data = $this->productRepository->findById($id);

        return $data;
    }

    public function findAllProducts(): array
    {
        $data = $this->productRepository->findAll();
        
        return $data;
    }

    public function findProductsByCriteria(ProductCriteriaDto $criteria): array 
    {
        $data = $this->productRepository->findByCriteria($criteria);

        return $data;
    }

    public function updateProduct(string $id, ProductDto $payload): bool 
    {
        $product = $this->productRepository->findById($id);
        if ($product == null) {
            return false;
        }

        $this->productRepository->update($product, $payload);
        return true;
    }

    public function deleteProduct(string $id): bool 
    {
        $product = $this->productRepository->findById($id);
        if ($product == null) {
            return false;
        }

        $this->productRepository->delete($product);
        return true;
    }
}