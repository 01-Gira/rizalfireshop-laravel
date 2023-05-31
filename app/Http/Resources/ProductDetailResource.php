<?php

namespace App\Http\Resources;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'stock' => $this->stock,
            'price' => $this->price,
            'category' => $this->category->name,
            'image' => $this->image,
            'weight' => $this->weight,
            'sale' => $this->sale,
            'created_at' => date_format($this->created_at, "Y/m/d, H:i:s")
        ];
    }

    
    // public function withResponse($request, $response)
    // {
    //     $apiResponse = new ApiResponse(false, 'success', $response->original);
    //     $response->setContent($apiResponse->toJson()->content());
    // }
}
