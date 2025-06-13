<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RencanaIntervensiResource extends JsonResource
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
            'kebutuhan' => new KebutuhanResource($this->whenLoaded('kebutuhan')),
            'opd' => new OpdResource($this->whenLoaded('opd')),
            'intervensi' => new KebutuhanResource($this->whenLoaded('intervensi')),
            // 'file' => FileResource::collection($this->whenLoaded('rencana_intervensi_file')),
            // 'description' => $this->description,
            'realisasi_draft_status' => $this->realisasi_draft_status,
            'realisasi_intervensi' => RealisasiIntervensiResource::collection($this->whenLoaded('realisasiIntervensi'))
        ];

        return $result;
    }
}
