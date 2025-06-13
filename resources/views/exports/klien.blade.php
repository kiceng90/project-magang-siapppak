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
            <th colspan="22" style="background:#f69546;text-align:center;">IDENTITAS
                KLIEN</th>
            <th colspan="6" style="background:#4aacc5;text-align:center;">ALAMAT KK</th>
            <th colspan="6" style="background:#4aacc5;text-align:center;">ALAMAT
                DOMISILI</th>
            <th colspan="7" style="background:#8064a1;text-align:center;">DETAIL KASUS
            </th>
            <th colspan="7" style="background:#1e477b;text-align:center;">LAINNYA</th>
            <th style="background:#d99491;text-align:center;"></th>
        </tr>
        <tr>
            <th style="background:#f69546;text-align:center;">NO</th>
            <th style="background:#f69546;text-align:center;width:200px">NOMOR REGISTRASI</th>
            <th style="background:#f69546;text-align:center;width:200px">NAMA KLIEN</th>
            <th style="background:#f69546;text-align:center;">INISIAL</th>
            <th style="background:#f69546;text-align:center;width:200px">NIK</th>
            <th style="background:#f69546;text-align:center;width:200px">NO KK</th>
            <th style="background:#f69546;text-align:center;">L/P</th>
            <th style="background:#f69546;text-align:center;width:200px">PENDIDIKAN</th>
            <th style="background:#f69546;text-align:center;width:200px">KELAS</th>
            <th style="background:#f69546;text-align:center;width:200px">JURUSAN</th>
            <th style="background:#f69546;text-align:center;width:200px">TAHUN LULUS</th>
            <th style="background:#f69546;text-align:center;width:200px">NAMA INSTANSI / SEKOLAH
            </th>
            <th style="background:#f69546;text-align:center;width:200px">PEKERJAAN</th>
            <th style="background:#f69546;text-align:center;width:200px">PENGHASILAN PER BULAN</th>
            <th style="background:#f69546;text-align:center;width:200px">AGAMA</th>
            <th style="background:#f69546;text-align:center;width:200px">STATUS PERKAWINAN</th>
            <th style="background:#f69546;text-align:center;width:200px">TEMPAT LAHIR</th>
            <th style="background:#f69546;text-align:center;width:200px">TANGGAL LAHIR</th>
            <th style="background:#f69546;text-align:center;width:200px">USIA</th>
            <th style="background:#f69546;text-align:center;width:200px">KATEGORI KLIEN</th>
            <th style="background:#f69546;text-align:center;width:200px">JENIS KLIEN</th>
            <th style="background:#f69546;text-align:center;width:200px">TELP</th>
            <th style="background:#4aacc5;text-align:center;width:300px">ALAMAT</th>
            <th style="background:#4aacc5;text-align:center;">RT</th>
            <th style="background:#4aacc5;text-align:center;">RW</th>
            <th style="background:#4aacc5;text-align:center;width:200px">KELURAHAN</th>
            <th style="background:#4aacc5;text-align:center;width:200px">KECAMATAN</th>
            <th style="background:#4aacc5;text-align:center;width:200px">WILAYAH</th>
            <th style="background:#4aacc5;text-align:center;width:300px">ALAMAT</th>
            <th style="background:#4aacc5;text-align:center;">RT</th>
            <th style="background:#4aacc5;text-align:center;">RW</th>
            <th style="background:#4aacc5;text-align:center;width:200px">KELURAHAN</th>
            <th style="background:#4aacc5;text-align:center;width:200px">KECAMATAN</th>
            <th style="background:#4aacc5;text-align:center;width:200px">WILAYAH</th>
            <th style="background:#8064a1;text-align:center;width:200px">TIPE KASUS</th>
            <th style="background:#8064a1;text-align:center;width:200px">TIPE PERMASALAHAN</th>
            <th style="background:#8064a1;text-align:center;width:200px">KATEGORI KASUS</th>
            <th style="background:#8064a1;text-align:center;width:200px">JENIS KASUS</th>
            <th style="background:#8064a1;text-align:center;width:300px">URAIAN SINGKAT
                PERMASALAHAN</th>
            <th style="background:#8064a1;text-align:center;width:200px">LOKASI KASUS</th>
            <th style="background:#8064a1;text-align:center;width:200px">TANGGAL DAN JAM KEJADIAN
            </th>
            <th style="background:#1e477b;text-align:center;width:200px">KEPEMILIKAN BPJS</th>
            <th style="background:#1e477b;text-align:center;width:200px">TANGGAL DAN JAM PENGADUAN
            </th>
            <th style="background:#1e477b;text-align:center;width:200px">TANGGAL DAN JAM PENANGANAN
                AWAL
            </th>
            <th style="background:#1e477b;text-align:center;width:200px">TANGGAL DAN JAM
                PENJANGKAUAN</th>
            <th style="background:#1e477b;text-align:center;width:200px">KONSELOR 1</th>
            <th style="background:#1e477b;text-align:center;width:200px">KONSELOR 2</th>
            <th style="background:#1e477b;text-align:center;width:200px">SUMBER PENGADUAN</th>
            <th style="background:#d99491;text-align:center;width:200px">DURASI PENANGANAN</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data ?? [] as $key => $context)
        <tr>
            <td class="text-center">{{$key + 1}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->no_registrasi ?? ''}}
            </td>
            <td style="text-align:center;">{{$context->identitas_klien->nama ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->inisial ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nik . '‎' ?? ''}} </td>
            <td style="text-align:center;">{{$context->identitas_klien->no_kk . '‎' ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->l_p ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->pendidikan ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->kelas ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->jurusan ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->tahun_lulus ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->instansi ?? ''}}
            </td>
            <td style="text-align:center;">{{$context->identitas_klien->pekerjaan ?? ''}}</td>
            <td style="text-align:center;">
                {{$context->identitas_klien->penghasilan_perbulan ?? ''}}
            </td>
            <td style="text-align:center;">{{$context->identitas_klien->agama ?? ''}}</td>
            <td style="text-align:center;">
                {{$context->identitas_klien->status_perkawinan ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->tempat_lahir ?? ''}}
            </td>
            <td style="text-align:center;">{{$context->identitas_klien->tanggal_lahir ?? ''}}
            </td>
            <td style="text-align:center;">{{$context->identitas_klien->usia ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->kategori ?? ''}}
            </td>
            <td style="text-align:center;">{{$context->identitas_klien->jenis ?? ''}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->no_telepon ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->alamat ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->rt ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->rw ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->kelurahan ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->kecamatan ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_kk->wilayah ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->alamat ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->rt ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->rw ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->kelurahan ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->kecamatan ?? ''}}</td>
            <td style="text-align:center;">{{$context->alamat_domisili->wilayah ?? ''}}</td>
            <td style="text-align:center;">{{$context->detail_kasus->tipe_kasus ?? ''}}</td>
            <td style="text-align:center;">{{$context->detail_kasus->tipe_permasalahan ?? ''}}</td>
            <td style="text-align:center;">{{$context->detail_kasus->kategori_kasus ?? ''}}</td>
            <td style="text-align:center;">{{$context->detail_kasus->jenis_kasus ?? ''}}</td>
            <td style="text-align:center;">{{$context->detail_kasus->uraian ?? ''}}</td>
            <td style="text-align:center;">{{$context->detail_kasus->lokasi ?? '' }}</td>
            <td style="text-align:center;">{{$context->detail_kasus->tanggal_dan_jam ?? ''}}</td>
            <td style="text-align:center;">{{$context->lainnya->kepemilikan_bpjs ?? ''}}</td>
            <td style="text-align:center;">{{$context->lainnya->tanggal_dan_jam_pengaduan ?? ''}}</td>
            <td style="text-align:center;">{{$context->lainnya->tanggal_dan_jam_penanganan ?? ''}}
            </td>
            <td style="text-align:center;">{{$context->lainnya->tanggal_dan_jam_penjangkauan ?? ''}}
            </td>
            <td style="text-align:center;">
                {{$context->lainnya->konselor_1->name ?? ''}}
            </td>
            <td style="text-align:center;">
                {{$context->lainnya->konselor_2->name ?? ''}}
            </td>
            <td style="text-align:center;">{{$context->lainnya->sumber_pengaduan ?? ''}}</td>
            <td style="text-align:center;">{{$context->durasi ?? ''}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
