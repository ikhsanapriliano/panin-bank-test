<?php

namespace App\Repositories\Product;

use App\Dto\ProductCriteriaDto;
use App\Dto\ProductDto;
use App\Models\Product;

interface ProductRepositoryInterface 
{
    public function create(ProductDto $payload): Product;
    public function findById(string $id): ?Product;
    public function findAll(): array;
    public function findByCriteria(ProductCriteriaDto $criteria): array;
    public function update(Product $product, ProductDto $payload): bool;
    public function delete(product $product): bool;
}