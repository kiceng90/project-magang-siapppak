<table>
    <thead>
        <tr>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold" colspan="10">Identitas Fasilitator</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold" colspan="4">Identitas Puspaga</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold" colspan="12">Kegiatan</th>
        </tr>
        <tr>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">No</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Nama Lengkap</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">NIK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Jabatan Petugas Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">No. HP (WhatsApp)</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Alamat Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">RT</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kelurahan Domisili</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kecamatan Domisili</th>
            <!-- Puspaga Header -->
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kecamatan Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kelurahan Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Petugas Monev</th>
            <!-- Kegiatan Header -->
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Tanggal Kegiatan</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Jenis Kegiatan</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Nama Klien</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">NIK / Jumlah Peserta</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Warga Surabaya / Klasifikasi Kasus</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kategori Kasus</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Alamat Domisili / Narasumber / Pimpinan Rapat / Deskripsi</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kecamatan Domisili / Kecamatan Lokasi</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kelurahan Domisili / Kelurahan Lokasi</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Telp Klien / Instansi Asal Narasumber / Topik Rapat / Balai Puspaga RW </th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Uraian Singkat Permasalahan / Materi yang Disampaikan / Resume Rapat / Jam Mulai Pelayanan</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Tindak Lanjut / Jam Akhir Pelayanan</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach($data as $key => $value)
            @php
                $rowspan = count((array) $value->laporan ) * 4;
                $laporanfirstrow = true;
            @endphp
            
            <tr>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$no + 1}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->nama_lengkap}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->nik . '‎'}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->jabatan}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->no_wa}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->domicile_address}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->domicile_rt}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->domicile_rw}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->domicile_kelurahan}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->domicile_kecamatan}}</td>
                <!-- Puspaga Data -->
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->puspaga_kelurahan}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->puspaga_kecamatan}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->puspaga_rw}}</td>
                <td rowspan="{{$rowspan}}" style="text-align:center;border:1px black solid;vertical-align:middle">{{$value->identitas_fasilitator->monev}}</td>
                @foreach($value->laporan as $key => $laporan_master)
                    @if(!$laporanfirstrow)
                        <tr>
                    @endif
                        <!-- Konseling Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $value->tanggal_kegiatan}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            Konseling / Konsultasi
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->name}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->nik . '‎'}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->warga_surabaya . ' - ' .  $laporan_master->konseling->tipe_permasalahan_string}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : (empty($laporan_master->konseling->kategori_kasus) ? $laporan_master->konseling->kategori_kasus->name : "-")}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->address}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->kelurahan->kecamatan->name}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->kelurahan->name}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->phone}}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {!! empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->description !!}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {!! empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->solution !!}
                        </td>
                    </tr>
                    @php
                        $laporanfirstrow = false;
                    @endphp
                    <tr>
                        
                        <!-- Sosialisasi Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' :  $value->tanggal_kegiatan }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            Sosialisasi / Parenting / <br> Pembelajaran Keluarga / Promosi / <br> Edukasi
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            -
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' :  $laporan_master->sosialisasi->total_participant }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            -
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' :  $laporan_master->sosialisasi->name }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' :  ((empty($laporan_master->sosialisasi->kelurahan->kecamatan->name)) ? '-' : $laporan_master->sosialisasi->kelurahan->kecamatan->name) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' :  ((empty($laporan_master->sosialisasi->kelurahan)) ? '-' : $laporan_master->sosialisasi->kelurahan->name) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' :  $laporan_master->sosialisasi->organization }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {!! empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->description !!}
                        </td>
                        
                    </tr>
                    <tr>
                        <!-- Rapat Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : $value->tanggal_kegiatan }}
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
