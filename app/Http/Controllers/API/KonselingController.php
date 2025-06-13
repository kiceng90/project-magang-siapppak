<?php

namespace App\Http\Controllers\API;

use App\Enums\ClientTypeEnum;
use App\Enums\JenisKonsultanEnum;
use App\Enums\LangEnum;
use App\Enums\StatusKonselingEnum;
use App\Exports\DatabaseExport;
use App\Helpers\HelperPublic;
use App\Helpers\WhatsappHelper;
use App\Helpers\WhatsappTwilioHelper;
use App\Http\Controllers\Controller;
use App\Models\DaftarKlien;
use App\Models\DKlienKonseling;
use App\Models\DKonselor;
use App\Models\Konseling;
use App\Models\MJadwalKonseling;
use App\Models\MJadwalKonselingDetail;
use App\Models\MKonselor;
use App\Models\MSumberKeluhan;
use App\Models\Pengaduan;
use App\Models\PengaduanFile;
use App\Models\PsikologVolunteer;
use App\Models\TimelinePengaduan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use stdClass;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class KonselingController extends Controller
{
    public function prepareBookingShift($id_konsultan, $date, Request $request){
        try {
            $daynumber = Carbon::parse($date)->dayOfWeek;

            $konsultan = null;

            if ($request->consultant_type == JenisKonsultanEnum::PSIKOLOG) {
                $id_psikolog_volunteer = intval($id_konsultan);
                $psikologvolunteer = PsikologVolunteer::find($id_psikolog_volunteer);
                if (!$psikologvolunteer) {
                    $this->responseCode = 404;
                    $this->responseMessage = 'Data tidak di temukan';
                    return response()->json($this->getResponse(), $this->responseCode);
                }

                $jadwal = MJadwalKonseling::where('day', $daynumber)->where('id_psikolog_volunteer', $psikologvolunteer->id)->first();
                $konsultan = $psikologvolunteer;
            }
            else {
                $id_konselor = intval($id_konsultan);
                $konselor = MKonselor::find($id_konselor);
                if (!$konselor) {
                    $this->responseCode = 404;
                    $this->responseMessage = 'Data tidak di temukan';
                    return response()->json($this->getResponse(), $this->responseCode);
                }

                $jadwal = MJadwalKonseling::where('day', $daynumber)->where('id_konselor', $konselor->id)->first();
                $konsultan = $konselor;
            }

            $result = [];
            if ($jadwal) {
                if($jadwal->jadwalDetail->count() > 0){
                    foreach ($jadwal->jadwalDetail as $shift_key => $shift) {
                        $konseling = Konseling::where('id_jadwal_konseling_detail', $shift->id)->where('date', '=', $date)->first();
                        if (!$konseling) {
                            $is_available = true;
                            if ($date == date('Y-m-d') && Carbon::parse($shift->start_time)->lt(Carbon::now())) {
                                $is_available = false;
                            }

                            if ($is_available) {
                                $result[$shift_key]['id_jadwal_konseling_detail'] = $shift->id;

                                $result[$shift_key]['time'] = $shift->start_time . "-" . $shift->end_time;
                                $result[$shift_key]['start_time'] = $shift->start_time;
                                $result[$shift_key]['kategori'] = $shift->kategori->name;
                                $result[$shift_key]['end_time'] = $shift->end_time;

                                $result[$shift_key]['is_active'] = $shift->is_active;
                            }
                        }
                    }
                }
            }
            
            $data = new stdClass();
            $data->konsultan = $konsultan;
            $data->jadwal_detail = $result;
            $this->responseCode = 201;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function prepareBookingDay($id_konsultan, Request $request){
        try {
            $konsultan = null;
            if ($request->consultant_type == JenisKonsultanEnum::PSIKOLOG) {
                $id_psikolog_volunteer = intval($id_konsultan);
                $psikologvolunteer = PsikologVolunteer::find($id_psikolog_volunteer);
                if (!$psikologvolunteer) {
                    $this->responseCode = 404;
                    $this->responseMessage = 'Data tidak di temukan';
                    return response()->json($this->getResponse(), $this->responseCode);
                }
                
                $jadwalkonselings = $psikologvolunteer->jadwalActive()->pluck("day")->toArray();
                $konsultan = $psikologvolunteer;
            }
            else {
                $id_konselor = intval($id_konsultan);
                $konselor = MKonselor::find($id_konselor);
                if (!$konselor) {
                    $this->responseCode = 404;
                    $this->responseMessage = 'Data tidak di temukan';
                    return response()->json($this->getResponse(), $this->responseCode);
                }

                $jadwalkonselings = $konselor->jadwalActive()->pluck("day")->toArray();
                $konsultan = $konselor;
            }
            
            $date_today = date('Y-m-d', strtotime("-1 days"));

            for ($day=1; $day<=7; $day++) {
                $date_nextday = strtotime("+1 day", strtotime($date_today));
                $date_today = date('Y-m-d', $date_nextday);
                $date_number = date('N', $date_nextday);

                if (in_array($date_number, $jadwalkonselings)) {
                    if($request->consultant_type == JenisKonsultanEnum::PSIKOLOG){
                        $jadwalkonseling = MJadwalKonseling::where('id_psikolog_volunteer', $konsultan->id)->first();
                    }
                    else{
                        $jadwalkonseling = MJadwalKonseling::where('id_konselor', $konsultan->id)->first();
                    }

                    if ($jadwalkonseling && $date_today != date('Y-m-d')) {
                        $jadwal[$day] = $jadwalkonseling;
                        
                        $result[$day]['konselor'] = $jadwal[$day]->is_active;

                        $result[$day]['is_active'] = $jadwal[$day]->is_active;
        
                        $result[$day]['daynumber'] = $date_number;
        
                        $result[$day]['dayname'] = Carbon::parse(date('d M Y', $date_nextday))->translatedFormat('d F Y') . "<br>" .  Carbon::parse(date('d M Y', $date_nextday))->translatedFormat('(l)');
        
                        $result[$day]['date'] = $date_today;
                    }
                }
            }
            // End of Jadwal
            $data = new stdClass();
            $data->konsultan = $konsultan;
            $data->jadwal_hari = $result;
            $this->responseCode = 201;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function booking(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'date' => 'required|string|date_format:Y-m-d',
                'id_jadwal_konseling_detail' => 'required|exists:App\Models\MJadwalKonselingDetail,id,deleted_at,NULL',
                'language' => Rule::in(LangEnum::getValues()),
                'description' => 'required|string',
            ];
            
            $jadwal_konseling_detail = MJadwalKonselingDetail::find($request->id_jadwal_konseling_detail);
            if ($jadwal_konseling_detail->jadwal->id_psikolog_volunteer) {
                $klien_konseling = DKlienKonseling::find($request->id_klien_konseling);
                $status = StatusKonselingEnum::ACCEPTED;
            }
            else {
                $klien_konseling = DKlienKonseling::where('id_user', Auth::id())->first();
                $status = StatusKonselingEnum::PENDING;
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $konseling = Konseling::create([
                'date' => $request->date,
                'id_jadwal_konseling_detail' => $request->id_jadwal_konseling_detail,
                'id_klien_konseling' => $klien_konseling->id,
                'language' => $request->language,
                'description' => $request->description,
                'status' => $status
            ]);

            $konseling->load('jadwalDetail.jadwal.konselor', 'klien');

            $phonenumber = [];
            if ($konseling->jadwalDetail->jadwal->id_psikolog_volunteer) {
                $phonenumber[] = $konseling->jadwalDetail->jadwal->psikolog->no_hp;
            }
            else {
                $phonenumber[] = HelperPublic::normalizePhoneNumber($konseling->jadwalDetail->jadwal->konselor->phone_number);
            }
            
            $message = "Ada permohonan konsultasi online yang ditujukan kepada anda, dengan rincian sebagai berikut:
            
                        Nama: " . $konseling->klien->name . "
                        No. Telpon: " . $konseling->klien->phone . "
                        Tanggal: " . Carbon::parse($konseling->date)->translatedFormat('d F Y') . "

                        Harap untuk segera memberi konfirmasi terhadap permohonan ini dengan login sebagai Konselor di SIAP PPAK Kota Surabaya.

                        Dikirim secara otomatis oleh sistem SIAP PPAK Kota Surabaya.";

            $konseling->whatsappresult = WhatsappTwilioHelper::send($phonenumber, $message);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $konseling;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getLanguages(){
        try {
            $data = LangEnum::toObject();
            $this->responseCode = 201;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getHistory(Request $request){
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $data = Konseling::query()->with('klien.kabupaten', 'jadwalDetail.jadwal.konselor', 'jadwalDetail.jadwal.psikolog', 'pengaduan', 'klien.kelurahan.kecamatan');
            if ($request->filled('status')) {
                $data->where('status', $request->status);
            }
            
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $data->whereHas('klien', function ($query) use ($searchTerm) {
                    $query->where('name', 'ilike', '%' . $searchTerm . '%');
                    $query->orWhere('email', 'ilike', '%' . $searchTerm . '%');
                });
                $data->orWhereHas('klien.kelurahan', function ($query) use ($searchTerm) {
                    $query->where('name', 'ilike', '%' . $searchTerm . '%');
                });
                $data->orWhereHas('klien.kelurahan.kecamatan', function ($query) use ($searchTerm) {
                    $query->where('name', 'ilike', '%' . $searchTerm . '%');
                });
                $data->orWhereHas('jadwalDetail.jadwal.konselor', function ($query) use ($searchTerm) {
                    $query->where('name', 'ilike', '%' . $searchTerm . '%');
                });
            }
            
            $data = $data->orderBy($sortby, $order)->paginate($limit);
            $data->append('keterangan');
            $data->append('status_string');
            $this->responseCode = 201;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getHistoryByKlienID(Request $request){
        try {
            $id_klien_konseling = DKlienKonseling::where('id_user', auth()->user()->id)->first()->id;
            $klien = DKlienKonseling::where('id', $id_klien_konseling)->first();
            if(!$klien){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';

            $data = Konseling::with('klien.kabupaten', 'jadwalDetail.jadwal.konselor', 'jadwalDetail.jadwal.psikolog', 'pengaduan', 'klien.kelurahan.kecamatan')->where('id_klien_konseling',$id_klien_konseling);
            if ($request->filled('status')) {
                $data->where('status', $request->status);
            }
            $data = $data->orderBy($sortby, $order)->paginate($limit);
            $data->append('keterangan');
            $data->append('status_string');
            $this->responseCode = 201;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getHistoryByKonselorID(Request $request){
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? $request->sortby : 'id';
            
            if ($request->consultant_type == JenisKonsultanEnum::PSIKOLOG) {
                $id_psikolog_volunteer = auth()->user()->id_psikolog_volunteer;
                $psikologvolunteer = PsikologVolunteer::find($id_psikolog_volunteer);
                if (!$psikologvolunteer) {
                    $this->responseCode = 404;
                    $this->responseMessage = 'Data tidak di temukan';
                    return response()->json($this->getResponse(), $this->responseCode);
                }

                $data = Konseling::with('klien.kabupaten', 'jadwalDetail.jadwal.konselor', 'jadwalDetail.jadwal.psikolog', 'pengaduan', 'klien.kelurahan.kecamatan')->whereHas('jadwalDetail.jadwal', function ($query) use ($id_psikolog_volunteer) {
                    $query->where('id_psikolog_volunteer', $id_psikolog_volunteer);
                });
                if ($request->filled('status')) {
                    $data->where('status', $request->status);
                }
                $data = $data->orderBy($sortby, $order)->paginate($limit);
                $data->append('keterangan');
                $data->append('status_string');
            }
            else {
                $id_konselor = auth()->user()->id_konselor;
                $konselor = MKonselor::where('id', $id_konselor)->first();
                if (!$konselor) {
                    $this->responseCode = 404;
                    $this->responseMessage = 'Data tidak di temukan';
                    return response()->json($this->getResponse(), $this->responseCode);
                }

                $data = Konseling::with('klien.kabupaten', 'psikologrujukan', 'jadwalDetail.jadwal.konselor', 'jadwalDetail.jadwal.psikolog', 'pengaduan', 'klien.kelurahan.kecamatan')->whereHas('jadwalDetail.jadwal', function ($query) use ($id_konselor) {
                    $query->where('id_konselor', $id_konselor);
                });
                if ($request->filled('status')) {
                    $data->where('status', $request->status);
                }
                $data = $data->orderBy($sortby, $order)->paginate($limit);
                $data->append('keterangan');
                $data->append('status_string');
            }
            
            $this->responseCode = 201;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function accept($id,Request $request){
        try {
            DB::beginTransaction();
            $id = intval($id);
            $konseling = Konseling::where('id', $id)->first();
            if(!$konseling){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $konseling->status = StatusKonselingEnum::ACCEPTED;
            $konseling->save();
            
            $phonenumber = [HelperPublic::normalizePhoneNumber($konseling->klien->phone)];
            $name = $konseling->klien->name;
            $starttime = Carbon::parse($konseling->jadwalDetail->start_time)->translatedFormat('H:i');
            $endtime = Carbon::parse($konseling->jadwalDetail->end_time)->translatedFormat('H:i');
            $session = $starttime . " - " . $endtime;
            $duration = 45;
            if ($konseling->jadwalDetail->jadwal->id_psikolog_volunteer) {
                $consultantname = $konseling->jadwalDetail->jadwal->psikolog->name;
                $phonenumber[] = $konseling->jadwalDetail->jadwal->psikolog->no_hp;
            }
            else {
                $consultantname = $konseling->jadwalDetail->jadwal->konselor->name;
                $phonenumber[] = HelperPublic::normalizePhoneNumber($konseling->jadwalDetail->jadwal->konselor->phone_number);
            }

            $message = "Selamat datang Bapak/Ibu " . $name . " di Layanan Konsultasi Online SIAP PPAK

                        Terima kasih sudah mendaftar konsultasi secara online dengan:
                        Nama Konselor: " . $consultantname . "
                        Tanggal Konseling: " . Carbon::parse($konseling->date)->translatedFormat('d F Y') . "
                        Sesi Konseling: " . $session . " WIB

                        Konsultasi berlangsung selama " . $duration . " menit. Jika durasi waktu telah berakhir, anda harus memesan jadwal konsultasi pada sesi lain yang tersedia.

                        Silahkan klik link berikut untuk memulai konsultasi:
                        https://bit.ly/telekonsultasipuspaga

                        Jika link tidak dapat dibuka, silahkan input secara manual di aplikasi zoom:
                        Meeting ID: 712 762 2420
                        Passcode : puspaga

                        Semoga masalah anda teratasi.

                        Jangan lupa untuk memberikan rating dan review serta mengisi Form Screening dan Survei Indeks Kepuasan Masyarakat jika sudah selesai konsultasi.
                        Silahkan klik link berikut untuk mengisi Indeks Kepuasan Masyarakat: https://bit.ly/ikmsiapppak

                        *Jika ada pertanyaan lebih lanjut silakan chat di nomor Call Center PUSPAGA: 0877 2228 8959

                        Dikirim secara otomatis oleh sistem SIAP PPAK Kota Surabaya.";
            
            $konseling->whatsappresult = WhatsappTwilioHelper::send($phonenumber, $message);

            DB::commit();
            
            $this->responseCode = 201;
            $this->responseMessage = StatusKonselingEnum::labelPesan(StatusKonselingEnum::ACCEPTED);
            $this->responseData = $konseling;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function finish($id,Request $request){
        try {
            DB::beginTransaction();
            $id = intval($id);
            $konseling = Konseling::where('id', $id)->first();
            if(!$konseling){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            
            $rules = [
                'status' => ['required', Rule::in([StatusKonselingEnum::FINISHED_WITH_NOTE, StatusKonselingEnum::FINISHED_WITHOUT_NOTE, StatusKonselingEnum::ABSENT])],
                'result' => ['required'],
                'id_psikolog_volunteer' => ['required_if:status,==,' . StatusKonselingEnum::FINISHED_WITH_NOTE],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $konseling->result = $request->result;
            $konseling->status = $request->status;
            $konseling->result = $request->result;
            $konseling->id_psikolog_volunteer = $request->id_psikolog_volunteer;
            $konseling->save();

            DB::commit();
            $this->responseCode = 201;
            $this->responseMessage = StatusKonselingEnum::labelPesan($request->status);
            $this->responseData = $konseling;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    
    public function reject($id,Request $request){
        try {
            DB::beginTransaction();
            $id = intval($id);
            $konseling = Konseling::where('id', $id)->first();
            if(!$konseling){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            
            $rules = [
                'note_reject' => 'required|string'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $konseling->status = StatusKonselingEnum::REJECTED;
            $konseling->note_reject = $request->note_reject;
            $konseling->save();

            DB::commit();
            $this->responseCode = 201;
            $this->responseMessage = StatusKonselingEnum::labelPesan(StatusKonselingEnum::REJECTED);
            $this->responseData = $konseling;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    
    public function review($id,Request $request){
        try {
            DB::beginTransaction();
            $id = intval($id);
            $konseling = Konseling::where('id', $id)->first();
            if(!$konseling){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            
            $rules = [
                'rating' => 'required|numeric|min:1|max:5',
                'review' => 'string|max:500'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $konseling->rating = $request->rating;
            $konseling->review = $request->review;
            $konseling->save();

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $konseling;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    
    public function getReview($id,Request $request){
        try {
            $id = intval($id);
            $konseling = Konseling::where('id', $id)->first();
            if(!$konseling){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $data = new stdClass();
            $data->rating = $konseling->rating;
            $data->review = $konseling->review;
            $this->responseCode = 201;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
    public function getHasilKonseling($id,Request $request){
        try {
            $id = intval($id);
            $konseling = Konseling::where('id', $id)->first();
            if(!$konseling){
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }
            $data = new stdClass();
            $data->result = $konseling->result;
            $this->responseCode = 201;
            $this->responseData = $data;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function select()
    {
        return DKlienKonseling::select([
            'd_klien_konseling.*',
            'm_kelurahan.name AS nama_kelurahan',
            'd_klien_konseling_file.path AS ttd_path'
        ])
            ->leftJoin('m_kelurahan', 'm_kelurahan.id', '=', 'd_klien_konseling.id_kelurahan')
            ->leftJoin('d_klien_konseling_file', function ($join) {
                $join->on('d_klien_konseling_file.id_klien_konseling', '=', 'd_klien_konseling.id')
                    ->where('d_klien_konseling_file.type', 3);
            });
    }

    public function cetakPdf($id)
    {
        $id = intval($id);
        $model = $this->select()->where('d_klien_konseling.id', $id)->first();
        if (!$model) {
            $this->responseCode = 404;
            $this->responseMessage = 'Data tidak ditemukan';
            return response()->json($this->getResponse(), $this->responseCode);
        }

        // $this->authorize('cetakPdf', $model);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf.cetakInformedConsent', ['data' => json_decode(json_encode($model))]);

        $this->saveLog();
        return $pdf->download('cetak_surat_pernyataan-' . $id . '.pdf');
    }

    public function integratePengaduan(Request $request){
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), $this->pengaduanRules($request));
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }
    
            if ($request->client_type == ClientTypeEnum::FROM_NEW_KLIEN) {
                $klien = DaftarKlien::create([
                    'name' => $request->nama_lengkap_klien,
                    'initial_name' => $request->inisial_klien,
                    'is_has_nik' => $request->filled('is_has_nik') ? $request->is_has_nik : true,
                    'nik_number' => $request->filled('is_has_nik') && $request->is_has_nik ? $request->nik_klien : null,
                    'identity_number' => !$request->is_has_nik ? DaftarKlien::IdentityNumber() : null,
                    'phone_number' => $request->no_telepon_klien,
                    'is_surabaya_resident' => $request->filled('warga_surabaya_klien') ? $request->warga_surabaya_klien : true,
                    'id_kabupaten_tinggal' => $request->filled('warga_surabaya_klien') && !$request->warga_surabaya_klien ? $request->id_kabupaten_klien : null,
                    'id_kelurahan_tinggal' => $request->id_kelurahan_klien,
                    'residence_address' => $request->alamat_klien,
                ]);
            }
            if ($request->client_type == ClientTypeEnum::FROM_NEW_PELAPOR) {
                $words = explode(" ", $request->nama_lengkap_pelapor);
                $initial = "";
    
                foreach ($words as $w) {
                    $initial .= mb_substr($w, 0, 1);
                }
    
                $klien = DaftarKlien::create([
                    'name' => $request->nama_lengkap_pelapor,
                    'initial_name' => strtoupper($initial),
                    'is_has_nik' => $request->filled('nik_pelapor') ?? false,
                    'nik_number' => $request->filled('nik_pelapor') ? $request->nik_pelapor : null,
                    'identity_number' => !$request->filled('nik_pelapor') ? DaftarKlien::IdentityNumber() : null,
                    'phone_number' => $request->no_telepon_pelapor,
                    'is_surabaya_resident' => $request->filled('warga_surabaya_pelapor') ? $request->warga_surabaya_pelapor : true,
                    'id_kabupaten_tinggal' => $request->filled('warga_surabaya_pelapor') && !$request->warga_surabaya_pelapor ? $request->id_kabupaten_pelapor : null,
                    'residence_address' => $request->alamat_pelapor,
                ]);
            }
    
            $sumberkeluhan = MSumberKeluhan::where('name','Konseling Online')->first();
            if(empty($sumberkeluhan)){
                $sumberkeluhan = MSumberKeluhan::create([
                    'name' => 'Konseling Online',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $pengaduan = new Pengaduan();
            $pengaduan->id_sumber_keluhan = $sumberkeluhan->id;
            $pengaduan->registration_number = (DB::table('pengaduan')
                ->whereYear('complaint_date', date('Y', strtotime($request->tanggal_pengaduan)))
                ->orderByRaw('registration_number::int DESC')->pluck('registration_number')->first()  ?? 0
            ) + 1;
            $pengaduan->complaint_date = $request->tanggal_pengaduan;
            $pengaduan->complainant_name = $request->nama_lengkap_pelapor;
            $pengaduan->complainant_nik = $request->nik_pelapor ?? '';
            if ($request->filled('warga_surabaya_pelapor')) {
                $pengaduan->complainant_is_surabaya_resident = $request->warga_surabaya_pelapor;
                if (!$request->warga_surabaya_pelapor) {
                    $pengaduan->complainant_id_kabupaten = $request->id_kabupaten_pelapor;
                }
            }
            $pengaduan->complainant_phone_number = $request->no_telepon_pelapor;
            $pengaduan->complainant_residence_address = $request->alamat_pelapor;
            $pengaduan->problem_description = $request->uraian_singkat_permasalahan;
            $pengaduan->client_type = $request->client_type;
            $pengaduan->id_klien = $request->client_type == ClientTypeEnum::FROM_MASTER_KLIEN ? $request->id_klien : $klien->id;
            $pengaduan->id_status = 1;
            $pengaduan->save();
    
            foreach ($request->dokumentasi as $file) {
                $changedName = time() . random_int(100, 999) . '.' . $file->getClientOriginalExtension();
                $is_image = false;
                if (substr($file->getClientMimeType(), 0, 5) == 'image') {
                    $is_image = true;
                }
    
                $path = 'private/pengaduan/' . $pengaduan->id;
                $file->storeAs($path, $changedName);
    
                $PengaduanFile = new PengaduanFile();
                $PengaduanFile->id_pengaduan = $pengaduan->id;
                $PengaduanFile->name = $file->getClientOriginalName();
                $PengaduanFile->path = $path . '/' . $changedName;
                $PengaduanFile->size = $file->getSize();
                $PengaduanFile->ext = $file->getClientOriginalExtension();
                $PengaduanFile->is_image = $is_image;
                $PengaduanFile->save();
            }
    
            $timeline = TimelinePengaduan::create([
                'id_pengaduan' => $pengaduan->id,
                'id_status' => $pengaduan->id_status,
                'name' => 'Menunggu Verifikasi Hotline',
                'description' => 'Pengaduan baru, sedang dalam proses penanganan awal'
            ]);
            
            
            $konseling = Konseling::find($request->id_konseling);
            $konseling->id_pengaduan = $pengaduan->id;
            $konseling->save();

            DB::commit();
            $this->responseCode = 201;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            DB::rollback();
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage(). ' ' .$e->getLine();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function pengaduanRules($req){
        $rules = [
            // 'id_sumber' => 'required|exists:App\Models\MSumberKeluhan,id,deleted_at,NULL',
            'tanggal_pengaduan' => 'required|date',
            'uraian_singkat_permasalahan' => 'required|string',
            'dokumentasi' => 'required|array|min:1',
            'dokumentasi.*' => 'mimes:png,jpg,jpeg',
            'dokumentasi_existing' => 'nullable|array',
            'dokumentasi_existing.*' => 'exists:App\Models\PengaduanFile,id,deleted_at,NULL',

            // pelapor
            'nama_lengkap_pelapor' => 'required|string',
            'nik_pelapor' => 'nullable|numeric',
            'no_telepon_pelapor' => 'required|string',
            'warga_surabaya_pelapor' => 'nullable|boolean',
            'id_kabupaten_pelapor' => 'nullable|exists:App\Models\MKabupaten,id,deleted_at,NULL',
            'alamat_pelapor' => 'required|string',

            // klien
            // 'client_type' => 'required|in:1,2,3',
            'client_type' => ['required',Rule::in(ClientTypeEnum::getValues())],
            'id_klien' => 'nullable',
            'nama_lengkap_klien' => 'nullable|string',
            'inisial_klien' => 'nullable|string',
            'nik_klien' => 'nullable|numeric',
            'is_has_nik' => 'nullable|boolean',
            'warga_surabaya_klien' => 'nullable|boolean',
            'id_kabupaten_klien' => 'nullable|exists:App\Models\MKabupaten,id,deleted_at,NULL',
            'no_telepon_klien' => 'nullable|string',
            'alamat_klien' => 'nullable|string',
            'id_kelurahan_klien' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL',

            // data konseling
            'id_konseling' => 'required|exists:App\Models\Konseling,id,deleted_at,NULL'
        ];
        if ($req->filled('warga_surabaya_pelapor') && !$req->warga_surabaya_pelapor) {
            $rules['id_kabupaten_pelapor'] .= '|required';
        }
        if ($req->client_type == ClientTypeEnum::FROM_MASTER_KLIEN) {
            $rules['id_klien'] .= '|required|exists:App\Models\DaftarKlien,id,deleted_at,NULL';
        }
        if ($req->client_type == ClientTypeEnum::FROM_NEW_KLIEN) {
            $rules['nama_lengkap_klien'] .= '|required';
            $rules['inisial_klien'] .= '|required';
            if ($req->filled('is_has_nik') && $req->is_has_nik) {
                $rules['nik_klien'] .= '|required';
            }
            if ($req->filled('warga_surabaya_klien') && !$req->warga_surabaya_klien) {
                $rules['id_kabupaten_klien'] .= '|required';
            }

            $rules['id_kelurahan_klien'] .= '|required';
            $rules['no_telepon_klien'] .= '|required';
            $rules['alamat_klien'] .= '|required';
        }
        return $rules;
    }

    public function export(Request $request)
    {
        // $this->authorize('export', Konseling::class);
        ini_set('memory_limit', -1);
        // $data = Konseling::select('id_klien_konseling', 'date', 'description', 'id_jadwal_konseling_detail')->get();
        $data = Konseling::select(
            'id_klien_konseling',
            'date', 
            'description',
            'status',
            'result',
            'note_reject',
            'id_jadwal_konseling_detail',
            'id_pengaduan')->with(
                'klien.kelurahan.kecamatan',
                'klien.kabupaten', 
                'klien.user',
                'jadwalDetail.jadwal.konselor', 
                'jadwalDetail.jadwal.psikolog', 
                'pengaduan')->get();
            if ($request->filled('status')) {
                    $data->where('status', $request->status);
                }
    
        
            // dd($data); 
        return Excel::download(new DatabaseExport($data, 'exports.konseling'), 'Konseling.xlsx');
    }


}
