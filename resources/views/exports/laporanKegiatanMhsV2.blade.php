<table>
    <thead>
        <tr>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold" colspan="15">Identitas Mahasiswa</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold" colspan="4">Identitas Puspaga</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold" colspan="12">Kegiatan</th>
        </tr>
        <tr>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">No</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Nama Lengkap</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">NIK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">No. HP (WhatsApp)</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Status Mahasiswa</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Jenis Mahasiswa</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Jurusan</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Semester</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Asal Universitas</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Alamat Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">RT</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kelurahan Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kecamatan Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kota / Kabupaten</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kecamatan Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kelurahan Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Staf Penanggungjawab</th>
            <!-- Kegiatan Header -->
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Tanggal Kegiatan</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Jenis Kegiatan</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Nama Klien</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">NIK / Jumlah Peserta</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Warga Surabaya / Klasifikasi Kasus</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kategori Kasus</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Alamat Domisili / Narasumber / Pimpinan Rapat</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kecamatan Domisili / Kecamatan Lokasi</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kelurahan Domisili / Kelurahan Lokasi</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Telp Klien / Instansi Asal Narasumber / Topik Rapat </th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Uraian Singkat Permasalahan / Materi yang Disampaikan / Resume Rapat</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Tindak Lanjut</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        
        @foreach($data as $key => $value)
            @php
                $rowspan = count((array) $value->laporan) * 3;
                $laporanfirstrow = true;
            @endphp
            <tr>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$no + 1}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->nama_lengkap}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->nik . '‎'}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->no_wa}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->status}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->jenis}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->jurusan}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->semester}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->univ}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->domicile_address}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->domicile_rt}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->domicile_rw}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->domicile_kelurahan}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->domicile_kecamatan}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->domicile_kota}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->balai_puspaga_kelurahan}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->balai_puspaga_kecamatan}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->balai_puspaga_rw}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_mahasiswa->konselor}}</td>
                @foreach($value->laporan as $laporan_master)
                    @if(!$laporanfirstrow)
                    <tr>
                    @endif
                        
                        <!-- Konseling Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $value->tanggal_kegiatan}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            Konseling / Konsultasi
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->name}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->nik . '‎'}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->warga_surabaya . ' - ' .  $laporan_master->konseling->tipe_permasalahan_string}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : (empty($laporan_master->konseling->kategori_kasus) ? $laporan_master->konseling->kategori_kasus->name : "-")}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->address}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->kelurahan->kecamatan->name}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->kelurahan->name}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->phone}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {!! (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->description !!}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {!! (empty($laporan_master->konseling)) ? '-' : $laporan_master->konseling->solution !!}
                        </td>
                    </tr>
                    @php
                        $laporanfirstrow = false;
                    @endphp
                    <tr>
                        
                        <!-- Sosialisasi Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->sosialisasi)) ? '-' : $value->tanggal_kegiatan}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            Sosialisasi / Parenting / <br> Pembelajaran Keluarga / Promosi / <br> Edukasi
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            -
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->total_participant }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            -
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->name }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' :  ((empty($laporan_master->sosialisasi->kelurahan->kecamatan->name)) ? '-' : $laporan_master->sosialisasi->kelurahan->kecamatan->name) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' :  ((empty($laporan_master->sosialisasi->kelurahan)) ? '-' : $laporan_master->sosialisasi->kelurahan->name) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->organization }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {!! empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->description !!}
                        </td>
                    </tr>
                    <tr>
                        <!-- Rapat Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ (empty($laporan_master->rapat)) ? '-' : $value->tanggal_kegiatan}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            Rapat / Koordinasi
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            -
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->total_participant }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            -
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->name }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->kelurahan->kecamatan->name }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->kelurahan->name }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {!! empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->description !!}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {!! empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->resume !!}
                        </td>
                    </tr>
                    <tr>
                        <!-- Piket Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->piket) ? '-' : $value->tanggal_kegiatan }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            Piket Layanan
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            -
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            -
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            -
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            -
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->piket) ? '-' : $laporan_master->piket->description }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->piket) ? '-' : $laporan_master->piket->kelurahan->kecamatan->name }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->piket) ? '-' : $laporan_master->piket->kelurahan->name }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->piket) ? '-' : $laporan_master->piket->rw }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->piket) ? '-' : $laporan_master->piket->opening_time }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->piket) ? '-' : $laporan_master->piket->closing_time }}
                        </td>
                    </tr>
                @endforeach
        @endforeach
    </tbody>
</table>
