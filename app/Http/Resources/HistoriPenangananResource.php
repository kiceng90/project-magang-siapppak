<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoriPenangananResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $type = get_class($this->resource) == 'App\Models\RencanaIntervensi' ? 3 : $this->service_type;
        $data = [
            'id' => $this->id,
            'type' => $type,
        ];

        if($type == 3){
            $data += [
                'status' => $this->realisasi_draft_status,
                'tanggal_pelayanan' => date('Y-m-d H:i:s', strtotime($this->updated_at)),
                'id_kebutuhan' => $this->id_kebutuhan,
                'nama_kebutuhan' => $this->kebutuhan->name ?? null,
                'id_opd' => $this->id_opd,
                'nama_opd' => $this->opd->name ?? null,
                'id_pelayanan' => $this->id_intervensi ?? null,
                'nama_pelayanan' => $this->intervensi->name ?? null,
                'deskripsi' => $this->description,
                'files' => FileResource::collection($this->rencana_intervensi_file),
                'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
                'created_by' => $this->createdBy->konselor->name ?? ($this->createdBy->name ?? null),
            ];
        }else{
            $data += [
                'tanggal_pelayanan' => date('Y-m-d H:i:s', strtotime($this->service_date)),
                'id_pelayanan' => $this->id_pelayanan,
                'nama_pelayanan' => $this->pelayanan->name ?? null,
                'shelter_type' => $this->shelter_type,
                'deskripsi' => $this->description,
                'files' => FileResource::collection($this->files),
                'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
                'created_by' => $this->createdBy->konselor->name ?? ($this->createdBy->name ?? null),
            ];
        }

        return $data;
    }
}
