@if ($section == 'piket')
    <table>
        <thead>
            <tr>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#6e16a4;color:white; height:30px;"
                    colspan="7">Identitas Fasilitator</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0ba8b4;color:white;"
                    colspan="3">Identitas Puspaga</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;"
                    colspan="12">Kegiatan Konseling / Konsultasi</th>
            </tr>
            <tr>

                {{-- Identitas Fasilitator --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0d0d86;color:white; height:50px;">
                    No</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Nama Lengkap</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    NIK</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    No. HP (WhatsApp)</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Alamat Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan</th>

                {{-- Identitas Puspaga --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan Puspaga</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan Puspaga </th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Puspaga RW</th>

                {{-- Kegiatan Piket Layanan --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tanggal Kegiatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Balai RW</th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Jam Mulai Pelayanan</th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Jam Akhir Pelayanan </th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Uraian Aktivitas </th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 0;
            @endphp
            @foreach ($data as $key => $value)
                @forelse ($value->laporan as $key => $laporan_master)
                    <tr>
                        {{-- Identitas Fasilitator --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $no + 1 }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->nama_lengkap }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->nik . '‎' }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->no_wa }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_address }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_kecamatan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_kelurahan }}</td>

                        {{-- Identitas Puspaga --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->puspaga_kecamatan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->puspaga_kelurahan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->puspaga_rw }}</td>

                        {{-- Kegiatan Piket Layanan --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->piket) ? '-' : round(25569 + strtotime($laporan_master->tanggal_kegiatan) / 86400, 0) }}
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

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->piket) ? '-' : $laporan_master->piket->description }}
                        </td>

                    </tr>
                    @php
                        $no++;
                    @endphp
                @empty
                @endforelse
            @endforeach
        </tbody>
    </table>
@endif

@if ($section == 'konseling')
    <table>
        <thead>
            <tr>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#6e16a4;color:white; height:30px;"
                    colspan="7">Identitas Fasilitator</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0ba8b4;color:white;"
                    colspan="3">Identitas Puspaga</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;"
                    colspan="12">Kegiatan Konseling / Konsultasi</th>
            </tr>
            <tr>

                {{-- Identitas Fasilitator --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0d0d86;color:white; height:50px;">
                    No</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Nama Lengkap</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    NIK</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    No. HP (WhatsApp)</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Alamat Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan</th>

                {{-- Identitas Puspaga --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan Puspaga</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan Puspaga </th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Puspaga RW</th>

                {{-- Kegiatan Konseling / Konsultasi --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tanggal Kegiatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Nama Klien</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    NIK</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tipe Konseling</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kategori Kasus</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Warga Surabaya</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Alamat Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Uraian Singkat Permasalahan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tindak Lanjut</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Telp. Klien</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 0;
            @endphp
            @foreach ($data as $key => $value)
                @forelse ($value->laporan as $key => $laporan_master)
                    <tr>

                        {{-- Identitas Fasilitator --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $no + 1 }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->nama_lengkap }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->nik . '‎' }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->no_wa }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_address }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_kecamatan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_kelurahan }}</td>

                        {{-- Identitas Puspaga --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->puspaga_kecamatan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->puspaga_kelurahan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->puspaga_rw }}</td>

                        {{-- Kegiatan Konseling / Konsultasi --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : round(25569 + strtotime($laporan_master->tanggal_kegiatan) / 86400, 0) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->name }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->nik }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            @if (empty($laporan_master->konseling))
                                -
                            @else
                                @if ($laporan_master->konseling->type == '1')
                                    Ringan - Masalah dapat ditangani di Tingkat RW
                                @elseif($laporan_master->konseling->type == '2')
                                    Sedang - Masalah dapat ditangani di Tingkat Kelurahan/Kecamatan
                                @elseif($laporan_master->konseling->type == '3')
                                    Berat - Masalah ditangani dan dirujuk ke UPTD PPA/Puspaga Kota
                                @else
                                    {{ $laporan_master->konseling->type }} <!-- In case there's an unexpected value -->
                                @endif
                            @endif
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : ($laporan_master->konseling->kategori_kasus ? $laporan_master->konseling->kategori_kasus->name : '-') }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->warga_surabaya }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->kelurahan->kecamatan->name }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->kelurahan->name }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->address }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : strip_tags($laporan_master->konseling->description) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : strip_tags($laporan_master->konseling->solution) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->phone }}
                        </td>

                    </tr>
                    @php
                        $no++;
                    @endphp
                @empty
                @endforelse
            @endforeach
        </tbody>
    </table>
@endif

