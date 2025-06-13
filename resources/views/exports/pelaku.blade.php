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
            <th colspan="3" style="background:#f69546;text-align:center;">IDENTITAS
                KLIEN</th>
            <th colspan="19" style="background:#4bacc6;text-align:center;">IDENTITAS PELAKU</th>
            <th colspan="6" style="background:#4bacc6;text-align:center;">ALAMAT KK</th>
            <th colspan="6" style="background:#4bacc6;text-align:center;">ALAMAT DOMISILI</th>
        </tr>
        <tr>
            <th style="background:#f69546;text-align:center;">NO</th>
            <th style="background:#f69546;text-align:center;width:200px">NAMA KLIEN</th>
            <th style="background:#f69546;text-align:center;width:200px">NIK</th>
            <th style="background:#4bacc6;text-align:center;width:200px">NAMA PELAKU</th>
            <th style="background:#4bacc6;text-align:center;width:200px">NIK</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KK</th>
            <th style="background:#4bacc6;text-align:center;">L/P</th>
            <th style="background:#4bacc6;text-align:center;width:200px">PENDIDIKAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">JURUSAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">TAHUN LULUS</th>
            <th style="background:#4bacc6;text-align:center;width:200px">NAMA INSTANSI / SEKOLAH</th>
            <th style="background:#4bacc6;text-align:center;width:200px">PEKERJAAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">AGAMA</th>
            <th style="background:#4bacc6;text-align:center;width:200px">STATUS PERKAWINAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">TEMPAT LAHIR</th>
            <th style="background:#4bacc6;text-align:center;width:200px">TANGGAL LAHIR</th>
            <th style="background:#4bacc6;text-align:center;">USIA</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KATEGORI</th>
            <th style="background:#4bacc6;text-align:center;width:200px">TELP</th>
            <th style="background:#4bacc6;text-align:center;width:200px">TANGGAL MULAI KENAL PELAKU</th>
            <th style="background:#4bacc6;text-align:center;width:200px">HUB. PELAKU DGN KORBAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KEWARGANEGARAAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">ALAMAT</th>
            <th style="background:#4bacc6;text-align:center;">RT</th>
            <th style="background:#4bacc6;text-align:center;">RW</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KELURAHAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KECAMATAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">WILAYAH</th>
            <th style="background:#4bacc6;text-align:center;width:200px">ALAMAT</th>
            <th style="background:#4bacc6;text-align:center;">RT</th>
            <th style="background:#4bacc6;text-align:center;">RW</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KELURAHAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">KECAMATAN</th>
            <th style="background:#4bacc6;text-align:center;width:200px">WILAYAH</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data ?? [] as $key => $context)   
        <tr>
            <td class="text-center">{{$key + 1}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nama}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nik . '‎'}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->nama}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->nik . '‎'}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->kk . '‎'}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->l_p}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->pendidikan}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->jurusan}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->tahun_lulus}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->instansi}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->pekerjaan}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->agama}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->status_perkawinan}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->tempat_lahir}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->tanggal_lahir}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->usia}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->kategori}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->no_telepon}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->tanggal_kenal_pelaku}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->hub_dengan_korban}}</td>
            <td style="text-align:center;">{{$context->identitas_pelaku->kewarganegaraan}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->alamat}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->rt}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->rw}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->kelurahan}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->kecamatan}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->wilayah}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->alamat}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->rt}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->rw}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->kelurahan}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->kecamatan}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->wilayah}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
