<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select('name', 'slug', 'description', 'stock', 'price', 'category_id', 'weight')->get();
    }

    public function headings(): array
    {
        return ['Name', 'Slug', 'Description', 'Stock', 'Price', 'Category ID', 'Weight'];
    }
}
