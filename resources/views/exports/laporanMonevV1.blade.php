<table>
    <thead>
        <tr>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold" rowspan="2" colspan="7">Identitas Petugas</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold" rowspan="2" colspan="4">Identitas Puspaga</th>
            @foreach($header as $key => $kategori)
                @php
                    $colspan = 0;
                    foreach($kategori->sub_kategori as $sub_kategori){
                        $colspan+=count($sub_kategori->kuesioner);
                    }
                @endphp    
                <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold" colspan="{{ $colspan }}">{{$kategori->name}}</th>
            @endforeach
        </tr>
        <tr>
            @foreach($header as $kategori)
                @foreach($kategori->sub_kategori as $sub_kategori)
                    <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold" colspan="{{ count($sub_kategori->kuesioner) }}">{{$sub_kategori->name}}</th>
                @endforeach
            @endforeach
        </tr>
        <tr>
            <!-- Identitas Petugas -->
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">No</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Nama Lengkap</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">NIK</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">No. HP (WhatsApp)</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Jabatan Petugas</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Apakah Kegiatan Puspaga Balai RW Masih Aktif ?</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Tanggal Monev</th>
            <!-- Identitas Puspaga -->
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kecamatan Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Kelurahan Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Puspaga RW</th>
            <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">Staf Penanggungjawab</th>
            <!-- Kuesioner -->
            @foreach($header as $kategori)
                @foreach($kategori->sub_kategori as $sub_kategori)
                    @foreach($sub_kategori->kuesioner as $kuesioner)
                        <th style="border:1px black solid; text-align:center;vertical-align:middle;width:30px;font-weight:bold">{{ $kuesioner->question }}</th>
                    @endforeach
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $value)
            <tr>
                <!-- Identitas Petugas -->
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $key+1 }}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->konselor->name }}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->konselor->dkonselor ? $value->konselor->dkonselor->nik . '‎' : "-" }}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->konselor->phone_number }}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->jabatan->name }}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->active_string }}</td>
                <!-- <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->date }}</td> -->
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->tanggal_monev }}</td>
                <!-- Identitas Puspaga -->
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->balai_puspaga_rw->kelurahan->kecamatan->name }}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->balai_puspaga_rw->kelurahan->name }}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->balai_puspaga_rw->rw }}</td>
                <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{ $value->balai_puspaga_rw->konselor->name }}</td>
                <!-- Kuesioner -->
                @foreach($header as $kategori)
                    @foreach($kategori->sub_kategori as $sub_kategori)
                        @foreach($sub_kategori->kuesioner as $kuesioner)
                            @php
                                $jawaban = "-";
                                $jawabanModel = App\Models\LaporanMonevJawaban::where('id_laporan_monev', $value->id)->where('id_kuesioner_laporan_monev', $kuesioner->id)->first();
                                if($jawabanModel){
                                    $jawaban = $jawabanModel->answer;
                                }
                            @endphp
                            <td style="text-align:center;border:1px black solid;vertical-align:middle"> {{$jawaban}} </td>
                        @endforeach
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
