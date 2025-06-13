<table>
    <thead>
        <tr>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">NO</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Nama Lengkap</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">NIK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Nomor HP<br>(Whatsapp)</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Email</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Status Mahasiswa</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Jenis Mahasiswa</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Jurusan</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Semester</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">IPK Terakhir</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Asal Universitas</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Alamat Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">RT</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kelurahan Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kecamatan Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kota / Kabupaten</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Alamat KK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">RT</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kelurahan KK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kecamatan KK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kota / Kabupaten</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Tanggal Daftar</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kelurahan Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kecamatan Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Staf Penanggung Jawab</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Status Penugasan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $value)
        <tr>
        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$key + 1}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->nik . '‎'}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->phone}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->email}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->pendidikan_terakhir->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->jenis_mahasiswa->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->jurusan->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->semester}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->ipk}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->instansi_pendidikan->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->domicile_address}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->domicile_rt}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->domicile_rw}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kelurahan_domisili->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kelurahan_domisili->kecamatan->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kelurahan_domisili->kecamatan->kabupaten->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kk_address}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kk_rt}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kk_rw}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kelurahan_kk->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kelurahan_kk->kecamatan->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kelurahan_kk->kecamatan->kabupaten->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->tanggal_daftar}}</td>
            @if(!empty($value->puspaga_rw))
                <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->puspaga_rw->balai_puspaga->kelurahan->name}}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->puspaga_rw->balai_puspaga->kelurahan->kecamatan->name}}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->puspaga_rw->balai_puspaga->rw}}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->puspaga_rw->konselor->name}}</td>
            @else
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> - </td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> - </td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> - </td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> - </td>
            @endif
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->status_string}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
