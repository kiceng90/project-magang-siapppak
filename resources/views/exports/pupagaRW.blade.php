<table>
    <thead>
        <tr>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">NO</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">NIK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Nama Lengkap</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Nomor SK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Tanggal SK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kelurahan Lembaga</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Jabatan Dalam Instansi</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kedudukan Dalam Tim</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Alamat Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kecamatan Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kelurahan Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">RT</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Alamat KTP</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kecamatan KTP</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kelurahan KTP</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">RT</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">No. HP Aktif</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Email</th>
            {{-- <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Unggah KTP</th>             --}}
            {{-- <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Unggah Foto</th>             --}}
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Nama User Input</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Username User Input</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $value)
        <tr>
        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$key + 1}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->nik . '‎'}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->sk_number . '‎'}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{ \Carbon\Carbon::parse($value->sk_date)->translatedFormat('d F Y')}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->rw}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kelurahan_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->jabatan_dalam_instansi_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kedudukan_dalam_tim_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->alamat_domisili}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kecamatan_domisili_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kelurahan_domisili_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->rw_domisili}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->rt_domisili}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->alamat_ktp}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kecamatan_ktp_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kelurahan_ktp_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->rw_ktp}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->rt_ktp}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->no_hp}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->email}}</td>                                    
            {{-- <td style="text-align:center;border:1px black solid;vertical-align:middle">
                @if($value->ktp_path && file_exists(storage_path('app/'.$value->ktp_path)))
                <img src="{{storage_path('app/'.$value->ktp_path)}}" width="60px" style="display:block;"/>
                @endif
            </td>            
            <td style="text-align:center;border:1px black solid;vertical-align:middle">
                @if($value->foto_path && file_exists(storage_path('app/'.$value->foto_path)))
                <img src="{{storage_path('app/'.$value->foto_path)}}" width="60px" style="display:block;"/>
                @endif
            </td>      --}}
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->creator_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->creator_username}}</td>

        </tr>
        @endforeach
    </tbody>
</table>
