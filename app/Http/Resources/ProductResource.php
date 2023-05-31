<?php

namespace App\Http\Resources;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
// use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResource extends ResourceCollection    
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
        
    public function with($request)
    {
        return [
            'error' => false,
            'message' => 'success'
        ];
    }


    public function toArray($request)
    {
        return [
            // 'data' => $this->collection,
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'description' => $data->description,
                    'stock' => $data->stock,
                    'price' => $data->price,
                    'category' => $data->category->name,
                    'image' => $data->image,
                    'weight' => $data->weight,
                    'sale' => $data->sale,
                    'created_at' => date_format($data->created_at, "Y/m/d, H:i:s")
                ];
            }),
        ];
    }



    
    // public function withResponse($request, $response)
    // {
    //     $apiResponse = new ApiResponse(false, 'success', $response->original);
    //     $response->setContent($apiResponse->toJson()->content());
    // }
}
