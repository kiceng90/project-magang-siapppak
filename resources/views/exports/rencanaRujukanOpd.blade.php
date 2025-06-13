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
            $countMaxPelayanan = function ($index = null) use($datas){          
                $response = 0;
                for ($i = 0; $i < count($datas); $i++) {
                    if($datas[$i]->pelayanan){
                        if($response < count($datas[$i]->pelayanan)){
                            $response = count($datas[$i]->pelayanan);
                        }
                    }
                                        
                }

                return $response;
            };

?>

<table class="table" cellspacing="0" style="font-family:Arial;">
    <thead>
        <tr>
            <th colspan="4" style="background:#f69546;text-align:center;">IDENTITAS
                KLIEN</th>
            @for($i = 0; $i < $countMaxPelayanan(); $i++)
            <th colspan="4" style="background:#9bbb59;text-align:center;">PELAYANAN {{$i + 1}}</th>
            @endfor            
        </tr>
        <tr>
            <th style="background:#f69546;text-align:center;">NO</th>
            <th style="background:#f69546;text-align:center;">NO REGISTRASI</th>
            <th style="background:#f69546;text-align:center;width:200px">NAMA LENGKAP KLIEN</th>
            <th style="background:#f69546;text-align:center;width:200px">NIK</th>
            @for($i = 0; $i < $countMaxPelayanan(); $i++)
            <th style="background:#9bbb59;text-align:center;width:200px">KEBUTUHAN</th>
            <th style="background:#9bbb59;text-align:center;width:200px">OPD/INSTANSI RUJUKAN</th>            
            <th style="background:#9bbb59;text-align:center;width:200px">PELAYANAN YANG DIBERIKAN INTERVENSI</th>    
            {{-- <th style="background:#9bbb59;text-align:center;width:200px">NAMA PELAYANAN</th>  
            <th style="background:#9bbb59;text-align:center;width:200px">DESKRIPSI PELAYANAN</th>   --}}
            <th style="background:#9bbb59;text-align:center;width:200px">STATUS PENANGANAN</th>           
            @endfor
        </tr>
    </thead>
    <tbody>
    @foreach($data ?? [] as $key => $context)
        <tr>
            <td class="text-center">{{$key + 1}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->no_registrasi}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nama}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nik . '‎'}}</td>
            @for($i = 0; $i < $countMaxPelayanan(); $i++)
            <td style="text-align:center;">
                {{$context->pelayanan && count($context->pelayanan) > $i && $context->pelayanan[$i] ? $context->pelayanan[$i]->kebutuhan : ''}}
            </td>
            <td style="text-align:center;">
                {{$context->pelayanan && count($context->pelayanan) > $i && $context->pelayanan[$i] ? $context->pelayanan[$i]->opd : ''}}
            </td>            
            <td style="text-align:center;">
                {{$context->pelayanan && count($context->pelayanan) > $i && $context->pelayanan[$i] ? $context->pelayanan[$i]->pelayanan_diberikan : ''}}
            </td>
            {{-- <td style="text-align:center;">
                {{$context->pelayanan && count($context->pelayanan) > $i && $context->pelayanan[$i] ? $context->pelayanan[$i]->nama_pelayanan : ''}}
            </td>                      
            <td style="text-align:center;">
                {{$context->pelayanan && count($context->pelayanan) > $i && $context->pelayanan[$i] ? $context->pelayanan[$i]->deskripsi : ''}}
            </td>    --}}
            <td style="text-align:center;">
                {{$context->pelayanan && count($context->pelayanan) > $i && $context->pelayanan[$i] ? $context->pelayanan[$i]->status : ''}}
            </td>                     
            @endfor          
        </tr>
        @endforeach
    </tbody>
</table>
