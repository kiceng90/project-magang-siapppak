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
            <th colspan="22" style="background:#f69546;text-align:center;">IDENTITAS KLIEN</th>
            <th colspan="6" style="background:#4aacc5;text-align:center;">ALAMAT KK</th>
            <th colspan="6" style="background:#4aacc5;text-align:center;">ALAMAT DOMISILI</th>
            <th colspan="7" style="background:#8064a1;text-align:center;">DETAIL KASUS</th>
            <th colspan="7" style="background:#1e477b;text-align:center;">LAINNYA</th>
            <th style="background:#d99491;text-align:center;"></th>
        </tr>
        <tr>
            <th style="background:#f69546;text-align:center;">NO</th>
            <th style="background:#f69546;text-align:center;">NOMOR REGISTRASI</th>
            <th style="background:#f69546;text-align:center;">NAMA KLIEN</th>
            <th style="background:#f69546;text-align:center;">INISIAL</th>
            <th style="background:#f69546;text-align:center;">NIK</th>
            <th style="background:#f69546;text-align:center;">NO KK</th>
            <th style="background:#f69546;text-align:center;">L/P</th>
            <th style="background:#f69546;text-align:center;">PENDIDIKAN</th>
            <th style="background:#f69546;text-align:center;">KELAS</th>
            <th style="background:#f69546;text-align:center;">JURUSAN</th>
            <th style="background:#f69546;text-align:center;">TAHUN LULUS</th>
            <th style="background:#f69546;text-align:center;">NAMA INSTANSI / SEKOLAH</th>
            <th style="background:#f69546;text-align:center;">PEKERJAAN</th>
            <th style="background:#f69546;text-align:center;">PENGHASILAN PER BULAN</th>
            <th style="background:#f69546;text-align:center;">AGAMA</th>
            <th style="background:#f69546;text-align:center;">STATUS PERKAWINAN</th>
            <th style="background:#f69546;text-align:center;">TEMPAT LAHIR</th>
            <th style="background:#f69546;text-align:center;">TANGGAL LAHIR</th>
            <th style="background:#f69546;text-align:center;">USIA</th>
            <th style="background:#f69546;text-align:center;">KATEGORI KLIEN</th>
            <th style="background:#f69546;text-align:center;">JENIS KLIEN</th>
            <th style="background:#f69546;text-align:center;">TELP</th>
            <th style="background:#4aacc5;text-align:center;">ALAMAT</th>
            <th style="background:#4aacc5;text-align:center;">RT</th>
            <th style="background:#4aacc5;text-align:center;">RW</th>
            <th style="background:#4aacc5;text-align:center;">KELURAHAN</th>
            <th style="background:#4aacc5;text-align:center;">KECAMATAN</th>
            <th style="background:#4aacc5;text-align:center;">WILAYAH</th>
            <th style="background:#4aacc5;text-align:center;">ALAMAT</th>
            <th style="background:#4aacc5;text-align:center;">RT</th>
            <th style="background:#4aacc5;text-align:center;">RW</th>
            <th style="background:#4aacc5;text-align:center;">KELURAHAN</th>
            <th style="background:#4aacc5;text-align:center;">KECAMATAN</th>
            <th style="background:#4aacc5;text-align:center;">WILAYAH</th>
            <th style="background:#8064a1;text-align:center;">TIPE KASUS</th>
            <th style="background:#8064a1;text-align:center;">TIPE PERMASALAHAN</th>
            <th style="background:#8064a1;text-align:center;">KATEGORI KASUS</th>
            <th style="background:#8064a1;text-align:center;">JENIS KASUS</th>
            <th style="background:#8064a1;text-align:center;">URAIAN SINGKAT PERMASALAHAN</th>
            <th style="background:#8064a1;text-align:center;">LOKASI KASUS</th>
            <th style="background:#8064a1;text-align:center;">TANGGAL DAN JAM KEJADIAN</th>
            <th style="background:#1e477b;text-align:center;">KEPEMILIKAN BPJS</th>
            <th style="background:#1e477b;text-align:center;">TANGGAL DAN JAM PENGADUAN</th>
            <th style="background:#1e477b;text-align:center;">TANGGAL DAN JAM PENANGANAN AWAL</th>
            <th style="background:#1e477b;text-align:center;">TANGGAL DAN JAM PENJANGKAUAN</th>
            <th style="background:#1e477b;text-align:center;">KONSELOR 1</th>
            <th style="background:#1e477b;text-align:center;">KONSELOR 2</th>
            <th style="background:#1e477b;text-align:center;">SUMBER PENGADUAN</th>
            <th style="background:#d99491;text-align:center;">DURATION</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $context)
        <tr>
            <td style="text-align:center;">{{$key + 1}}</td>
            <td style="text-align:center;width:300px;">{{$context->identitas_klien->no_registrasi}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->nama_klien}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->inisial}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->nik . '‎'}} </td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->no_kk . '‎'}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->l_p}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->pendidikan}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->kelas}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->jurusan}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->tahun_lulus}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->nama_instansi}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->pekerjaan}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->penghasilan_perbulan}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->agama}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->status_perkawinan}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->tempat_lahir}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->tanggal_lahir}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->usia}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->kategori_klien}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->jenis_klien}}</td>
            <td style="text-align:center;width:200px;">{{$context->identitas_klien->no_telpon}}</td>
            <td style="text-align:center;width:200px;">{{$context->alamat_kk->alamat}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->rt}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->rw}}</td>
            <td style="text-align:center;width:200px;">{{$context->alamat_kk->kelurahan}}</td>
            <td style="text-align:center;width:200px;">{{$context->alamat_kk->kecamatan}}</td>
            <td style="text-align:center;width:200px;">{{$context->alamat_kk->wilayah}}</td>
            <td style="text-align:center;width:200px;">{{$context->alamat_domisili->alamat}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->rt}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->rw}}</td>
            <td style="text-align:center;width:200px;">{{$context->alamat_domisili->kelurahan}}</td>
            <td style="text-align:center;width:200px;">{{$context->alamat_domisili->kecamatan}}</td>
            <td style="text-align:center;width:200px;">{{$context->alamat_domisili->wilayah}}</td>
            <td style="text-align:center;width:200px;">{{$context->kasus->tipe_kasus}}</td>
            <td style="text-align:center;width:200px;">{{$context->kasus->tipe_permasalahan}}</td>
            <td style="text-align:center;width:200px;">{{$context->kasus->kategori_kasus}}</td>
            <td style="text-align:center;width:200px;">{{$context->kasus->jenis_kasus}}</td>
            <td style="text-align:center;width:200px;">{{$context->kasus->deskripsi}}</td>
            <td style="text-align:center;width:200px;">{{$context->kasus->lokasi_kasus}}</td>
            <td style="text-align:center;width:200px;">{{$context->kasus->tanggal_dan_jam}}</td>
            <td style="text-align:center;width:200px;">{{$context->lainnya->kepemilikan_bpjs}}</td>
            <td style="text-align:center;width:200px;">{{$context->lainnya->tanggal_pengaduan}}</td>
            <td style="text-align:center;width:200px;">{{$context->lainnya->tanggal_penanganan_awal}}</td>
            <td style="text-align:center;width:200px;">{{$context->lainnya->tanggal_penjangkauan}}</td>
            <td style="text-align:center;width:200px;">
                @if(count($context->lainnya->konselor) > 0)
                    {{$context->lainnya->konselor[0]->name}}
                @endif
            </td>
            <td style="text-align:center;">
                @if(count($context->lainnya->konselor) > 1)
                    {{$context->lainnya->konselor[1]->name}}
                @endif
            </td>
            <td style="text-align:center;width:200px;">{{$context->lainnya->sumber_pengaduan}}</td>
            <td style="text-align:center;width:200px;">{{$context->duration}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
