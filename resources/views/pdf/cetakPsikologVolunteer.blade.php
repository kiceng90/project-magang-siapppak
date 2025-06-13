<style>
    body {
        font-family: Arial;
    }

    .table-print {
        width: 100%;
    }

    .table-print tr td {
        padding: 7.5px;
        font-size: 15PX;
    }

</style>
<table class="table-print">
    <tbody>
        <tr>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Nama Lengkap</div>
                <div style="padding-top:5px">{{$data->name ?? '-'}}</div>
            </td>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">NIK</div>
                <div style="padding-top:5px">{{$data->nik ?? '-'}}</div>
            </td>
        </tr>
        <tr>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">No. HP / Whatsapp</div>
                <div style="padding-top:5px">{{$data->no_hp ?? '-'}}</div>
            </td>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Tempat Lahir</div>
                <div style="padding-top:5px">{{$data->nama_kabupaten_lahir ?? '-'}}</div>
            </td>
        </tr>
        <tr>         
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Tanggal Lahir</div>
                <div style="padding-top:5px">{{ \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y')}}</div>
            </td>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Pendidikan Terakhir</div>
                <div style="padding-top:5px">{{$data->nama_pendidikan_terakhir ?? '-'}}</div>
            </td>
        </tr>
        <tr>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Jurusan</div>
                <div style="padding-top:5px">{{$data->nama_jurusan ?? '-'}}</div>
            </td>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Instansi Pendidikan</div>
                <div style="padding-top:5px">{{$data->nama_instansi_pendidikan ?? '-'}}</div>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2" style="padding-top:10px">
                <div style="font-weight:600">Kompetensi</div>
                <div style="padding-top:5px">{{$data->kompetensi ?? '-'}}</div>
            </td>          
        </tr>
    </tbody>
</table>
<table class="table-print">
    <tbody>
        <tr>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Kecamatan Domisili</div>
                <div style="padding-top:5px">{{$data->kecamatan_domisili_name ?? '-'}}</div>
            </td>
            <td width="30%" style="padding-top:10px">
                <div style="font-weight:600">Kelurahan Domisili</div>
                <div style="padding-top:5px">{{$data->kelurahan_domisili_name ?? '-'}}</div>
            </td>
            <td width="10%" style="padding-top:10px">
                <div style="font-weight:600">RT</div>
                <div style="padding-top:5px">{{$data->rt_domisili ?? '0'}}</div>
            </td>
            <td width="10%" style="padding-top:10px">
                <div style="font-weight:600">RW</div>
                <div style="padding-top:5px">{{$data->rw_domisili ?? '0'}}</div>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="4" style="padding-top:10px">
                <div style="font-weight:600">Alamat Domisili</div>
                <div style="padding-top:5px">{{$data->alamat_domisili ?? '-'}}</div>
            </td>
        </tr>
    </tbody>
</table>

<table class="table-print">
    <tbody>
        <tr>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Kecamatan KTP</div>
                <div style="padding-top:5px">{{$data->kecamatan_ktp_name ?? '-'}}</div>
            </td>
            <td width="30%" style="padding-top:10px">
                <div style="font-weight:600">Kelurahan KTP</div>
                <div style="padding-top:5px">{{$data->kelurahan_ktp_name ?? '-'}}</div>
            </td>
            <td width="10%" style="padding-top:10px">
                <div style="font-weight:600">RT</div>
                <div style="padding-top:5px">{{$data->rt_ktp ?? '0'}}</div>
            </td>
            <td width="10%" style="padding-top:10px">
                <div style="font-weight:600">RW</div>
                <div style="padding-top:5px">{{$data->rw_ktp ?? '0'}}</div>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="4" style="padding-top:10px">
                <div style="font-weight:600">Alamat KTP</div>
                <div style="padding-top:5px">{{$data->alamat_ktp ?? '-'}}</div>
            </td>
        </tr>
    </tbody>
</table>
