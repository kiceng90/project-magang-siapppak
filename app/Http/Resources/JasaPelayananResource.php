<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JasaPelayananResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active,
        ];

        return $result;
    }
}