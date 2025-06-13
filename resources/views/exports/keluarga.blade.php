<style>
    table,
    th,
    td {
        border: 1px solid;
    }

    table th {
        font-size: 14px;
        padding: 5px
    }

</style>

<?php
            $datas = $data;                       
            $countMaxFamily = function ($index = null) use($datas){          
                $response = 0;
                for ($i = 0; $i < count($datas); $i++) {
                    if($datas[$i]->keluarga){
                        if($response < count($datas[$i]->keluarga)){
                            $response = count($datas[$i]->keluarga);
                        }
                    }
                                        
                }

                return $response;
            };


            $countMaxSibling = function ($index = null) use($datas){          
                $response = 0;
                for ($i = 0; $i < count($datas); $i++) {                    
                    if($datas[$i]->saudara){
                        if($response < count($datas[$i]->saudara)){
                            $response = count($datas[$i]->saudara);
                        }
                    }
                                        
                }
                
                return $response;
            }        
?>
<table class="table" cellspacing="0" style="font-family:Arial;">
    <thead>
        <tr>
            <th colspan="3" style="background:#f69546;text-align:center;">IDENTITAS
                KLIEN</th>
            @for($i = 0; $i < $countMaxFamily(); $i++)
            <th colspan="14" style="background:#4bacc6;text-align:center;">IDENTITAS KELUARGA {{$i+ 1}}</th>
            <th colspan="6" style="background:#4bacc6;text-align:center;">ALAMAT KK</th>
            <th colspan="6" style="background:#4bacc6;text-align:center;">ALAMAT DOMISILI</th>
            @endfor          
            @if($countMaxSibling() > 0)
            <th colspan="{{$countMaxSibling()}}" style="background:#538dd5;text-align:center;">SAUDARA</th>            
            @endif
        </tr>
        <tr>
            <th style="background:#f69546;text-align:center;">NO</th>
            <th style="background:#f69546;text-align:center;width:200px">NAMA KLIEN</th>
            <th style="background:#f69546;text-align:center;width:200px">NIK</th>
            <!-- KELUARGA 1 -->
            @for($i = 0; $i < $countMaxFamily(); $i++)
            <th style="background:#4bacc6;text-align:center;width:200px">HUBUNGAN DENGAN KLIEN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">NAMA LENGKAP</th>
            <th style="background:#4bacc6;text-align:center;width:200px">NIK</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KK</th>
            <th style="background:#4bacc6;text-align:center;width:200px">PEKERJAAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">SIFAT PEKERJAAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">PENGHASILAN PER BULAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">STATUS PERNIKAHAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">AGAMA</th>
            <th style="background:#4bacc6;text-align:center;width:200px">TEMPAT LAHIR</th>
            <th style="background:#4bacc6;text-align:center;width:200px">TANGGAL LAHIR</th>
            <th style="background:#4bacc6;text-align:center;width:200px">USIA</th>
            <th style="background:#4bacc6;text-align:center;width:200px">NO TELP</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KEPEMILIKAN BPJS</th>
            <th style="background:#4bacc6;text-align:center;width:200px">ALAMAT</th>
            <th style="background:#4bacc6;text-align:center;">RT</th>
            <th style="background:#4bacc6;text-align:center;">RW</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KELURAHAN </th>
            <th style="background:#4bacc6;text-align:center;width:200px">KECAMATAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">WILAYAH</th>
            <th style="background:#4bacc6;text-align:center;width:200px">ALAMAT</th>
            <th style="background:#4bacc6;text-align:center;">RT</th>
            <th style="background:#4bacc6;text-align:center;">RW</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KELURAHAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KECAMATAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">WILAYAH</th>
            @endfor           
            <!-- SAUDARA -->
            @for($i = 0; $i < $countMaxSibling(); $i++)
            <th style="background:#538dd5;text-align:center;width:200px">SAUDARA {{$i + 1}}</th>            
            @endfor


        </tr>
    </thead>
    <tbody>
        @foreach($data ?? [] as $key => $context)
        <tr>
            <td class="text-center">{{$key + 1}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nama}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nik . '‎'}}</td>
            @for($i = 0; $i < $countMaxFamily(); $i++)
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->hubungan : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->nama : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->nik . '‎' : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->kk . '‎' : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->pekerjaan : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->sifat_pekerjaan : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->penghasilan : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->status_pernikahan : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->agama : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->tempat_lahir : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->tanggal_lahir : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->usia : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->no_telp : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->kepemilikan_bpjs : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_kk->alamat : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_kk->rt : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_kk->rw : ''}}</td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_kk->kelurahan : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_kk->kecamatan : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_kk->wilayah : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_domisili->alamat : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_domisili->rt : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_domisili->rw : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_domisili->kelurahan : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_domisili->kecamatan : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->keluarga && count($context->keluarga) > $i && $context->keluarga[$i] ? $context->keluarga[$i]->alamat_domisili->wilayah : ''}}
            </td>
            @endfor

            @for($i = 0; $i < $countMaxSibling(); $i++)
                <td style="text-align:center;">{{$context->saudara && count($context->saudara) > $i && $context->saudara[$i] ? $context->saudara[$i]->nama : ''}}</td>         
            @endfor
        </tr>
        @endforeach
    </tbody>
</table>
