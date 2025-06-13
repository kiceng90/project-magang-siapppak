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
            <th colspan="7" style="background:#f69546;text-align:center;">IDENTITAS
                PELAPOR</th>
            <th colspan="3" style="background:#f69546;text-align:center;">URAIAN
                PENGADUAN</th>
            <th colspan="2" style="background:#f69546;text-align:center;">URAIAN
                PENANGANAN AWAL</th>
        </tr>
        <tr>
            <th style="background:#f69546;text-align:center;">NO</th>
            <th style="background:#f69546;text-align:center;width:200px">NO REGISTRASI</th>
            <th style="background:#f69546;text-align:center;width:200px">NAMA LENGKAP PELAPOR</th>
            <th style="background:#f69546;text-align:center;width:200px">NIK PELAPOR(OPSIONAL)</th>
            <th style="background:#f69546;text-align:center;width:100px">WARGA SURABAYA</th>
            <th style="background:#f69546;text-align:center;width:150px">NO TELEPON/WHATSAPP</th>
            <th style="background:#f69546;text-align:center;width:250px">ALAMAT DOMISILI</th>
            <th style="background:#f69546;text-align:center;width:200px">SUMBER PENGADUAN</th>
            <th style="background:#f69546;text-align:center;width:200px">TANGGAL DAN JAM PENGADUAN
            </th>
            <th style="background:#f69546;text-align:center;width:300px">URAIAN SINGKAT
                PERMASALAHAN</th>
            <th style="background:#f69546;text-align:center;width:200px">TANGGAL DAN JAM PENANGANAN
                AWAL</th>
            <th style="background:#f69546;text-align:center;width:300px">HASIL PENANGANAN AWAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data ?? [] as $key => $context)
        <tr>
            <td class="text-center">{{$key + 1}}</td>
            <td style="text-align:center;">{{$context->no_registrasi}}</td>
            <td style="text-align:center;">{{$context->nama}}</td>
            <td style="text-align:center;">{{$context->nik . '‎'}}</td>
            <td style="text-align:center;">{{$context->warga_surabaya}} </td>
            <td style="text-align:center;">{{$context->no_telepon}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili}}</td>
            <td style="text-align:center;">{{$context->sumber_pengaduan}}</td>
            <td style="text-align:center;">{{$context->tgl_dan_jam_pengaduan}}</td>
            <td style="text-align:center;">{{$context->uraian}}</td>
            <td style="text-align:center;">{{$context->tgl_dan_jam_penanganan}}</td>
            <td style="text-align:center;">{{$context->hasil_penanganan}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
