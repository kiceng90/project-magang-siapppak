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
                <div style="padding-top:5px">{{$data->nama_m_konselor ?? '-'}}</div>
            </td>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">NIK</div>
                <div style="padding-top:5px">{{$data->nik ?? '-'}}</div>
            </td>
        </tr>
        <tr>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">TMT Tugas</div>
                <div style="padding-top:5px">{{ \Carbon\Carbon::parse($data->tmt_tugas)->translatedFormat('d F Y')}}</div>
            </td>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Status</div>
                <div style="padding-top:5px">{{ucwords($data->status) ?? '-'}}</div>
            </td>
        </tr>
        <tr>         
        <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Tempat Lahir</div>
                <div style="padding-top:5px">{{$data->nama_kabupaten_lahir ?? '-'}}</div>
            </td>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Tanggal Lahir</div>
                <div style="padding-top:5px">{{ \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y')}}</div>
            </td>
         
        </tr>
        <tr>           
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Pendidikan Terakhir</div>
                <div style="padding-top:5px">{{$data->nama_pendidikan_terakhir ?? '-'}}</div>
            </td>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Jurusan</div>
                <div style="padding-top:5px">{{$data->nama_jurusan ?? '-'}}</div>
            </td>
        </tr>
        <tr>
            <td width="100%" colspan="2" style="padding-top:10px">
            <div style="font-weight:600">Instansi Pendidikan</div>
                <div style="padding-top:5px">{{$data->nama_instansi_pendidikan ?? '-'}}</div>
            </td>          
        </tr>
    </tbody>
</table>
<table class="table-print">
    <tbody>
        <tr>
            <td width="50%" style="padding-top:10px">
                <div style="font-weight:600">Kecamatan Domisili</div>
                <div style="padding-top:5px">{{$data->nama_kecamatan_domisili ?? '-'}}</div>
            </td>
            <td width="30%" style="padding-top:10px">
                <div style="font-weight:600">Kelurahan Domisili</div>
                <div style="padding-top:5px">{{$data->nama_kelurahan_domisili ?? '-'}}</div>
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
                <div style="padding-top:5px">{{$data->nama_kecamatan_ktp ?? '-'}}</div>
            </td>
            <td width="30%" style="padding-top:10px">
                <div style="font-weight:600">Kelurahan KTP</div>
                <div style="padding-top:5px">{{$data->nama_kelurahan_ktp ?? '-'}}</div>
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
