<table>
    <thead>
        <tr>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">NO</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">NIK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Nama Lengkap</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Nomor SK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Tanggal SK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Jabatan Dalam Instansi</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Kedudukan Dalam Tim</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Penerima Jasa Pelayanan</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">Jenis Jasa Pelayanan</th>            
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
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">
                Penerima Jasa Pelayanan</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">
                Jasa Pelayanan</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:180px;font-weight:bold">
                Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $value)
        <tr>
        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$key + 1}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->nik . '‎'}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->sk_number}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{ \Carbon\Carbon::parse($value->sk_date)->translatedFormat('d F Y')}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->jabatan_dalam_instansi_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->kedudukan_dalam_tim_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->penerima_jasa_pelayanan}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->id_jasa_pelayanan}}</td>
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
            </td>       --}}                                    
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->creator_name}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->creator_username}}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">
                {{ $value->penerima_jasa_pelayanan }}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">
                @switch($value->id_jasa_pelayanan)
                    @case(1)
                        Ketua Lembaga Pemberdayaan Masyarakat Kelurahan
                    @break

                    @case(2)
                        Ketua Rukun Warga
                    @break

                    @case(3)
                        Ketua Rukun Tetangga
                    @break

                    @case(4)
                        Penghafal Al-Qur’an (Hafidz)
                    @break

                    @case(5)
                        Modin Perawat Jenazah
                    @break

                    @case(6)
                        Petugas Makam Desa
                    @break

                    @case(7)
                        Petugas Penjaga Makam Cagar Budaya/Bangunan Cagar Budaya
                    @break

                    @case(8)
                        Tenaga Pendidik Keagamaan
                    @break

                    @case(9)
                        Tenaga Pendidik Kesetaraan
                    @break

                    @case(10)
                        Tenaga Pendidik PAUD dan Taman Kanak-Kanak (TK)/Kelompok Bermain (KB)/Taman penitipan Anak
                        (TPA)/Satuan Paud Sejenis (SPS)/Raudhatul Athfal (RA)
                    @break

                    @case(11)
                        Tenaga Pendidik yang belum mendapatkan sertifikasi dan/atau tunjangan fungsional dari Pemerintah
                    @break

                    @case(12)
                        Tenaga Pendidik Sekolah Luar Biasa
                    @break

                    @case(13)
                        Tenaga Pendidik dan Kependidikan Sekolah Formal Jenjang Pendidikan Dasar, Menengah, Kejuruan Dan
                        Sederajat yang diselenggarakan oleh Masyarakat atau Pemerintah
                    @break

                    @case(14)
                        Ketua Karang Werda
                    @break

                    @case(15)
                        Ketua Panti Asuhan
                    @break

                    @case(16)
                        Ketua Ikatan Pekerja Sosial Masyarakat di Kelurahan
                    @break

                    @case(17)
                        Veteran
                    @break

                    @case(18)
                        Kader Surabaya Hebat
                    @break

                    @case(19)
                        Marboth/Penjaga Rumah Ibadah
                    @break

                    @default
                        Tidak Ada
                @endswitch
            </td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">
                {{ $value->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }} </td>
        </tr>
        @endforeach
    </tbody>
</table>
