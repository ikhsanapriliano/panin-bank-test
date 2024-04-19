<?php

namespace App\Services\Product;

use App\Dto\ProductCriteriaDto;
use App\Dto\ProductDto;
use App\Models\Product;

interface ProductServiceInterface 
{
    public function createProduct(ProductDto $payload): Product;
    public function findProductById(string $id): ?Product;
    public function findAllProducts(): array;
    public function findProductsByCriteria(ProductCriteriaDto $criteria): array;
    public function updateProduct(string $id, ProductDto $payload): bool;
    public function deleteProduct(string $id): bool;
}