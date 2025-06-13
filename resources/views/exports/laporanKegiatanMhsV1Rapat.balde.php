<table>
    <thead>
        <tr>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#6e16a4;color:white; height:30px;" colspan="7">Identitas Mahasiswa</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0ba8b4;color:white;" colspan="4">Identitas Puspaga</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;" colspan="7">Kegiatan Piket Layanan</th>
        </tr>
        <tr>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0d0d86;color:white; height:50px;">No</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">Nama Lengkap</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">NIK</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">No. HP (WhatsApp)</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:140px;font-weight:bold; background-color:#0d0d86;color:white;">Status Mahasiswa</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">Jenis Mahasiswa</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">Asal Universitas</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">Kecamatan Puspaga RW</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">Kelurahan Puspaga RW</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:140px;font-weight:bold; background-color:#0d0d86;color:white;">Puspaga RW</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:220px;font-weight:bold; background-color:#0d0d86;color:white;">Staf Penanggungjawab</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">Tanggal Kegiatan</th>
            <!-- Konseling Header -->

            <!-- Sosialisasi Header -->

            <!-- Rapat Header -->

            <!-- Piket Header -->
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">Nama Klien</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">NIK</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">Tipe Konseling</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">Kategori Kasus</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">Warga Surabaya</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">Kota/Kabupaten Domisili</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">Kecamatan Domisili</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">Kelurahan Domisili</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">Alamat</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">Uraian Singkat</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">Tindak Lanjut</th>
            <th style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">Telepon Klien</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 0;
        @endphp
        @foreach($data as $key => $value)
            @foreach($value->laporan as $key => $laporan_master)
                    <tr>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$no + 1}}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->nama_lengkap}}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->nik . '‎'}}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->no_wa}}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->status}}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->jenis}}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->univ}}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->balai_puspaga_kelurahan}}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->balai_puspaga_kecamatan}}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->balai_puspaga_rw}}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->konselor}}</td>


                        <!-- Piket Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ \Carbon\Carbon::parse($laporan_master->tanggal_kegiatan)->translatedFormat('d F Y') }}
                        </td>

                        <!-- Piket Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->name }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->nik }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->tipe_permasalahan_string}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : ($laporan_master->konseling->kategori_kasus ? $laporan_master->konseling->kategori_kasus->name : "-")}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->is_surabaya_citizen }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->address }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->kelurahan->kecamatan->name }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->kelurahan->name }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->address }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->description }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->solution }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->phone }}
                        </td>

                    </tr>
                    @php
                        $no++;
                    @endphp
            @endforeach
        @endforeach
    </tbody>
</table>