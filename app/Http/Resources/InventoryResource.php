<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'user'=> $this->user->name ?? '',
            'item'=> [
                'name'=>$this->item->name,
                'image'=>"images/item/".$this->item->image,
                'quantity'=>$this->item->quantity,
                'description'=>$this->item->description,
            ] ?? '',
        ];
    }
}
