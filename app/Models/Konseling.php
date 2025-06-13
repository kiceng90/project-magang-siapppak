<?php

namespace App\Models;

use App\Enums\StatusKonselingEnum;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Konseling extends Model
{use HasFactory, SoftDeletes, SoftCascadeTrait;
    protected $table = 'konseling';
    protected $softCascade = ['id_klien_konseling','id_jadwal_konseling'];
    protected $attributes = [
        'status' => StatusKonselingEnum::PENDING,
    ];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $appends = [
        'time_remain', 'date_string', 'is_psikolog_booked'
    ];
    
    public function getStatusStringAttribute()
    {
        if (empty($this->jadwalDetail)) {
            return "Start Time Error";
        }

        $start_time = Carbon::parse($this->jadwalDetail->start_time)->format('H:i');
        if (Carbon::now()->gt($this->date . " " . $start_time) && $this->status == StatusKonselingEnum::PENDING) {
            return StatusKonselingEnum::labelStatus(StatusKonselingEnum::EXPIRED);
        }
        return StatusKonselingEnum::labelStatus($this->status);
    }

    public function getKeteranganAttribute()
    {
        if ($this->status == StatusKonselingEnum::REJECTED) {
            return StatusKonselingEnum::labelKeterangan($this->status, $this->note_reject);
        }
        elseif ($this->status == StatusKonselingEnum::FINISHED_WITH_NOTE) {
            return StatusKonselingEnum::labelKeterangan($this->status, $this->psikologrujukan->name);
        }
        else {
            return StatusKonselingEnum::labelKeterangan($this->status);
        }
    }

    public function getIsPsikologBookedAttribute()
    {
        if ($this->id_psikolog_volunteer) {
            return Konseling::where('id_klien_konseling', $this->id_klien_konseling)->whereHas('jadwalDetail.jadwal', function ($query) {
                $query->where('id_psikolog_volunteer', $this->id_psikolog_volunteer);
                $query->where('date', $this->date);
            })->first() != null;
        }

        return false;
    }

    public function getTimeRemainAttribute()
    {
        if (empty($this->jadwalDetail)) {
            return "Start Time Error";
        }
        $start_time = Carbon::parse($this->jadwalDetail->start_time)->format('H:i');
        $dayremain = Carbon::now()->diffInDays($this->date);
        if ($dayremain == 0) {
            $hourremain = Carbon::now()->diffInHours($this->date . " " . $start_time);
            if ($hourremain == 0) {
                return Carbon::now()->diffInMinutes($this->date . " " . $start_time) . " menit";
            }
            return $hourremain . " jam";
        }
        return $dayremain . " hari";
    }

    public function getDateStringAttribute()
    {
        return Carbon::parse($this->date)->translatedFormat('d F Y');
    }

    public function klien()
    {
        return $this->belongsTo(DKlienKonseling::class, 'id_klien_konseling');
    }

    public function psikologrujukan()
    {
        return $this->belongsTo(PsikologVolunteer::class, 'id_psikolog_volunteer', 'id');
    }
    
    public function pengaduan()
    {
        return $this->hasOne(Pengaduan::class,'id','id_pengaduan');
    }

    public function jadwalDetail()
    {
        return $this->belongsTo(MJadwalKonselingDetail::class, 'id_jadwal_konseling_detail');
    }

    public function jadwal()
    {
    return $this->belongsTo(MJadwalKonseling::class, 'id_jadwal_konseling');
    }

    public function kategori()
    {
    return $this->belongsTo(MKategoriKonseling::class, 'id_kategori_konseling');
    }

}
