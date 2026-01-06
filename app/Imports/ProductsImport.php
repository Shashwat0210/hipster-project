<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    WithChunkReading,
    ShouldQueue
{
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'description' => $row['description'] ?? null,
            'price' => (int) $row['price'],
            'category' => $row['category'],
            'stock' => (int) $row['stock'],
            'image' => $row['image'] ?? 'products/default.png',
        ]);
    }

    public function rules(): array
    {
        return[
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['required', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}

