<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class RealisasiIntervensiResource extends JsonResource
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
            'id_rencana_intervensi' => $this->id_rencana_intervensi,
            'file' => FileResource::collection($this->whenLoaded('realisasi_intervensi_file')),
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => new UserResource($this->whenLoaded('createdBy')),
            'created_at' => (!empty($this->created_at)) ? Carbon::parse($this->created_at)->format('d-m-Y H:i') : null,
        ];

        return $result;
    }
}
