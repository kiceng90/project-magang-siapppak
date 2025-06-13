<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PelaporExportResource extends JsonResource
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
            'id' => $this->id,
            'no_registrasi' => $this->registration_number,
            'nama' => $this->complainant_name,
            'nik' => $this->complainant_nik,
            'warga_surabaya' => $this->complainant_is_surabaya_resident	? 'IYA' : 'TIDAK',
            'no_telepon' => $this->complainant_phone_number,
            'alamat_domisili' => $this->complainant_residence_address,
            'sumber_pengaduan' => $this->sumberKeluhan->name ?? '',
            'tgl_dan_jam_pengaduan' => $this->complaint_date ? $this->formatDate($this->complaint_date) : '',
            'uraian' => $this->problem_description,
            'tgl_dan_jam_penanganan' => ($this->penangananAwal->date ?? null) ? $this->formatDate($this->penangananAwal->date) : '',
            'hasil_penanganan' => $this->penangananAwal->result ?? '',
        ];
        return $data;
    }
    
    public function formatDate($date, $time = true)
    {
        $format = $time ? 'd F Y, H:i' : 'd F Y';
        // return request()->is_download ? Date::dateTimeToExcel(Carbon::parse($date)) : Carbon::parse($this->complaint_date)->translatedFormat($format);
        return Carbon::parse($this->complaint_date)->translatedFormat($format);
    }
}
