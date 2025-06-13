<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KlienResource extends JsonResource
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
            'klien_history' =>  new KlienHistoryResource($this->whenLoaded('klien_history')),
            'name' => $this->name,
            'initial_name' => $this->initial_name,
            'is_has_nik' => $this->is_has_nik,
            'identity_number' => $this->identity_number,
            'nik_number' => $this->nik_number,
            'phone_number' => $this->phone_number,
            'is_surabaya_resident' => $this->is_surabaya_resident,
            // 'residence_address' => $this->residence_address,
            // 'kabupaten_tinggal' => new KabupatenResource($this->whenLoaded('kabupaten_tinggal')),
            // 'kelurahan_tinggal' => new KelurahanResource($this->whenLoaded('kelurahan_tinggal')),
        ];

        return $result;
    }
}
