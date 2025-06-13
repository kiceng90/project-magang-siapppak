<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnalisKebutuhanKlienResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $parent = parent::toArray($request);
        $data = [
            'pelayanan' => $this->pelayanan->name ?? null,
            'dokumen' => FileResource::collection($this->files),
        ];
        return $parent + $data;
    }
}
