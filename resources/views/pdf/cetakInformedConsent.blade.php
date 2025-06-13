<style>
    .header, .title {
        text-align: center;
    }
    .content {
        text-align: justify;
    }
    .h3 {
        font-size: 13px;
    }
    .h1 {
        font-size: 16px;
    }
    .h6 {
        font-size: 12px;
    }

    .title {
        margin-top: 30px;
        font-weight: bold;
    }

    .italic {
        font-style: italic; 
    }

    .identity, .content, .footer {
        margin-top: 20px;
        padding-left: 25px;
        padding-right: 25px;
    }
    .content {
        line-height: 1.625rem;
    }
    ul {
        padding-block: 0;
        list-style: none;
    }
    .td-lside {
        width: 220px;
    }
</style>

<div class="container">
    <div class="header">
        <div class="h3">PEMERINTAH KOTA SURABAYA</div>
        <div class="h1">PEMBERDAYAAN PEREMPUAN DAN</div>
        <div class="h1">PERLINDUNGAN ANAK SERTA PENGENDALIAN</div>
        <div class="h1">PENDUDUK DAN KELUARGA BERENCANA</div>
        <div class="h6">Jalan Kedungsari Nomor 18 Surabaya 60261</div>
        <div class="h6">Telepon (031) 5346317 Faksimile (031) 5480904</div>
    </div>
    <div class="title">
        <div class="h3">SURAT PERNYATAAN KLIEN</div>
        <div class="h3 italic">(INFORMED CONSENT)</div>
    </div>
    <div class="identity">
        <div>Saya yang bertanda tangan di bawah ini:</div>
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td class="td-lside">Nama</td>
                    <td>:</td>
                    <td colspan="2">{{ $data->name }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="td-lside">Tempat Tanggal Lahir</td>
                    <td>:</td>
                    <td colspan="2">-</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="td-lside">Jenis Kelamin</td>
                    <td>:</td>
                    <td colspan="2">-</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="td-lside">Pendidikan / Pekerjaan</td>
                    <td>:</td>
                    <td colspan="2">-</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="td-lside">Alamat Domisili</td>
                    <td>:</td>
                    <td colspan="2">{{ $data->address }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="td-lside"></td>
                    <td></td>
                    <td>Kel. {{ $data->nama_kelurahan }}</td>
                    <td>Kec. </td>
                </tr>
                <tr>
                    <td class="td-lside">Alamat KK</td>
                    <td>:</td>
                    <td colspan="2">{{ $data->address }}</td>
                </tr>
                <tr>
                    <td class="td-lside"></td>
                    <td></td>
                    <td>Kel. {{ $data->nama_kelurahan }}</td>
                    <td>Kec. </td>
                </tr>
                <tr>
                    <td class="td-lside">No. Telpon Klien / Wali Klien</td>
                    <td>:</td>
                    <td colspan="2">{{ $data->phone }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="td-lside">(bila klien adalah anak)</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="content">
        <div>Saya yang tersebut di atas menyatakan SETUJU dan BERSEDIA mendapatkan pelayanan dari Tim Perlindungan Perempuan dan Anak (DP3APPKB) Kota Surabaya sebagai klien. Apabila ada permasalahan di kemudian hari, saya tidak akan melakukan tuntutan dalam bentuk apapun ke pihak Tim Perlindungan Perempuan dan Anak DP3APPKB Kota Surabaya.</div>
        <div>Selama mendapatkan layanan ini, saya menyadari, memahami, menerima dan menyatakan bahwa:</div>
        <ul>
            <li>1. Bersedia terlibat penuh dan aktif selama proses berlangsung,</li>
            <li>2. Memberikan informasi yang benar dan sejujurnya berkaitan dengan masalah yang saya hadapi,</li>
            <li>3. Menyetujui adanya perekaman proses pada saat pelayanan / penanganan kasus baik berupa tulisan, rekaman percakapan dan dokumentasi lainnya selama proses konseling berlangsung,</li>
            <li>4. Layanan yang saya terima dari Tim PPA DP3APPKB merupakan layanan GRATIS tidak dipungut biaya apapun.</li>
        </ul>
        <div>Surat pernyataan ini dibuat dalam keadaan sadar dan sehat serta tidak ada paksaan dari pihak manapun, agar dapat dipergunakan sebagaimana mestinya.</div>
    </div>
    <table style="width: 100%;table-layout:fixed;" class="footer">
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: center">Surabaya,</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: center">Klien</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                {{-- <td style="text-align: center"><img src="data:image/png;base64,{{ base64_encode(url($data->ttd_path)) }}" /></td> --}}
                <td style="text-align: center"><img src="{{ $data->ttd_path }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: center">(........................................)</td>
            </tr>
        </tbody>
    </table>
</div>