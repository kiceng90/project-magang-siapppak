<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class KlienHistoryResource extends JsonResource
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
            'id_daftar_klien' => $this->id_daftar_klien,
            'residence_address' => $this->residence_address,
            'kabupaten_tinggal' => new KabupatenResource($this->whenLoaded('kabupaten_tinggal')),
            'kelurahan_tinggal' => new KelurahanResource($this->whenLoaded('kelurahan_tinggal')),
            'kk_number' => $this->kk_number,
            'kk_address' => $this->kk_address,
            'kelurahan_kk' => new KelurahanResource($this->whenLoaded('kelurahan_kk')),
            'kabupaten_lahir' => new KabupatenResource($this->whenLoaded('kabupaten_lahir')),
            'birth_date' => (!empty($this->birth_date)) ? Carbon::parse($this->birth_date)->format('d-m-Y') : null,
            'age_category' => $this->age_category,
            'physical_category' => $this->physical_category,
            'bpjs_category' => $this->bpjs_category,
            'gender' => $this->gender,
            'agama' => new AgamaResource($this->whenLoaded('agama')),
            'pekerjaan' => new PekerjaanResource($this->whenLoaded('pekerjaan')),
            'monthly_income' => $this->monthly_income,
            'status_pernikahan' => new StatusPernikahanResource($this->whenLoaded('status_pernikahan')),
            'pendidikan_terakhir' => new PendidikanTerakhirResource($this->whenLoaded('pendidikan_terakhir')),
            'jurusan' => new JurusanResource($this->whenLoaded('jurusan')),
            'highest_class' => $this->highest_class,
            'graduation_year' => $this->graduation_year,
            'nama_sekolah' => $this->school_name,
        ];

        return $result;
    }
}
