<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class KeluargaKlienResource extends JsonResource
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
            'hubungan' => new HubunganResource($this->whenLoaded('hubungan')),
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'nik_number' => $this->nik_number,
            'residence_address' => $this->residence_address,
            'kelurahan_tinggal' => new KelurahanResource($this->whenLoaded('kelurahan_tinggal')),
            'kk_number' => $this->kk_number,
            'kk_address' => $this->kk_address,
            'kelurahan_kk' => new KelurahanResource($this->whenLoaded('kelurahan_kk')),
            'kabupaten_lahir' => new KabupatenResource($this->whenLoaded('kabupaten_lahir')),
            'birth_date' => (!empty($this->birth_date)) ? Carbon::parse($this->birth_date)->format('d-m-Y') : null,
            'bpjs_category' => $this->bpjs_category,
            'gender' => $this->gender,
            'status_pernikahan' => new StatusPernikahanResource($this->whenLoaded('status_pernikahan')),
            'agama' => new AgamaResource($this->whenLoaded('agama')),
            'pekerjaan' => new PekerjaanResource($this->whenLoaded('pekerjaan')),
            'monthly_income' => $this->monthly_income,
            'work_type' => $this->work_type,
            'pendidikan_terakhir' => new PendidikanTerakhirResource($this->whenLoaded('pendidikan_terakhir')),
            'jurusan' => new JurusanResource($this->whenLoaded('jurusan')),
            'pendidikan_terakhir' => new PendidikanTerakhirResource($this->whenLoaded('pendidikan_terakhir')),
            'kelas' => $this->highest_class,
            'tahun_lulus' => $this->graduation_year,
            'nama_sekolah' => $this->school_name,
        ];

        return $result;
    }
}
