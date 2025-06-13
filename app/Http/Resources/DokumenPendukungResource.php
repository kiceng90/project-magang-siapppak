<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DokumenPendukungResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'foto_klien' => null,
            'foto_tempat_tinggal_klien' => null,
            'foto_pendampingan_awal_klien' => null,
            'foto_pendampingan_lanjutan_klien' => null,
            'foto_pendampingan_monitoring_klien' => null,
            'foto_identitas_klien' => null,
            'surat' => null,
        ];
        $keys = array_keys( $data );
        foreach(($this->dokumenPendukung ?? []) as $file){
            $data[$keys[$file->document_type - 1]][] = new FileResource($file);
        }

        return $data;
    }
}
