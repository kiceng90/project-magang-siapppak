<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Buku Tamu - {{ $bukuTamu->nomor_pendaftaran }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .box-container-print {
            width: 100%;
        }

        .header {
            border-bottom: 4px black solid;
            padding-bottom: 25px;
            margin-bottom: 20px;
            text-align: center;
        }

        .header-content {
            display: inline-block;
            text-align: center;
        }

        .header-logo {
            width: 80px;
            float: left;
            margin-right: 25px;
        }

        .header-text {
            display: inline-block;
            text-align: center;
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
        }

        .table-print {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        .table-print td,
        .table-print th {
            border: 1px solid #000;
            padding: 7.5px;
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

        .signature {
            width: 300px;
            margin-left: auto;
            margin-right: 50px;
            text-align: center;
            font-size: 15px;
            margin-top: 30px;
        }

        .signature-name {
            text-decoration: underline;
            padding-top: 80px;
        }

        .mb-3 {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="box-container-print">
        <div class="header">
            <div class="header-content">
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
        </div>

        <table class="table-print">
            <tbody>
                <tr>
                    <td colspan="3">
                        NOMOR PENDAFTARAN :
                        <b>{{ $layanan->nomor_pendaftaran }}</b>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">PENERIMAAN</td>
                    <td width="20%">HARI</td>
                    <td>{{ app()->make('App\Http\Controllers\API\BukuTamuController')->getHari($layanan->tgl_penerimaan) }}
                    </td>
                </tr>
                <tr>
                    <td width="30%">TANGGAL</td>
                    <td>{{ app()->make('App\Http\Controllers\API\BukuTamuController')->getTanggal($layanan->tgl_penerimaan) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table-print">
            <tbody>
                @if ($layanan->rujukan_id != null)
                    <tr>
                        <td colspan="3" style="text-align: center">
                            <b>SURAT RUJUKAN PUSPAGA</b>
                            <p style="margin: 5px 0; font-weight: bold">
                                KEPADA LEMBAGA/INSTANSI LAYANAN (mengambil
                                dari Tujuan Lembaga Rujukan)
                            </p>
                            <div
                                style="
                                        margin-top: 10px;
                                        text-align: justify;
                                    ">
                                <p>
                                    PUSPAGA adalah singkatan dari Pusat
                                    Pembelajaran Keluarga, sebuah lembaga
                                    yang menyediakan beragam layanan untuk
                                    meningkatkan kualitas keluarga dalam
                                    mewujudkan kesetaraan gender dan hak
                                    anak. Layanan ini diberikan dalam
                                    prinsip satu pintu secara holistik dan
                                    integratif. PUSPAGA kami berdiri di
                                    tingkat Kota Surabaya sejak tahun 2017.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif

                <tr>
                    <td colspan="3"><b>DATA PENGUNJUNG</b></td>
                </tr>
                <tr>
                    <td width="30%">Nama Lengkap</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->nama }}</td>
                </tr>
                <tr>
                    <td width="30%">NIK</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->nik }}</td>
                </tr>
                <tr>
                    <td width="30%">Tempat/Tanggal Lahir</td>
                    <td width="4%" class="text-center">:</td>
                    <td>
                        {{ $layanan->tempat_lahir }},
                        {{ app()->make('App\Http\Controllers\API\BukuTamuController')->getTanggal($layanan->tanggal_lahir) }}
                    </td>
                </tr>
                <tr>
                    <td width="30%">Usia</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->usia }}</td>
                </tr>
                <tr>
                    <td width="30%">Agama</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->agama }}</td>
                </tr>
                <tr>
                    <td width="30%">Kewarganegaraan</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->kewarganegaraan }}</td>
                </tr>
                <tr>
                    <td width="30%">Status Perkawinan</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->status_perkawinan }}</td>
                </tr>
                <tr>
                    <td width="30%">Alamat</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->alamat_ktp }}</td>
                </tr>
                <tr>
                    <td width="30%">RT/RW</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->rt_ktp }}/{{ $layanan->rw_ktp }}</td>
                </tr>
                <tr>
                    <td width="30%">Kelurahan/Desa</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->kel_desa_ktp }}</td>
                </tr>
                <tr>
                    <td width="30%">Kecamatan</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->kecamatan_ktp }}</td>
                </tr>
                <tr>
                    <td width="30%">Kabupaten/Kota</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->kota_kabupaten_ktp }}</td>
                </tr>
                <tr>
                    <td width="30%">Provinsi</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $layanan->provinsi }}</td>
                </tr>
                @if ($layanan->rujukan_id != null)
                    <tr>
                        <td colspan="3" style="text-align: center">
                            <div
                                style="
                                        margin-top: 10px;
                                        text-align: center;
                                    ">
                                <p>
                                    Demikian surat kami sampaikan. Atas bantuan dan kerjasamanya, kami ucapkan terima
                                    kasih.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Iterate through all layanan items -->
        <table class="table-print">
            <tbody>
                @foreach ($layananList as $index => $layanan)
                    <tr>
                        <td colspan="3"><b>KEBUTUHAN LAYANAN</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Jenis Layanan</td>
                        <td width="4%" class="text-center">:</td>
                        <td>
                            {{ $layanan->name }}
                        </td>
                    </tr>
                    @if ($layanan->singkat_id != null)
                        <tr>
                            <td width="30%">Keterangan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>
                                {{ $layanan->singkat_keterangan }}
                            </td>
                        </tr>
                    @endif
                    @if ($layanan->rujukan_id != null)
                        <tr>
                            <td width="30%">Tujuan Rujukan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>
                                {{ $layanan->rujukan_tujuan }}
                            </td>
                        </tr>
                    @endif
                    @if ($layanan->telekonsultasi_id != null)
                        <tr>
                            <td width="30%">Nomor Telepon</td>
                            <td width="4%" class="text-center">:</td>
                            <td>
                                {{ $layanan->telekonsultasi_nomor }}
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Jadwal Telekonsultasi</td>
                            <td width="4%" class="text-center">:</td>
                            <td>{{ app()->make('App\Http\Controllers\API\BukuTamuController')->getJam($layanan->telekonsultasi_jadwal) }},
                                {{ app()->make('App\Http\Controllers\API\BukuTamuController')->getHari($layanan->telekonsultasi_jadwal) }},
                                {{ app()->make('App\Http\Controllers\API\BukuTamuController')->getTanggal($layanan->telekonsultasi_jadwal) }}
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Keluhan</td>
                            <td width="4%" class="text-center">:</td>
                            <td>
                                {{ $layanan->telekonsultasi_keluhan }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td width="30%">Disposisi Pimpinan</td>
                        <td width="4%" class="text-center">:</td>
                        <td>
                            {{ $layanan->disposisi
                                ? 'Warga Surabaya (Berikan layanan puspaga sesuai kebutuhan klien)'
                                : 'Warga Non Surabaya (Berikan layanan puspaga sesuai ketentuan)' }}
                        </td>
                    </tr>
                @endforeach
                </td>
            </tbody>
        </table>

        <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
            <div class="signature">
                <div>
                    Surabaya, {{ $tanggalSekarang }}
                </div>
                <div>PIMPINAN PUSPAGA,</div>
                <div class="signature-name">
                    Thussy Apriliyandari, S.E, MPSDM
                </div>
            </div>
        </div>
    </div>
</body>

</html>
