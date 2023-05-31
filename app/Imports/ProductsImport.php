<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingsRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name' => $row['Name'],
            'slug' => $row['Slug'],
            'description' => $row['Description'],
            'stock' => $row['Stock'],
            'price' => $row['Price'],
            'category_id' => $row['Category ID'],
            'weight' => $row['Weight'],
        ]);
    }
}
