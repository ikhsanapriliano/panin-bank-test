<?php

namespace App\Repositories\Product;

use App\Dto\ProductCriteriaDto;
use App\Dto\ProductDto;
use App\Models\Product;
use Ramsey\Uuid\Rfc4122\UuidV4;

class ProductRepository implements ProductRepositoryInterface 
{
    private Product $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function create(ProductDto $payload): Product 
    {
        $data = $this->product->create([
            'id' => UuidV4::uuid4()->toString(),
            'name' => $payload->name,
            'description' => $payload->description,
            'price' => $payload->price,
            'stock' => $payload->stock
        ]);

        return $data;
    }

    public function findById(string $id): ?Product 
    {
        $data = $this->product->find($id);
        return $data;
    }

    public function findAll(): array 
    {
        $data = $this->product->paginate(3)->toArray();
        return $data;
    }

    public function findByCriteria(ProductCriteriaDto $criteria): array 
    {
        $query = $this->product->query();

        if (!empty($criteria->minPrice) && !empty($criteria->minStock)) 
        {
            $query->where([
                ['price', '>=', $criteria->minPrice],
                ['stock', '>=', $criteria->minStock]
            ]);
        } else 
        {
            if (!empty($criteria->minPrice))
            {
                $query->where([
                    ['price', '>=', $criteria->minPrice]
                ]);
            }

            if (!empty($criteria->minStock))
            {
                $query->where([
                    ['stock', '>=', $criteria->minStock]
                ]);
            }
        }

        $data = $query->paginate(3)->items();
        return $data;
    }

    public function update(Product $product, ProductDto $payload): bool 
    {
        $data = $product->update([
            'name' => $payload->name,
            'description' => $payload->description,
            'price' => $payload->price,
            'stock' => $payload->stock,
            'updated_at' => time()
        ]);

        return $data;
    }

    public function delete(Product $product): bool 
    {   
        $data = $product->delete();
        return $data;
    }
}