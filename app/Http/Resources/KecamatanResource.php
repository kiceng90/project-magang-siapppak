<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KecamatanResource extends JsonResource
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
            'kabupaten' => new KabupatenResource($this->whenLoaded('kabupaten')),
            'wilayah' => new WilayahResource($this->whenLoaded('wilayah')),
        ];

        return $result;
    }
}