@if ($section == 'sosialisasi')
    <table>
        <thead>
            <tr>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#6e16a4;color:white; height:30px;"
                    colspan="7">Identitas Fasilitator</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;"
                    colspan="9">Sosialisasi / Parenting / Pembelajaran Keluarga / Promosi / Edukasi</th>
            </tr>
            <tr>
                {{-- Identitas Fasilitator --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0d0d86;color:white; height:50px;">
                    No</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Nama Lengkap</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    NIK</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    No. HP (WhatsApp)</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Alamat Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan</th>

                {{-- Rapat / Koordinasi / Pembekalan --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tanggal Kegiatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tipe Sosialisasi</th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Sasaran</th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Lokasi</th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Total Partisipan</th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Narasumber</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Instansi Asal Narasumber</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Materi yang disampaikan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    URL Video</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 0;
            @endphp
            @foreach ($data as $key => $value)
                @forelse ($value->laporan as $key => $laporan_master)
                    <tr>
                        {{-- Identitas Fasilitator --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $no + 1 }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->nama_lengkap }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->nik . '‎' }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->no_wa }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_address }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_kecamatan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_kelurahan }}</td>

                        <!-- Piket Data -->

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : round(25569 + strtotime($laporan_master->tanggal_kegiatan) / 86400, 0) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->type }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->sasaran }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->lokasi }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->total_participant }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->name }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->organization }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : strip_tags($laporan_master->sosialisasi->description) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->url_video }}
                        </td>

                    </tr>
                    @php
                        $no++;
                    @endphp
                @empty
                @endforelse
            @endforeach
        </tbody>
    </table>
@endif

@if ($section == 'rapat')
    <table>
        <thead>
            <tr>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#6e16a4;color:white; height:30px;"
                    colspan="5">Identitas Fasilitator</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0ba8b4;color:white;"
                    colspan="2">Identitas Puspaga</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;"
                    colspan="6">Rapat / Koordinasi / Pembekalan</th>
            </tr>
            <tr>
                {{-- Identitas Fasilitator --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0d0d86;color:white; height:50px;">
                    No</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Nama Lengkap</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    NIK</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    No. HP (WhatsApp)</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Alamat Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan</th>

                {{-- Rapat / Koordinasi / Pembekalan --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tanggal Kegiatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan</th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Nama</th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Deskripsi</th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Total Partisipan</th>

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Resume</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 0;
            @endphp
            @foreach ($data as $key => $value)
                @forelse ($value->laporan as $key => $laporan_master)
                    <tr>
                        {{-- Identitas Fasilitator --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $no + 1 }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->nama_lengkap }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->nik . '‎' }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->no_wa }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_address }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_kecamatan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_kelurahan }}</td>

                        <!-- Piket Data -->

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : round(25569 + strtotime($laporan_master->tanggal_kegiatan) / 86400, 0) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->kelurahan->name }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->name }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->description }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->total_participant }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->rapat) ? '-' : strip_tags($laporan_master->rapat->resume) }}
                        </td>

                    </tr>
                    @php
                        $no++;
                    @endphp
                @empty
                @endforelse
            @endforeach
        </tbody>
    </table>
@endif

@if ($section == 'Publikasi Kie')
    <table>
        <thead>
            <tr>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#6e16a4;color:white; height:30px;"
                    colspan="7">Identitas Fasilitator</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0ba8b4;color:white;"
                    colspan="3">Identitas Puspaga</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;"
                    colspan="8">Publikasi Konten Sosial Media</th>
            </tr>
            <tr>

                {{-- Identitas Fasilitator --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0d0d86;color:white; height:50px;">
                    No</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Nama Lengkap</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    NIK</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    No. HP (WhatsApp)</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Alamat Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan</th>

                {{-- Identitas Puspaga --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan Puspaga</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan Puspaga </th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Puspaga RW</th>

                {{-- Publikasi Konten Sosial Media --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tanggal Kegiatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Jenis Konten</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Jenis Aktivitas</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Deskripsi Konten</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tema Konten</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Judul Konten</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Narasi Singkat Konten</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Link Konten</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 0;
            @endphp
            @foreach ($data as $key => $value)
                @forelse ($value->laporan as $key => $laporan_master)
                    <tr>

                        {{-- Identitas Fasilitator --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $no + 1 }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->nama_lengkap }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->nik . '‎' }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->no_wa }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_address }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_kecamatan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->domicile_kelurahan }}</td>

                        {{-- Identitas Puspaga --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->puspaga_kecamatan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->puspaga_kelurahan }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $value->identitas_fasilitator->puspaga_rw }}</td>

                        {{-- Publikasi Konten Sosial Media --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->publikasi_kie) ? '-' : round(25569 + strtotime($laporan_master->tanggal_kegiatan) / 86400, 0) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->jenis_konten }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->jenis_kegiatan }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->deskripsi_kegiatan }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->tema_konten }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->judul_konten }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->deskripsi_konten }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->link_konten }}
                        </td>

                    </tr>
                    @php
                        $no++;
                    @endphp
                @empty
                @endforelse
            @endforeach
        </tbody>
    </table>
@endif
