    <style>
    body {
        font-family: arial;
    }

    .table-print {
        width: 100%;
    }

    .table-print tr td {
        padding: 7.5px;
        font-size: 15PX;
        page-break-inside: avoid;
    }

    .table-print tr {
        page-break-inside: avoid;
        page-break-after: auto
    }

    .page-break {
        page-break-after: always;
    }
</style>
<div style="font-family:arial;">
    <div style="background:#fff !important">
        <div style="border-bottom:4px black solid;padding-bottom:25px;margin-bottom:20px;">
            <table cellspacing="0" style="margin:auto;">
                <tbody>
                    <tr>
                        <td>
                            <img src="{{ public_path('assets/extends/img/pemkot-surabaya-hitam-putih.jpg') }}"
                                style="width:80px" />
                        </td>
                        <td style="text-align:center;">
                            <div style="padding-left:25px;">
                                <div style="font-size:18px;font-weight:700">PEMERINTAH KOTA SURABAYA</div>
                                <div style="font-size:18px;font-weight:700">DINAS PEMBERDAYAAN PEREMPUAN
                                    DAN<br>PERLINDUNGAN
                                    ANAK SERTA PENGENDALIAN<br>PENDUDUK DAN KELUARGA BERENCANA</div>
                                <div>Jalan Kedungsari No. 18 Surabaya</div>
                                <div>Telp. (031) 5346317 Fax. (031) 5480904</div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table cellspacing="0" class="table-print table-bordered">
            <tbody>
                <tr>
                    <td colspan="6" style="border: 1px solid">NOMOR REGISTER : {{ $data->nomor_registrasi }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid;" rowspan="4">PENGADUAN</td>
                    <td style="border: 1px solid">HARI</td>
                    <td style="border: 1px solid">{{ $data->pengaduan->hari }}</td>
                    <td style="border: 1px solid;" rowspan="2">PETUGAS 1</td>
                    <td style="border: 1px solid">NAMA</td>
                    <td style="border: 1px solid">{{ count($data->petugas ?? []) > 0 ? $data->petugas[0]->nama : '' }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid">TANGGAL</td>
                    <td style="border: 1px solid">{{ $data->pengaduan->tanggal }}</td>
                    <td style="border: 1px solid">NO HP</td>
                    <td style="border: 1px solid">{{ count($data->petugas ?? []) > 0 ? $data->petugas[0]->no_hp : '' }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid">WAKTU</td>
                    <td style="border: 1px solid">{{ $data->pengaduan->waktu }}</td>
                    <td style="border: 1px solid;" rowspan="2">PETUGAS 2</td>
                    <td style="border: 1px solid">NAMA</td>
                    <td style="border: 1px solid">{{ count($data->petugas ?? []) > 1 ? $data->petugas[1]->nama : '' }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid">SUMBER ADUAN</td>
                    <td style="border: 1px solid">{{ $data->pengaduan->sumber_aduan }}</td>
                    <td style="border: 1px solid">NO HP</td>
                    <td style="border: 1px solid">{{ count($data->petugas ?? []) > 1 ? $data->petugas[1]->no_hp : '' }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid;" rowspan="3">PENANGANAN AWAL</td>
                    <td style="border: 1px solid">HARI</td>
                    <td style="border: 1px solid">{{ $data->penanganan_awal->hari }}</td>
                    <td style="border: 1px solid;" rowspan="3">TANGGAL PENJANGKAUAN / KONSELING
                    </td>
                    <td style="border: 1px solid">HARI</td>
                    <td style="border: 1px solid">{{ $data->tanggal_penjangkauan->hari }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid">TANGGAL</td>
                    <td style="border: 1px solid">{{ $data->penanganan_awal->tanggal }}</td>
                    <td style="border: 1px solid">TANGGAL</td>
                    <td style="border: 1px solid">{{ $data->tanggal_penjangkauan->tanggal }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid">WAKTU</td>
                    <td style="border: 1px solid">{{ $data->penanganan_awal->waktu }}</td>
                    <td style="border: 1px solid">WAKTU</td>
                    <td style="border: 1px solid">{{ $data->tanggal_penjangkauan->waktu }}</td>
                </tr>
            </tbody>
        </table>
        @if ($data->data_pelapor || $data->data_klien || count($data->data_keluarga_klien ?? []) > 0)
            <table cellspacing="0" class="table-print table-bordered" style="margin-top:25px">
                <tbody>
                    @if ($data->data_pelapor)
                        <tr>
                            <td style="border: 1px solid" colspan="3"><b>DATA PELAPOR</b></td>
                        </tr>
                        @if ($data->data_pelapor->nama_lengkap)
                            <tr>
                                <td style="border: 1px solid" width="30%">Nama Lengkap</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_pelapor->nama_lengkap ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_pelapor->nik)
                            <tr>
                                <td style="border: 1px solid" width="30%">NIK</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_pelapor->nik ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_pelapor->alamat_domisili)
                            <tr>
                                <td style="border: 1px solid" width="30%">Alamat Domisili</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_pelapor->alamat_domisili ?? '' }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td style="border: 1px solid" width="30%">Kabupaten/Kota</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelapor->kabupaten ?? 'Surabaya' }}
                            </td>
                        </tr>
                        @if ($data->data_pelapor->no_telepon)
                            <tr>
                                <td style="border: 1px solid" width="30%">No. Telepon</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_pelapor->no_telepon ?? '' }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td style="border: 1px solid" colspan="3">&ensp;</td>
                        </tr>
                    @endif
                    @if ($data->data_klien)
                        <tr>
                            <td style="border: 1px solid" colspan="3"><b>DATA KLIEN</b></td>
                        </tr>
                        @if ($data->data_klien->nama_lengkap)
                            <tr>
                                <td style="border: 1px solid" width="30%">Nama Lengkap</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->nama_lengkap ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->nik)
                            <tr>
                                <td style="border: 1px solid" width="30%">NIK</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->nik ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->no_kk)
                            <tr>
                                <td style="border: 1px solid" width="30%">No. KK</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->no_kk ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->ttl)
                            <tr>
                                <td style="border: 1px solid" width="30%">TTL</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->ttl ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->usia)
                            <tr>
                                <td style="border: 1px solid" width="30%">Usia</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->usia ?? '-' }} Tahun</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->jenis_kelamin)
                            <tr>
                                <td style="border: 1px solid" width="30%">Jenis Kelamin</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->jenis_kelamin ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->agama)
                            <tr>
                                <td style="border: 1px solid" width="30%">Agama</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->agama ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->pendidikan_terakhir)
                            <tr>
                                <td style="border: 1px solid" width="30%">Pendidikan Terakhir</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->pendidikan_terakhir ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->pekerjaan)
                            <tr>
                                <td style="border: 1px solid" width="30%">Pekerjaan</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->pekerjaan ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->status_pernikahan)
                            <tr>
                                <td style="border: 1px solid" width="30%">Status Pernikahan</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->status_pernikahan ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->status_pernikahan)
                            <tr>
                                <td style="border: 1px solid" width="30%">Alamat KK</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->alamat_kk ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->alamat_domisili)
                            <tr>
                                <td style="border: 1px solid" width="30%">Alamat Domisili</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->alamat_domisili ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($data->data_klien->no_telepon)
                            <tr>
                                <td style="border: 1px solid" width="30%">No. Telepon</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $data->data_klien->no_telepon ?? '' }}</td>
                            </tr>
                        @endif
                    @endif

                    @if (count($data->data_keluarga_klien ?? []) > 0)
                        <tr>
                            <td style="border: 1px solid" colspan="3">&ensp;</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid" colspan="3"><b>DATA KELUARGA KLIEN</b></td>
                        </tr>
                    @endif
                    @foreach ($data->data_keluarga_klien ?? [] as $key => $value)
                        @if ($value->nama_lengkap)
                            <tr>
                                <td style="border: 1px solid" width="30%">Nama Lengkap</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $value->nama_lengkap ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($value->nik)
                            <tr>
                                <td style="border: 1px solid" width="30%">NIK</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $value->nik ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($value->alamat_kk)
                            <tr>
                                <td style="border: 1px solid" width="30%">Alamat KK</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $value->alamat_kk ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($value->alamat_domisili)
                            <tr>
                                <td style="border: 1px solid" width="30%">Alamat Domisili</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $value->alamat_domisili ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($value->pekerjaan)
                            <tr>
                                <td style="border: 1px solid" width="30%">Pekerjaan</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $value->pekerjaan ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($value->hubungan_dengan_klien)
                            <tr>
                                <td style="border: 1px solid" width="30%">Hubungan Dengan Klien</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $value->hubungan_dengan_klien ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($value->no_telepon)
                            <tr>
                                <td style="border: 1px solid" width="30%">No. Telepon</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $value->no_telepon ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($key != count($data->data_keluarga_klien ?? []) - 1)
                            <tr>
                                <td style="border: 1px solid" colspan="3">&ensp;</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif
        @if ($data->data_pelaku)
            <table cellspacing="0" class="table-print table-bordered" style="margin-top:25px">
                <tbody>
                    <tr>
                        <td style="border: 1px solid" colspan="3"><b>DATA PELAKU</b></td>
                    </tr>
                    @if ($data->data_pelaku->nama_lengkap)
                        <tr>
                            <td style="border: 1px solid" width="30%">Nama Lengkap</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->nama_lengkap ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->nik)
                        <tr>
                            <td style="border: 1px solid" width="30%">NIK</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->nik ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->no_kk)
                        <tr>
                            <td style="border: 1px solid" width="30%">No. KK</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->no_kk ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->ttl)
                        <tr>
                            <td style="border: 1px solid" width="30%">TTL</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->ttl ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->usia)
                        <tr>
                            <td style="border: 1px solid" width="30%">Usia</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->usia ?? '-' }} Tahun</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->jenis_kelamin)
                        <tr>
                            <td style="border: 1px solid" width="30%">Jenis Kelamin</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->jenis_kelamin ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->agama)
                        <tr>
                            <td style="border: 1px solid" width="30%">Agama</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->agama ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->pendidikan_terakhir)
                        <tr>
                            <td style="border: 1px solid" width="30%">Pendidikan Terakhir</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->pendidikan_terakhir ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->pekerjaan)
                        <tr>
                            <td style="border: 1px solid" width="30%">Pekerjaan</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->pekerjaan ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->status_pernikahan)
                        <tr>
                            <td style="border: 1px solid" width="30%">Status Pernikahan</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->status_pernikahan ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->alamat_kk)
                        <tr>
                            <td style="border: 1px solid" width="30%">Alamat KK</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->alamat_kk ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->alamat_domisili)
                        <tr>
                            <td style="border: 1px solid" width="30%">Alamat Domisili</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->alamat_domisili ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->kewarganegaraan)
                        <tr>
                            <td style="border: 1px solid" width="30%">Kewarganegaraan</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->kewarganegaraan ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->nomor_telepon)
                        <tr>
                            <td style="border: 1px solid" width="30%">Nomor Telepon</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->nomor_telepon ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_pelaku->hubungan_pelaku)
                        <tr>
                            <td style="border: 1px solid" width="30%">Hubungan Pelaku dengan Klien</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_pelaku->hubungan_pelaku ?? '' }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif
        @if (
            ($data->data_kasus->jenis_klien ?? '') ||
                ($data->data_kasus->kategori_klien ?? '') ||
                ($data->data_kasus->tipe_permasalahan ?? '') ||
                ($data->data_kasus->kategori_kasus ?? '') ||
                ($data->data_kasus->jenis_kasus ?? '') ||
                ($data->data_kasus->deskripsi ?? '') ||
                ($data->data_kasus->lokasi_kejadian ?? '') ||
                ($data->data_kasus->tanggal_dan_waktu ?? ''))
            <table cellspacing="0" class="table-print table-bordered" style="margin-top:25px">
                <tbody>
                    <tr>
                        <td style="border: 1px solid" colspan="3"><b>DATA KASUS</b></td>
                    </tr>
                    @if ($data->data_kasus->jenis_klien ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Jenis Klien</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_kasus->jenis_klien ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_kasus->kategori_klien ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Kategori Klien</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_kasus->kategori_klien ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_kasus->tipe_permasalahan ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Tipe Permasalahan</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_kasus->tipe_permasalahan ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_kasus->kategori_kasus ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Kategori Kasus</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_kasus->kategori_kasus ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_kasus->jenis_kasus ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Jenis Kasus</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_kasus->jenis_kasus ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_kasus->deskripsi ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Deskripsi Singkat Kasus</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_kasus->deskripsi ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_kasus->lokasi_kejadian ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Lokasi Kejadian</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_kasus->lokasi_kejadian ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->data_kasus->tanggal_dan_waktu ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Tanggal dan Waktu Kejadian</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->data_kasus->tanggal_dan_waktu ?? '' }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif
        @if ($data->situasi_keluarga || $data->kronologis_kejadian || $data->harapan_klien)
            <table cellspacing="0" class="table-print table-bordered" style="margin-top:25px">
                <tbody>
                    @if ($data->situasi_keluarga)
                        <tr>
                            <td style="border: 1px solid" colspan="3"><b>SITUASI KELUARGA</b></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid" colspan="3">
                                <div style="min-height:150px">{!! $data->situasi_keluarga ?? '' !!}</div>
                            </td>
                        </tr>
                    @endif
                    @if ($data->kronologis_kejadian)
                        <tr>
                            <td style="border: 1px solid" colspan="3"><b>KRONOLOGI KEJADIAN</b></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid" colspan="3">
                                <div style="min-height:150px">{!! $data->kronologis_kejadian ?? '' !!}</div>
                            </td>
                        </tr>
                    @endif
                    @if ($data->harapan_klien)
                        <tr>
                            <td style="border: 1px solid" colspan="3"><b>HARAPAN KLIEN DAN KELUARGA</b></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid" colspan="3">
                                <div style="min-height:150px">{!! $data->harapan_klien ?? '' !!}</div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif
        @if (
            ($data->kondisi_klien->fisik ?? '') ||
                ($data->kondisi_klien->psikologis ?? '') ||
                ($data->kondisi_klien->sosial ?? '') ||
                ($data->kondisi_klien->spiritual ?? '') ||
                count($data->rencana_analisis ?? []) > 0 ||
                count($data->rencana_rujukan ?? []) > 0)
            <table cellspacing="0" class="table-print table-bordered" style="margin-top:25px">
                <tbody>
                    <tr>
                        <td style="border: 1px solid" colspan="3"><b>KONDISI KLIEN</b></td>
                    </tr>
                    @if ($data->kondisi_klien->fisik ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Fisik</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->kondisi_klien->fisik ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->kondisi_klien->psikologis ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Psikologis</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->kondisi_klien->psikologis ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->kondisi_klien->sosial ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Sosial</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->kondisi_klien->sosial ?? '' }}</td>
                        </tr>
                    @endif
                    @if ($data->kondisi_klien->spiritual ?? '')
                        <tr>
                            <td style="border: 1px solid" width="30%">Spiritual</td>
                            <td style="border: 1px solid" width="4%" class="text-center">:</td>
                            <td style="border: 1px solid">{{ $data->kondisi_klien->spiritual ?? '' }}</td>
                        </tr>
                    @endif
                    @if (
                        ($data->kondisi_klien->spiritual ?? '') ||
                            ($data->kondisi_klien->sosial ?? '') ||
                            ($data->kondisi_klien->psikologis ?? '') ||
                            ($data->kondisi_klien->fisik ?? ''))
                        <tr>
                            <td style="border: 1px solid" colspan="3">&ensp;</td>
                        </tr>
                    @endif
                    @if (count($data->rencana_analisis ?? []) > 0)
                        <tr>
                            <td style="border: 1px solid" colspan="3"><b>RENCANA ANALISIS KEBUTUHAN KLIEN OLEH
                                    DP3KAPPKB</b>
                            </td>
                        </tr>
                        @foreach ($data->rencana_analisis ?? [] as $key => $value)
                            <tr>
                                <td style="border: 1px solid" width="30%">{{ $value->name ?? '' }}</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $value->deskripsi ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endif
                    @if (count($data->rencana_rujukan ?? []) > 0)
                        <tr>
                            <td style="border: 1px solid" colspan="3">&ensp;</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid" colspan="3"><b>RENCANA RUJUKAN KEBUTUHAN KLIEN</b></td>
                        </tr>
                        @foreach ($data->rencana_rujukan ?? [] as $key => $value)
                            <tr>
                                <td style="border: 1px solid" width="30%">{{ $value->name ?? '' }}</td>
                                <td style="border: 1px solid" width="4%" class="text-center">:</td>
                                <td style="border: 1px solid">{{ $value->deskripsi ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endif
        @if (count($data->langkah_dilakukan_dp3appkb ?? []) > 0)
            <table cellspacing="0" class="table-print table-bordered" style="margin-top:25px">
                <tbody>
                    <tr>
                        <td style="border: 1px solid" colspan="3"><b>LANGKAH YANG TELAH DILAKUKAN DP3APPKB</b></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid;text-align:center;">Tanggal Pelayanan</td>
                        <td style="border: 1px solid;text-align:center;">Pelayanan Yang Diberikan</td>
                        <td style="border: 1px solid;text-align:center;">Deskripsi Pelayanan</td>
                    </tr>
                    @foreach ($data->langkah_dilakukan_dp3appkb ?? [] as $key => $value)
                        <tr>
                            <td style="border: 1px solid">{{ $value->tanggal_pelayanan ?? '' }}</td>
                            <td style="border: 1px solid">{{ $value->pelayanan_diberikan ?? '' }}</td>
                            <td style="border: 1px solid">{!! $value->deskripsi ?? '' !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if (count($data->langkah_dilakukan ?? []) > 0)
            <table cellspacing="0" class="table-print table-bordered" style="margin-top:25px;margin-bottom:50px;">
                <tbody>
                    <tr>
                        <td style="border: 1px solid" colspan="4"><b>LANGKAH YANG TELAH DILAKUKAN</b></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid;text-align:center;">Tanggal Pelayanan</td>
                        <td style="border: 1px solid;text-align:center;">Instansi</td>
                        <td style="border: 1px solid;text-align:center;">Pelayanan Yang Diberikan</td>
                        <td style="border: 1px solid;text-align:center;">Deskripsi Pelayanan</td>
                    </tr>
                    @foreach ($data->langkah_dilakukan ?? [] as $key => $value)
                        <tr>
                            <td style="border: 1px solid">{{ $value->tanggal_pelayanan ?? '' }}</td>
                            <td style="border: 1px solid">{{ $value->instansi ?? '' }}</td>
                            <td style="border: 1px solid">{{ $value->pelayanan_diberikan ?? '' }}</td>
                            <td style="border: 1px solid">{{ $value->deskripsi ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div style="width:100%;height:30px"></div>
        <div style="float:right;page-break-inside: avoid;page-break-after: auto">
            <div style="width:300px;margin-right:50px;text-align:center;font-size:15px;">
                <div>Surabaya, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div>KEPALA DINAS,</div>
                <div style="text-decoration:underline;padding-top:90px">Dra. IDA WIDAYATI</div>
                <div>Pembina Tk. I</div>
                <div>NIP 196809081996022002</div>
            </div>
        </div>

        @if (count($data->dokumen_pendukung->foto_klien ?? []) > 0 ||
                count($data->dokumen_pendukung->foto_identitas_klien ?? []) > 0 ||
                count($data->dokumen_pendukung->foto_tempat_tinggal_klien ?? []) > 0 ||
                count($data->dokumen_pendukung->foto_pendampingan_awal_klien ?? []) > 0 ||
                count($data->dokumen_pendukung->foto_pendampingan_lanjutan_klien ?? []) > 0 ||
                count($data->dokumen_pendukung->foto_pendampingan_monitoring_klien ?? []) > 0)
            <div class="page-break"></div>
            <div style="font-size:15px"><b>Dokumen Pendukung</b></div>
            <table cellspacing="0" class="table-print table-bordered" style="margin-top:25px">
                <tbody>
                    @if (count($data->dokumen_pendukung->foto_klien ?? []) > 0)
                        <tr>
                            <td style="border: 1px solid" colspan="3">
                                <div style="padding-bottom:5px"><b>Foto Klien</b></div>
                                <table>
                                    <tbody>
                                        @foreach ($data->dokumen_pendukung->foto_klien ?? [] as $key => $value)
                                            @if (!(($key + 1) % 2 == 0))
                                                <tr>
                                                    <td style="width:50%;padding:15px;text-align:center">
                                                        <img src="{{ storage_path('app/' . $value->path) }}"
                                                            style="height:160px;width:90%;display:block;margin:auto" />
                                                        <div style="width:100%;padding-top:15px;text-align:center">
                                                            {{ $value->path }}</div>
                                                    </td>
                                                @else
                                                    <td style="width:50%;padding:15px;text-align:center">
                                                        <img src="{{ storage_path('app/' . $value->path) }}"
                                                            style="height:160px;width:90%;display:block;margin:auto" />
                                                        <div style="width:100%;padding-top:15px;text-align:center">
                                                            {{ $value->path }}</div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @if (
                                            !(count($data->dokumen_pendukung->foto_klien ?? []) % 2 == 0) &&
                                                count($data->dokumen_pendukung->foto_klien ?? []) > 0)
                        </tr>
                    @endif
                </tbody>
            </table>
            </td>
            </tr>
        @endif
        @if (count($data->dokumen_pendukung->foto_identitas_klien ?? []) > 0)
            <tr>
                <td style="border: 1px solid" colspan="3">
                    <div style="padding-bottom:5px"><b>Foto Identitas Klien(KK)</b></div>
                    <table>
                        <tbody>
                            @foreach ($data->dokumen_pendukung->foto_identitas_klien ?? [] as $key => $value)
                                @if (!(($key + 1) % 2 == 0))
                                    <tr>
                                        <td style="width:50%;padding:15px;text-align:center">
                                            <img src="{{ storage_path('app/' . $value->path) }}"
                                                style="height:160px;width:90%;display:block;margin:auto" />
                                            <div style="width:100%;padding-top:15px;text-align:center">
                                                {{ $value->name }}</div>
                                        </td>
                                    @else
                                        <td style="width:50%;padding:15px;text-align:center">
                                            <img src="{{ storage_path('app/' . $value->path) }}"
                                                style="height:160px;width:90%;display:block;margin:auto" />
                                            <div style="width:100%;padding-top:15px;text-align:center">
                                                {{ $value->name }}</div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if (
                                !(count($data->dokumen_pendukung->foto_identitas_klien ?? []) % 2 == 0) &&
                                    count($data->dokumen_pendukung->foto_identitas_klien ?? []) > 0)
            </tr>
        @endif
        </tbody>
        </table>
        </td>
        </tr>
        @endif
        @if (count($data->dokumen_pendukung->foto_tempat_tinggal_klien ?? []) > 0)
            <tr>
                <td style="border: 1px solid" colspan="3">
                    <div style="padding-bottom:5px"><b>Foto Tempat Tinggal Klien</b></div>
                    <table>
                        <tbody>
                            @foreach ($data->dokumen_pendukung->foto_tempat_tinggal_klien ?? [] as $key => $value)
                                @if (!(($key + 1) % 2 == 0))
                                    <tr>
                                        <td style="width:50%;padding:15px;text-align:center">
                                            <img src="{{ storage_path('app/' . $value->path) }}"
                                                style="height:160px;width:90%;display:block;margin:auto" />
                                            <div style="width:100%;padding-top:15px;text-align:center">
                                                {{ $value->name }}</div>
                                        </td>
                                    @else
                                        <td style="width:50%;padding:15px;text-align:center">
                                            <img src="{{ storage_path('app/' . $value->path) }}"
                                                style="height:160px;width:90%;display:block;margin:auto" />
                                            <div style="width:100%;padding-top:15px;text-align:center">
                                                {{ $value->name }}</div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if (
                                !(count($data->dokumen_pendukung->foto_tempat_tinggal_klien ?? []) % 2 == 0) &&
                                    count($data->dokumen_pendukung->foto_tempat_tinggal_klien ?? []) > 0)
            </tr>
        @endif
        </tbody>
        </table>
        </td>
        </tr>
        @endif
        @if (count($data->dokumen_pendukung->foto_pendampingan_awal_klien ?? []) > 0 ||
                count($data->dokumen_pendukung->foto_pendampingan_lanjutan_klien ?? []) > 0 ||
                count($data->dokumen_pendukung->foto_pendampingan_monitoring_klien ?? []) > 0)
            <tr>
                <td style="border: 1px solid" colspan="3"><b>Foto Pendampingan :</b></td>
            </tr>
            @if (count($data->dokumen_pendukung->foto_pendampingan_awal_klien ?? []) > 0)
                <tr>
                    <td style="border: 1px solid" colspan="3">
                        <div style="padding-bottom:5px; "><b>1. Pendampingan Awal(Penjangkauan)</b></div>
                        <table>
                            <tbody>
<<<<<<< Updated upstream
                                @foreach($data->dokumen_pendukung->foto_klien ?? [] as $key => $value)
                                @if(!(($key + 1) % 2 == 0))
                                <tr>
                                    {{-- <td style="width:50%;padding:15px;text-align:center">
                                        <img src="{{storage_path('app/'.$value->path)}}" style="height:160px;width:90%;display:block;margin:auto" />
                                        <div style="width:100%;padding-top:15px;text-align:center">{{$value->path}}</div>
                                    </td> --}}
                                    <td style="width:50%;padding:15px;text-align:center">
                                        <img src="{{storage_path('app/'.$value->path)}}" 
                                             style="max-height:160px; max-width:90%; height:auto; width:auto; display:block; margin:auto" />
                                        <div style="width:100%;padding-top:15px;text-align:center">{{$value->path}}</div>
                                    </td>
                                    
                                    @else
                                    {{-- <td style="width:50%;padding:15px;text-align:center">
                                        <img src="{{storage_path('app/'.$value->path)}}" style="height:160px;width:90%;display:block;margin:auto" />
                                        <div style="width:100%;padding-top:15px;text-align:center">{{$value->path}}</div>
                                    </td> --}}
                                    <td style="width:50%;padding:15px;text-align:center">
                                        <img src="{{storage_path('app/'.$value->path)}}" 
                                             style="max-height:160px; max-width:90%; height:auto; width:auto; display:block; margin:auto" />
                                        <div style="width:100%;padding-top:15px;text-align:center">{{$value->path}}</div>
                                    </td>
                                    
                                </tr>
                                @endif
=======
                                @foreach ($data->dokumen_pendukung->foto_pendampingan_awal_klien ?? [] as $key => $value)
                                    @if (!(($key + 1) % 2 == 0))
                                        <tr>
                                            <td style="width:50%;padding:15px;text-align:center">
                                                <img src="{{ storage_path('app/' . $value->path) }}"
                                                    style="height:160px;width:90%;display:block;margin:auto" />
                                                <div style="width:100%;padding-top:15px;text-align:center">
                                                    {{ $value->name }}</div>
                                            </td>
                                        @else
                                            <td style="width:50%;padding:15px;text-align:center">
                                                <img src="{{ storage_path('app/' . $value->path) }}"
                                                    style="height:160px;width:90%;display:block;margin:auto" />
                                                <div style="width:100%;padding-top:15px;text-align:center">
                                                    {{ $value->name }}</div>
                                            </td>
                                        </tr>
                                    @endif
>>>>>>> Stashed changes
                                @endforeach
                                @if (
                                    !(count($data->dokumen_pendukung->foto_pendampingan_awal_klien ?? []) % 2 == 0) &&
                                        count($data->dokumen_pendukung->foto_pendampingan_awal_klien ?? []) > 0)
                </tr>
            @endif
            </tbody>
            </table>
            </td>
            </tr>
        @endif
        @if (count($data->dokumen_pendukung->foto_pendampingan_lanjutan_klien ?? []) > 0)
            <tr>
                <td style="border: 1px solid" colspan="3">
                    <div style="padding-bottom:5px; "><b>2. Pendampingan
                            Lanjutan(Psikologis/Medis/Hukum)</b></div>
                    <table>
                        <tbody>
                            @foreach ($data->dokumen_pendukung->foto_pendampingan_lanjutan_klien ?? [] as $key => $value)
                                @if (!(($key + 1) % 2 == 0))
                                    <tr>
                                        <td style="width:50%;padding:15px;text-align:center">
                                            <img src="{{ storage_path('app/' . $value->path) }}"
                                                style="height:160px;width:90%;display:block;margin:auto" />
                                            <div style="width:100%;padding-top:15px;text-align:center">
                                                {{ $value->name }}</div>
                                        </td>
                                    @else
                                        <td style="width:50%;padding:15px;text-align:center">
                                            <img src="{{ storage_path('app/' . $value->path) }}"
                                                style="height:160px;width:90%;display:block;margin:auto" />
                                            <div style="width:100%;padding-top:15px;text-align:center">
                                                {{ $value->name }}</div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if (
                                !(count($data->dokumen_pendukung->foto_pendampingan_lanjutan_klien ?? []) % 2 == 0) &&
                                    count($data->dokumen_pendukung->foto_pendampingan_lanjutan_klien ?? []) > 0)
            </tr>
        @endif
        </tbody>
        </table>
        </td>
        </tr>
        @endif
        @if (count($data->dokumen_pendukung->foto_pendampingan_monitoring_klien ?? []) > 0)
            <tr>
                <td style="border: 1px solid" colspan="3">
                    <div style="padding-bottom:5px; "><b>3. Monitoring</b></div>
                    <table>
                        <tbody>
                            @foreach ($data->dokumen_pendukung->foto_pendampingan_monitoring_klien ?? [] as $key => $value)
                                @if (!(($key + 1) % 2 == 0))
                                    <tr>
                                        <td style="width:50%;padding:15px;text-align:center">
                                            <img src="{{ storage_path('app/' . $value->path) }}"
                                                style="height:160px;width:90%;display:block;margin:auto" />
                                            <div style="width:100%;padding-top:15px;text-align:center">
                                                {{ $value->name }}</div>
                                        </td>
                                    @else
                                        <td style="width:50%;padding:15px;text-align:center">
                                            <img src="{{ storage_path('app/' . $value->path) }}"
                                                style="height:160px;width:90%;display:block;margin:auto" />
                                            <div style="width:100%;padding-top:15px;text-align:center">
                                                {{ $value->name }}</div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if (
                                !(count($data->dokumen_pendukung->foto_pendampingan_monitoring_klien ?? []) % 2 == 0) &&
                                    count($data->dokumen_pendukung->foto_pendampingan_monitoring_klien ?? []) > 0)
            </tr>
        @endif
        </tbody>
        </table>
        </td>
        </tr>
        @endif
        @endif
        </tbody>
        </table>
        @endif
    </div>
</div>
