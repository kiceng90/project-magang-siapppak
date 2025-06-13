<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use App\Http\Controllers\Controller;
use App\Helpers\HelperPublic;

use App\Notifications\PengaduanNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class Pengaduan extends Model
{
    use HasFactory, Userstamps, SoftDeletes, SoftCascadeTrait;
    protected $table = 'pengaduan';
    protected $softCascade = [];
    protected $guarded = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public static function boot(){
        parent::boot();
        self::updated(function($model){
            $data = [
                'title' => 'Perlu Verifikasi Anda',
                'description' => 'Pengaduan '. $model->registration_number .' membutuhkan verifikasi anda',
                'type' => 0,
                'to' => 'pengaduan',
                'id_pengaduan' => $model->id,
            ];
            $usersNotif = null;

            if($model->getOriginal('id_status') == 1 && $model->id_status == 3){
                $usersNotif = User::where('id_role', config('env.role.subkord'))->get();
            }

            if($model->getOriginal('id_status') == 3 && $model->id_status == 4){
                $usersNotif = User::where('id_role', config('env.role.kabid'))->get();
            }

            if($model->getOriginal('id_status') == 4 && $model->id_status == 5){
                $usersNotif = User::where('id_role', config('env.role.konselor'))->get();
            }

            if((in_array($model->getOriginal('id_status'), [5,6])) && $model->id_status == 7){
                $usersNotif = User::where('id_role', config('env.role.subkord'))->get();
            }

            if($model->getOriginal('id_status') == 7 && $model->id_status == 6){
                $usersNotif = User::where('id_role', config('env.role.konselor'))->get();
            }

            if($model->getOriginal('id_status') == 7 && $model->id_status == 8){
                $usersNotif = User::where('id_role', config('env.role.kabid'))->get();

                Notification::send(User::where('id_role', config('env.role.konselor'))->get(), new PengaduanNotification([
                    'title' => 'Telah Diverifikasi Subkord',
                    'description' => 'Pengaduan '. $model->registration_number .' telah di verifiasi Subkord',
                    'type' => 1,
                    'to' => 'pengaduan',
                    'id_pengaduan' => $model->id,
                ]));
            }

            if($model->getOriginal('id_status') == 8 && $model->id_status == 9){
                $usersNotif = User::where('id_role', config('env.role.kadis'))->get();

                Notification::send(User::where('id_role', config('env.role.konselor'))->get(), new PengaduanNotification([
                    'title' => 'Telah Diverifikasi Kabid',
                    'description' => 'Pengaduan '. $model->registration_number .' telah di verifiasi Kabid',
                    'type' => 1,
                    'to' => 'pengaduan',
                    'id_pengaduan' => $model->id,
                ]));

                if($rencana = ($model->penjangkauan->rencanaIntervensi ?? null)){
                    $id_opd = array_map(function($item){
                        return $item['id_opd'];
                    }, $rencana->toArray());
                    Notification::send(
                        User::where('id_role', config('env.role.opd'))
                        ->whereIn('id_opd', $id_opd)
                        ->get(), new PengaduanNotification([
                        'title' => 'Perlu Intervensi anda',
                        'description' => 'Pengaduan '. $model->registration_number .' membutuhkan intervensi anda',
                        'type' => 0,
                        'to' => 'pengaduan',
                        'id_pengaduan' => $model->id,
                    ]));
                }
            }

            if($model->getOriginal('id_status') == 9 && $model->id_status == 10){
                $usersNotif = User::whereIn('id_role', [config('env.role.konselor'), config('env.role.admin')])->get();
                $data = [
                    'title' => 'Pengaduan Selesai',
                    'description' => 'Hasil penjangkauan '. $model->registration_number .' telah di setujui Kadis',
                    'type' => 1,
                    'to' => 'pengaduan',
                    'id_pengaduan' => $model->id,
                ];
            }


            if($usersNotif && count($usersNotif)){
                Notification::send($usersNotif, new PengaduanNotification($data));
            }
            
        });
    }

    public function getStatusAttribute($value)
    {
        return Controller::getStatusPengaduan($value, $this);
    }

    public function getRegistrationNumberAttribute($val)
    {
        $pengaduan = self::find($this->id);
        $val = str_pad($val, 4, '0', STR_PAD_LEFT);
        $number = '37/'.$val.'/';
        $number .= ( $pengaduan->penjangkauan ? $pengaduan->penjangkauan->jenis_kasus ? strtoupper(str_replace(' ', '', $pengaduan->penjangkauan->jenis_kasus->kategoriKasus->name)) ?? '0' : '0': '0') . '/';
        $number .= HelperPublic::$bulanRomawi[date('n', strtotime($pengaduan->complaint_date))] .'/'. date('Y', strtotime($pengaduan->complaint_date));
        return $number;
    }

    public static function RegistrationNumber($val)
    {
        $val = str_pad($val, 4, '0', STR_PAD_LEFT);
        return '37/'.$val.'/KATEGORI/BULAN/TAHUN';
    }

    public function sumberKeluhan()
    {
        return $this->belongsTo(MSumberKeluhan::class, 'id_sumber_keluhan', 'id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(MKabupaten::class, 'complainant_id_kabupaten', 'id');
    }

    public function klien()
    {
        return $this->belongsTo(DaftarKlien::class, 'id_klien', 'id');
    }

    public function files()
    {
        return $this->hasMany(PengaduanFile::class, 'id_pengaduan', 'id');
    }

    public function penangananAwal()
    {
        return $this->hasOne(PenangananAwal::class, 'id_pengaduan', 'id');
    }

    public function penjangkauan()
    {
        return $this->hasOne(Penjangkauan::class, 'id_pengaduan', 'id');
    }
}
