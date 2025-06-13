@if ($section == 'piket')
    <table>
        <thead>
            <tr>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#6e16a4;color:white; height:30px;"
                    colspan="7">Identitas Mahasiswa</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0ba8b4;color:white;"
                    colspan="4">Identitas Puspaga</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;"
                    colspan="7">Kegiatan Piket Layanan</th>
            </tr>
            <tr>

                {{-- Identitas Mahasiswa --}}

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
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:140px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Status Mahasiswa</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Jenis Mahasiswa</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Asal Universitas</th>

                {{-- Identitas Puspaga --}}

                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan Puspaga RW</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan Puspaga RW</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:140px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Puspaga RW</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:220px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Staf Penanggungjawab</th>

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

                        {{-- Indetitas Mahasiswa --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $no + 1 }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->nama_lengkap)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->nik . '‎')) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->no_wa)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->status)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->jenis)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->univ)) }}</td>

                        {{-- Identitas Puspaga --}}

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->balai_puspaga_kecamatan)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->balai_puspaga_kelurahan)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->balai_puspaga_rw)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->konselor)) }}</td>

                        <!-- Piket Data -->

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->piket) ? '-' : round(25569 + strtotime($laporan_master->tanggal_kegiatan) / 86400, 0))) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->piket) ? '-' : $laporan_master->piket->kelurahan->kecamatan->name)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->piket) ? '-' : $laporan_master->piket->kelurahan->name)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->piket) ? '-' : $laporan_master->piket->rw)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->piket) ? '-' : $laporan_master->piket->opening_time)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->piket) ? '-' : $laporan_master->piket->closing_time)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->piket) ? '-' : $laporan_master->piket->description)) }}
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
                    colspan="7">Identitas Mahasiswa</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0ba8b4;color:white;"
                    colspan="4">Identitas Puspaga</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;"
                    colspan="13">Konsultasi</th>
            </tr>
            <tr>
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
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:140px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Status Mahasiswa</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Jenis Mahasiswa</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Asal Universitas</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan Puspaga RW</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan Puspaga RW</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:140px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Puspaga RW</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:220px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Staf Penanggungjawab</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tanggal Kegiatan</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Nama Klien</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    NIK</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tipe Konseling</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kategori Kasus</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:180px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Warga Surabaya</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kota/Kabupaten Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan Domisili</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Alamat</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Uraian Singkat</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Tindak Lanjut</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:250px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Telepon Klien</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 0;
            @endphp
            @foreach ($data as $key => $value)
                @forelse ($value->laporan as $key => $laporan_master)
                    <tr>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $no + 1 }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->nama_lengkap)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->nik . '‎')) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->no_wa)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->status)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->jenis)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->univ)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->balai_puspaga_kecamatan)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->balai_puspaga_kelurahan)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->balai_puspaga_rw)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->konselor)) }}</td>


                        <!-- Konseling Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(empty($laporan_master->konseling) ? '-' : round(25569 + strtotime($laporan_master->tanggal_kegiatan) / 86400, 0)) }}
                        </td>

                        <!-- Konseling Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->name)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->nik . '‎')) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->tipe_permasalahan_string)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : ($laporan_master->konseling->kategori_kasus ? $laporan_master->konseling->kategori_kasus->name : '-'))) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->is_surabaya_citizen)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->address)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->kelurahan->kecamatan->name)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->kelurahan->name)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->address)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : strip_tags($laporan_master->konseling->description))) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : strip_tags($laporan_master->konseling->solution))) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->konseling) ? '-' : $laporan_master->konseling->phone)) }}
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
                    colspan="5">Identitas Mahasiswa</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;"
                    colspan="9">Sosialisasi</th>
            </tr>
            <tr>
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
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:140px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Status Mahasiswa</th>
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
                    Jumlah Peserta</th>
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
                    URL Video
                </th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 0;
            @endphp
            @foreach ($data as $key => $value)
                @forelse ($value->laporan as $key => $laporan_master)
                    <tr>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $no + 1 }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->nama_lengkap)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->nik . '‎')) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->no_wa)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->status)) }}</td>

                        <!-- Piket Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(empty($laporan_master->sosialisasi) ? '-' : round(25569 + strtotime($laporan_master->tanggal_kegiatan) / 86400, 0)) }}
                        </td>

                        <!-- Piket Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->type)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->sasaran)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->lokasi)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->total_participant)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->name)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->organization)) }}
                        </td>

                        {{-- <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '',empty($laporan_master->sosialisasi) ? '-' :  $laporan_master->sosialisasi->description }}
                        </td> --}}
                        <td style="text-align:center; border:1px black solid; vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->sosialisasi) ? '-' : str_replace('&nbsp;', ' ', strip_tags($laporan_master->sosialisasi->description)))) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->sosialisasi) ? '-' : $laporan_master->sosialisasi->url_video)) }}
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
                    colspan="5">Identitas Mahasiswa</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0ba8b4;color:white;"
                    colspan="1">Identitas Puspaga</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;"
                    colspan="6">Rapat Koordinasi</th>
            </tr>
            <tr>
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
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:140px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Status Mahasiswa</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:220px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Staf Penanggungjawab</th>
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
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $no + 1 }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->nama_lengkap)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->nik . '‎')) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->no_wa)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->status)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->konselor)) }}</td>


                        <!-- Piket Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->rapat) ? '-' : round(25569 + strtotime($laporan_master->tanggal_kegiatan) / 86400, 0))) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->kelurahan->name)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->name)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->description)) }}
                        </td>

                        <!-- Piket Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->rapat) ? '-' : $laporan_master->rapat->total_participant)) }}
                        </td>

                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->rapat) ? '-' : strip_tags($laporan_master->rapat->resume))) }}
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

@if ($section == 'publikasi_kie')
    <table>
        <thead>
            <tr>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#6e16a4;color:white; height:30px;"
                    colspan="5">Identitas Mahasiswa</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#0ba8b4;color:white;"
                    colspan="4">Identitas Puspaga</th>
                <th style="border:100px solid white; text-align:center;vertical-align:middle;width:30px;font-weight:bold; background-color:#605c6e;color:white;"
                    colspan="8">Publikasi Komunikasi Informasi dan Edukasi</th>
            </tr>
            <tr>
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
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:140px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Status Mahasiswa</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kecamatan Puspaga RW</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:200px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Kelurahan Puspaga RW</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:140px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Puspaga RW</th>
                <th
                    style="border:100px solid white; text-align:center;vertical-align:middle;width:220px;font-weight:bold; background-color:#0d0d86;color:white;">
                    Staf Penanggungjawab</th>
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
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ $no + 1 }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->nama_lengkap)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->nik . '‎')) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->no_wa)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->status)) }}</td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->balai_puspaga_kecamatan)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->balai_puspaga_kelurahan)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->balai_puspaga_rw)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', $value->identitas_mahasiswa->konselor)) }}</td>


                        <!-- Piket Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->publikasi_kie)) ? '-' : round(25569 + strtotime($laporan_master->tanggal_kegiatan) / 86400, 0)) }}
                        </td>

                        <!-- Piket Data -->
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->jenis_konten)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->jenis_kegiatan)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->deskripsi_kegiatan)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->tema_konten)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->judul_konten)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->deskripsi_konten)) }}
                        </td>
                        <td style="text-align:center;border:1px black solid;vertical-align:middle">
                            {{ e(preg_replace('/[\x00-\x1F\x7F]/u', '', empty($laporan_master->publikasi_kie) ? '-' : $laporan_master->publikasi_kie->link_konten)) }}
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
