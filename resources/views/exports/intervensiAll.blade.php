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

<table class="table" cellspacing="0" style="font-family:Arial;">
    <thead>
        <tr>
            <th colspan="4" style="background:#f69546;text-align:center;">IDENTITAS
                KLIEN</th>

            <th colspan="4" style="background:#8064a1;text-align:center;">DETAIL KASUS</th>

            <th colspan="5" style="background:#9bbb59;text-align:center;">PELAYANAN</th>
            
        </tr>

        <tr>
            <th style="background:#f69546;text-align:center;">NO</th>
            <th style="background:#f69546;text-align:center;">NO REGISTRASI</th>
            <th style="background:#f69546;text-align:center;width:200px">NAMA LENGKAP KLIEN</th>
            <th style="background:#f69546;text-align:center;width:200px">NIK</th>
            <th style="background:#8064a1;text-align:center;">TIPE PERMASALAHAN</th>
            <th style="background:#8064a1;text-align:center;">KATEGORI KASUS</th>
            <th style="background:#8064a1;text-align:center;">JENIS KASUS</th>
            <th style="background:#8064a1;text-align:center;">TANGGAL DAN JAM PENGADUAN</th>
            <th style="background:#9bbb59;text-align:center;width:200px">TANGGAL PELAYANAN</th>            
            <th style="background:#9bbb59;text-align:center;width:200px">PELAYANAN YANG DIBERIKAN INTERVENSI</th>    
            <th style="background:#9bbb59;text-align:center;width:200px">DESKRIPSI PELAYANAN</th>  
            <th style="background:#9bbb59;text-align:center;width:200px">OPD/INSTANSI RUJUKAN</th>    
            <th style="background:#9bbb59;text-align:center;width:200px">STATUS PENANGANAN</th>           
         
        </tr>
    </thead>
    <tbody>
    
    @php
        $i = 0;
    @endphp
    @foreach($data as $key => $context)
        @if (count($context->pelayanan) > 0)
        
            @foreach($context->pelayanan as $key => $pelayanan)
            <tr>
            <td class="text-center">{{$i + 1}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->no_registrasi}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nama}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nik . '‎'}}</td>
            
            <td style="text-align:center;width:200px;">{{$context->kasus->tipe_permasalahan}}</td>
            <td style="text-align:center;width:200px;">{{$context->kasus->kategori_kasus}}</td>
            <td style="text-align:center;width:200px;">{{$context->kasus->jenis_kasus}}</td>
            <td style="text-align:center;width:200px;">{{$context->lainnya->tanggal_pengaduan}}</td>
            <td style="text-align:center;">
                {{$pelayanan->tanggal_pelayanan }}
            </td>            
            <td style="text-align:center;">
                {{$pelayanan->pelayanan_diberikan }}
            </td>
            <td style="text-align:center;">
                {{  $pelayanan->deskripsi}}
            </td>   
            <td style="text-align:center;">
                {{ $pelayanan->opd}}
            </td>                          
            <td style="text-align:center;">
                {{ $pelayanan->status }}
            </td>    
            </tr>  
            @php
                $i++;
            @endphp     
             @endforeach

        @endif
    @endforeach
    </tbody>
</table>
