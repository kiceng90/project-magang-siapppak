<?php

namespace App\Http\Controllers\API;

use App\Enums\JenisMahasiswaStatusEnum;
use App\Enums\MahasiswaStatusEnum;
use App\Exports\DatabaseExport;
use App\Helpers\HelperPublic;
use App\Http\Controllers\Controller;
use App\Mail\MahasiswaRegisterNotif;
use App\Models\DBalaiPuspagaRW;
use App\Models\DMahasiswa;
use App\Models\MahasiswaBalaiPuspagaRW;
use App\Models\MInstansiPendidikan;
use App\Models\MJenisMahasiswa;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TestController extends Controller
{
    // Test Controller Purposes
    public function sendEmail(Request $request){
        
        // $withs = [
        //     'user',
        //     'kabupaten_lahir',
        //     'pendidikan_terakhir',
        //     'jenis_mahasiswa',
        //     'jurusan',
        //     'instansi_pendidikan',
        //     'kelurahan_domisili.kecamatan.kabupaten',
        //     'kelurahan_kk.kecamatan.kabupaten',
        //     'file_ktp',
        //     'file_foto',
        //     'file_ttd'
        //   ];
        // $mahasiswa = DMahasiswa::where('id',39)->with($withs)->first();
        // $mahasiswa->append('file_ktp','file_foto','file_ttd');

        // $html = view('pdf.cetakPernyataanMahasiswa', ['mahasiswa' => $mahasiswa]);
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML($html);

        // Mail::to("utuyutuf@gmail.com")->send(new MahasiswaRegisterNotif($mahasiswa));
            
        // Tipe Rekapitulasi Value :
        // mahasiswa, penugasan, konselor (staf pj)
        
        $rules = [
            'type' => ['required',Rule::in(['mahasiswa','penugasan','konselor'])],
            'filter' => ['required',Rule::in(['univ','status','wilayah','jenis'])]
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $this->responseCode = 422;
            $this->responseMessage = $validator->errors()->first();
            $this->responseData = $validator->errors();
            return response()->json($this->getResponse(), $this->responseCode);
        }
        $finaldata = null;
        if($request->type == 'mahasiswa'){
            $tableheaders = [];
            foreach(MJenisMahasiswa::query()->orderBy('id','ASC')->get() as $h){
                $tableheaders[] = [
                    'key' => Str::slug($h->name),
                    'name' => $h->name
                ];
            }
            // Filter Mahasiswa Value :
            // univ, status
            if($request->filter == 'univ'){
                $datas = MInstansiPendidikan::all();
                $resultdata = [];
                foreach($datas as $row){
                    $datas2 = MJenisMahasiswa::whereHas('mahasiswa',function($q) use ($row){
                        $q->where('id_instansi_pendidikan',$row->id);
                    })->withCount('mahasiswa')->orderBy('id','ASC')->get();
                    $datas2result = [];
                    foreach($datas2 as $j){
                        $datas2result[] = [
                            'name' => Str::slug($j->name),
                            'count' => $j->mahasiswa_count
                        ];
                    }
                    $resultdata[] = [
                        'name' => $row->name,
                        'child' => $datas2result
                    ];
                }
                $finaldata = [
                    'type' => $request->filter,
                    'header' => $tableheaders,
                    'result' =>$resultdata,
                ];
            }
            if($request->filter == 'status'){
                $datas = MJenisMahasiswa::all();
                $resultdata = [];
                foreach($datas as $row){
                    $datas2 = MJenisMahasiswa::withCount('mahasiswa')->where('status',$row->status)->orderBy('id','ASC')->get();
                    $datas2result = [];
                    foreach($datas2 as $j){
                        $datas2result[] = [
                            'name' => Str::slug($j->name),
                            'count' => $j->mahasiswa_count
                        ];
                    }
                    $resultdata[] = [
                        'name' => JenisMahasiswaStatusEnum::label($row->status),
                        'child' => $datas2result
                    ];
                }
                $finaldata = [
                    'type' => $request->filter,
                    'header' => $tableheaders,
                    'result' =>$resultdata,
                ];
            }
            $finaldata['type'] = $request->type;
        }
        if($request->type == 'penugasan'){
            
            $tableheaders = [];
            foreach(MahasiswaStatusEnum::toObject() as $h){
                $tableheaders[] = [
                    'key' => Str::slug($h->label),
                    'name' => $h->label
                ];
            }
            // Filter Penugasan Value :
            // wilayah, univ
            if($request->filter == 'wilayah'){
                $datas = MahasiswaBalaiPuspagaRW::with('mahasiswa')->with('balai_puspaga.kelurahan.kecamatan')->with('konselor')->get();
                $resultdata = [];
                // Kecamatan inside table body
                $rowheaders = [];
                foreach($datas as $row){
                    $rowheader = [
                        'key' => Str::slug('kec '.$row->balai_puspaga->kelurahan->kecamatan->name),
                        'value' => $row->balai_puspaga->kelurahan->kecamatan->name,
                        'id' => $row->balai_puspaga->kelurahan->kecamatan->id,
                        'kel_id' => $row->balai_puspaga->kelurahan->id
                    ];
                    $rowheaders[] = $rowheader;
                }
                // Iterate per kecamatan
                foreach($rowheaders as $row){
                    // Get all mahasiswa assigned to balai puspaga per kecamatan
                    $datas = MahasiswaBalaiPuspagaRW::with('mahasiswa')
                    ->whereHas('balai_puspaga',function($query) use ($row){
                        $query->whereHas('kelurahan',function($query) use ($row){
                            $query->whereHas('kecamatan',function($query) use ($row){
                                $query->where('id',$row['id']);
                            });
                        });
                    })
                    ->get();
                    // Iterate all mahasiswa per kecamatan
                    foreach($datas as $row2){                        
                        $datas2result = [];
                        $colcounts2 = [];
                        foreach($row2->mahasiswa as $row3){
                            $keycol = Str::slug(MahasiswaStatusEnum::label($row3->status));
                            $colcounts2[$keycol] = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]) + 1;
                        }
                        foreach($tableheaders as $h){
                            $keycol = Str::slug($h['name']);
                            $count = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]);
                            $datas2result[] = [
                                'name' => $keycol,
                                'count' => $count
                            ];
                        }
                        $resultdata[] = [
                            'name' => $row2->balai_puspaga->kelurahan->kecamatan->name,
                            'is_header' => true,
                            'child' => $datas2result
                        ];
                    }
                    // Get all mahasiswa assigned to balai puspaga per kelurahan
                    $datas = MahasiswaBalaiPuspagaRW::with('mahasiswa')
                    ->whereHas('balai_puspaga',function($query) use ($row){
                        $query->whereHas('kelurahan',function($query) use ($row){                                
                            $query->where('id',$row['kel_id']);
                        });
                    })
                    ->get();
                    // Iterate all mahasiswa per kelurahan
                    foreach($datas as $row2){                        
                        $datas2result = [];
                        $colcounts2 = [];
                        foreach($row2->mahasiswa as $row3){
                            $keycol = Str::slug(MahasiswaStatusEnum::label($row3->status));
                            $colcounts2[$keycol] = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]) + 1;
                        }
                        foreach($tableheaders as $h){
                            $keycol = Str::slug($h['name']);
                            $count = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]);
                            $datas2result[] = [
                                'name' => $keycol,
                                'count' => $count
                            ];
                        }
                        $resultdata[] = [
                            'name' => $row2->balai_puspaga->kelurahan->name. " - RW " . $row2->balai_puspaga->rw,
                            'child' => $datas2result
                        ];
                    }
                }
                $finaldata = [
                    'type' => $request->filter,
                    'header' => $tableheaders,
                    'result' =>$resultdata,
                ];
            }
            if($request->filter == 'univ'){
                $datas = MahasiswaBalaiPuspagaRW::whereHas('sample_mahasiswa',function($query){
                    $query->whereHas('instansi_pendidikan',function($query){
                        $query->groupBy('id');
                    });
                })->get();

                $resultdata = [];
                // Universitas inside table body
                $rowheaders = [];
                foreach($datas as $row){
                    $rowheader = [
                        'key' => Str::slug('univ '.$row->sample_mahasiswa->instansi_pendidikan->name),
                        'value' => $row->sample_mahasiswa->instansi_pendidikan->name,
                        'id' => $row->sample_mahasiswa->instansi_pendidikan->id,
                    ];
                    $rowheaders[] = $rowheader;
                }
                // Iterate per universitas
                foreach($rowheaders as $row){
                    // Get all mahasiswa assigned to balai puspaga per universitas
                    $datas = MahasiswaBalaiPuspagaRW::whereHas('mahasiswa',function($query) use ($row){
                        $query->whereHas('instansi_pendidikan',function($query) use ($row){ 
                            $query->where('id',$row['id']);
                        });
                    })
                    ->get();
                    // Iterate all mahasiswa per universitas
                    foreach($datas as $row2){                        
                        $datas2result = [];
                        $colcounts2 = [];
                        foreach($row2->mahasiswa as $row3){
                            $keycol = Str::slug(MahasiswaStatusEnum::label($row3->status));
                            $colcounts2[$keycol] = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]) + 1;
                        }
                        foreach($tableheaders as $h){
                            $keycol = Str::slug($h['name']);
                            $count = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]);
                            $datas2result[] = [
                                'name' => $keycol,
                                'count' => $count
                            ];
                        }
                        $resultdata[] = [
                            'name' => $row['value'],
                            'is_header' => true,
                            'child' => $datas2result
                        ];
                    }
                    // Get all mahasiswa assigned to balai puspaga per jenis mahasiswa
                    $datas = MahasiswaBalaiPuspagaRW::whereHas('mahasiswa',function($query) use ($row){
                        $query->whereHas('instansi_pendidikan',function($query) use ($row){ 
                            $query->where('id',$row['id']);
                        });
                        $query->with('jenis_mahasiswa');
                    })
                    ->get();
                    // Iterate all mahasiswa per jenis mahasiswa
                    foreach($datas as $row2){                        
                        $datas2result = [];
                        $colcounts2 = [];
                        foreach($row2->mahasiswa as $row3){
                            $keycol = Str::slug(MahasiswaStatusEnum::label($row3->status));
                            $colcounts2[$keycol] = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]) + 1;
                        }
                        foreach($tableheaders as $h){
                            $keycol = Str::slug($h['name']);
                            $count = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]);
                            $datas2result[] = [
                                'name' => $keycol,
                                'count' => $count
                            ];
                        }
                        $resultdata[] = [
                            'name' => $row2->mahasiswa[0]->jenis_mahasiswa->name,
                            'child' => $datas2result
                        ];
                    }
                }
                $finaldata = [
                    'type' => $request->filter,
                    'header' => $tableheaders,
                    'result' =>$resultdata,
                ];
            }
            $finaldata['type'] = $request->type;
        }
        if($request->type == 'konselor'){
            
            $tableheaders = [];
            foreach(MahasiswaStatusEnum::toObject() as $h){
                $tableheaders[] = [
                    'key' => Str::slug($h->label),
                    'name' => $h->label
                ];
            }
            // Filter Penugasan Value :
            // jenis, univ
            if($request->filter == 'jenis'){
                $datas = MahasiswaBalaiPuspagaRW::with('mahasiswa.jenis_mahasiswa')->with('sample_mahasiswa.jenis_mahasiswa')->with('konselor')->get();
                $resultdata = [];
                // Konselor inside table body
                $rowheaders = [];
                foreach($datas as $row){
                    $rowheader = [
                        'key' => Str::slug('kec '.$row->sample_mahasiswa->jenis_mahasiswa->name),
                        'value' => $row->sample_mahasiswa->jenis_mahasiswa->name,
                        'id' => $row->sample_mahasiswa->jenis_mahasiswa->id,
                        'konselor_id' => $row->konselor->id
                    ];
                    $rowheaders[] = $rowheader;
                }
                // Iterate per Konselor
                foreach($rowheaders as $row){
                    // Get all mahasiswa assigned to balai puspaga per konselor
                    $datas = MahasiswaBalaiPuspagaRW::with('mahasiswa')
                    ->whereHas('konselor',function($query) use ($row){
                        $query->where('id',$row['konselor_id']);
                    })
                    ->get();
                    // Iterate all mahasiswa per konselor
                    foreach($datas as $row2){                        
                        $datas2result = [];
                        $colcounts2 = [];
                        foreach($row2->mahasiswa as $row3){
                            $keycol = Str::slug(MahasiswaStatusEnum::label($row3->status));
                            $colcounts2[$keycol] = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]) + 1;
                        }
                        foreach($tableheaders as $h){
                            $keycol = Str::slug($h['name']);
                            $count = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]);
                            $datas2result[] = [
                                'name' => $keycol,
                                'count' => $count
                            ];
                        }
                        $resultdata[] = [
                            'name' => $row2->konselor->name,
                            'is_header' => true,
                            'child' => $datas2result
                        ];
                    }
                    // Get all mahasiswa assigned to balai puspaga per jenis mahasiswa
                    $datas = MahasiswaBalaiPuspagaRW::whereHas('konselor',function($query) use ($row){
                        $query->where('id',$row['konselor_id']);
                    })
                    ->whereHas('mahasiswa',function($query) use ($row){
                        $query->whereHas('jenis_mahasiswa',function($query) use ($row){                                
                            $query->where('id',$row['id']);
                        });
                    })
                    ->whereHas('sample_mahasiswa',function($query) use ($row){
                        $query->whereHas('jenis_mahasiswa',function($query) use ($row){                                
                            $query->where('id',$row['id']);
                        });
                    })
                    ->get();
                    // Iterate all mahasiswa per kelurahan
                    foreach($datas as $row2){                        
                        $datas2result = [];
                        $colcounts2 = [];
                        foreach($row2->mahasiswa as $row3){
                            $keycol = Str::slug(MahasiswaStatusEnum::label($row3->status));
                            $colcounts2[$keycol] = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]) + 1;
                        }
                        foreach($tableheaders as $h){
                            $keycol = Str::slug($h['name']);
                            $count = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]);
                            $datas2result[] = [
                                'name' => $keycol,
                                'count' => $count
                            ];
                        }
                        $resultdata[] = [
                            'name' => $row2->sample_mahasiswa->jenis_mahasiswa->name,
                            'child' => $datas2result
                        ];
                    }
                }
                $finaldata = [
                    'type' => $request->filter,
                    'header' => $tableheaders,
                    'result' =>$resultdata,
                ];
            }
            if($request->filter == 'univ'){
                $datas = MahasiswaBalaiPuspagaRW::whereHas('konselor',function($query){
                    $query->groupBy('id');
                })->get();

                $resultdata = [];
                // Universitas inside table body
                $rowheaders = [];
                foreach($datas as $row){
                    $rowheader = [
                        'key' => Str::slug('univ '.$row->konselor->name),
                        'value' => $row->konselor->name,
                        'id' => $row->konselor->id,
                    ];
                    $rowheaders[] = $rowheader;
                }
                // Iterate per konselor
                foreach($rowheaders as $row){
                    // Get all mahasiswa assigned to balai puspaga per universitas
                    $datas = MahasiswaBalaiPuspagaRW::whereHas('konselor',function($query) use ($row){
                        $query->where('id',$row['id']);
                    })
                    ->get();
                    // Iterate all mahasiswa per konselor
                    foreach($datas as $row2){                        
                        $datas2result = [];
                        $colcounts2 = [];
                        foreach($row2->mahasiswa as $row3){
                            $keycol = Str::slug(MahasiswaStatusEnum::label($row3->status));
                            $colcounts2[$keycol] = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]) + 1;
                        }
                        foreach($tableheaders as $h){
                            $keycol = Str::slug($h['name']);
                            $count = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]);
                            $datas2result[] = [
                                'name' => $keycol,
                                'count' => $count
                            ];
                        }
                        $resultdata[] = [
                            'name' => $row['value'],
                            'is_header' => true,
                            'child' => $datas2result
                        ];
                    }
                    // Get all mahasiswa assigned to balai puspaga per univ
                    $datas = MahasiswaBalaiPuspagaRW::with('mahasiswa.instansi_pendidikan')
                    ->whereHas('konselor',function($query) use ($row){
                        $query->where('id',$row['id']);
                    })
                    ->get();
                    // Iterate all mahasiswa per univ
                    foreach($datas as $row2){                        
                        $datas2result = [];
                        $colcounts2 = [];
                        foreach($row2->mahasiswa as $row3){
                            $keycol = Str::slug(MahasiswaStatusEnum::label($row3->status));
                            $colcounts2[$keycol] = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]) + 1;
                        }
                        foreach($tableheaders as $h){
                            $keycol = Str::slug($h['name']);
                            $count = ((empty($colcounts2[$keycol])) ? 0 : $colcounts2[$keycol]);
                            $datas2result[] = [
                                'name' => $keycol,
                                'count' => $count
                            ];
                        }
                        $resultdata[] = [
                            'name' => $row2->mahasiswa[0]->instansi_pendidikan->name,
                            'child' => $datas2result
                        ];
                    }
                }
                $finaldata = [
                    'type' => $request->filter,
                    'header' => $tableheaders,
                    'result' =>$resultdata,
                ];
            }
            $finaldata['type'] = $request->type;
        }
        $this->responseCode = 200;
        $this->responseData = collect($finaldata);

        if ($request->is_download) {
            $this->saveLog();
            return view('exports.rekapMahasiswa',['data' => HelperPublic::arrayToCollection($finaldata)]);
            // return Excel::download(new DatabaseExport(HelperPublic::arrayToCollection($finaldata), 'exports.rekapMahasiswa'), 'Rekap Mahasiswa.xlsx');
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
