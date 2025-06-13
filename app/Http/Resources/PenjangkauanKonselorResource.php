<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PenjangkauanKonselorResource extends JsonResource
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
            'id_penjangkauan' => $this->id_penjangkauan,
            'id_konselor' => $this->id_konselor,
            'konselor' => new KonselorResource($this->whenLoaded('konselor')),
        ];

        return $result;
    }
}
