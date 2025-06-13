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
                        <b>{{ $bukuTamu->nomor_pendaftaran }}</b>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">PENERIMAAN</td>
                    <td width="20%">HARI</td>
                    <td>{{ app()->make('App\Http\Controllers\API\BukuTamuController')->getHari($bukuTamu->created_at) }}
                    </td>
                </tr>
                <tr>
                    <td width="30%">TANGGAL</td>
                    <td>{{ app()->make('App\Http\Controllers\API\BukuTamuController')->getTanggal($bukuTamu->created_at) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table-print">
            <tbody>
                <tr>
                    <td colspan="3"><b>DATA PENGUNJUNG</b></td>
                </tr>
                <tr>
                    <td width="30%">Nama Lengkap</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->nama }}</td>
                </tr>
                <tr>
                    <td width="30%">NIK</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->nik }}</td>
                </tr>
                <tr>
                    <td width="30%">Tempat/Tanggal Lahir</td>
                    <td width="4%" class="text-center">:</td>
                    <td>
                        {{ $bukuTamu->tempat_lahir }},
                        {{ app()->make('App\Http\Controllers\API\BukuTamuController')->getTanggal($bukuTamu->tanggal_lahir) }}
                    </td>
                </tr>
                <tr>
                    <td width="30%">Agama</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->agama }}</td>
                </tr>
                <tr>
                    <td width="30%">Kewarganegaraan</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->kewarganegaraan }}</td>
                </tr>
                <tr>
                    <td width="30%">Status Perkawinan</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->status_perkawinan }}</td>
                </tr>
                <tr>
                    <td width="30%">Alamat</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->alamat_ktp }}</td>
                </tr>
                <tr>
                    <td width="30%">RT/RW</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->rt_ktp }}/{{ $bukuTamu->rw_ktp }}</td>
                </tr>
                <tr>
                    <td width="30%">Kelurahan/Desa</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->kel_desa_ktp }}</td>
                </tr>
                <tr>
                    <td width="30%">Kecamatan</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->kecamatan_ktp }}</td>
                </tr>
                <tr>
                    <td width="30%">Kabupaten/Kota</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->kota_kabupaten_ktp }}</td>
                </tr>
                <tr>
                    <td width="30%">Provinsi</td>
                    <td width="4%" class="text-center">:</td>
                    <td>{{ $bukuTamu->provinsi }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table-print">
            <tbody>
                <tr>
                    <td colspan="3"><b>KEBUTUHAN LAYANAN</b></td>
                </tr>
                <tr>
                    <td width="30%">Layanan</td>
                    <td width="4%" class="text-center">:</td>
                    <td>
                        @if ($bukuTamu->MKebutuhanLayanan->count() > 0)
                            @foreach ($bukuTamu->MKebutuhanLayanan as $index => $item)
                                <div class="mb-3">{{ $index + 1 }}. {{ $item->name }}</div>
                            @endforeach
                        @endif

                    </td>
                </tr>
                <tr>
                    <td width="30%">Disposisi Pimpinan</td>
                    <td width="4%" class="text-center">:</td>
                    <td>
                        {{ $bukuTamu->disposisi ? 'Segera Tindaklanjuti' : 'Segera Tindaklanjut Dengan Ketentuan' }}
                    </td>
                </tr>
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
