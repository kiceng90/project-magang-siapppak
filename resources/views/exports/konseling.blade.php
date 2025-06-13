<style>
    table,
    th,
    td {
        border: 1px solid;
    }

    table th {
        font-size: 14px;
        padding: 5px
    }

</style>

<table class="table" cellspacing="0" style="font-family:Arial;">
    <thead>
        <tr>
            <th colspan="5" style="background:#f69546;text-align:center;">IDENTITAS KLIEN</th>
            <th colspan="6" style="background:#4aacc5;text-align:center;">ALAMAT KK</th>
            <th colspan="4" style="background:#8064a1;text-align:center;">DETAIL TELEKONSULTASI</th>
            <th colspan="6" style="background:#1e477b;text-align:center;">DETAIL HASIL TELEKONSULTASI
            </th>
            <th colspan="2" style="background:#d99491;text-align:center;">LAINNYA</th>
        </tr>
        <tr>
            <th style="background:#f69546;text-align:center;">NO</th>
            <th style="background:#f69546;text-align:center;width:200px">NAMA LENGKAP KLIEN</th>
            <th style="background:#f69546;text-align:center;width:200px">NIK</th>
            <th style="background:#f69546;text-align:center;">JENIS KELAMIN</th>
            <th style="background:#f69546;text-align:center;width:200px">NO TELP</th>
            <th style="background:#4aacc5;text-align:center;width:300px">ALAMAT</th>
            <th style="background:#4aacc5;text-align:center;">RT</th>
            <th style="background:#4aacc5;text-align:center;">RW</th>
            <th style="background:#4aacc5;text-align:center;width:200px">KELURAHAN</th>
            <th style="background:#4aacc5;text-align:center;width:200px">KECAMATAN</th>
            <th style="background:#4aacc5;text-align:center;width:200px">WILAYAH</th>
            <th style="background:#8064a1;text-align:center;width:200px">NAMA KONSELOR</th>
            <th style="background:#8064a1;text-align:center;width:200px">JENIS PERMASALAHAN</th>
            <th style="background:#8064a1;text-align:center;width:200px">URAIAN PERMASALAHAN</th>
            <th style="background:#8064a1;text-align:center;width:200px">HASIL KONSELING</th>
            <th style="background:#1e477b;text-align:center;width:200px">TANGGAL TELEKONSULTASI</th>
            <th style="background:#1e477b;text-align:center;width:200px">JAM TELEKONSULTASI</th>
            <th style="background:#1e477b;text-align:center;width:200px">WARGA</th>
            <th style="background:#1e477b;text-align:center;width:200px">KETERANGAN</th>
            <th style="background:#1e477b;text-align:center;width:200px">STATUS</th>
            <th style="background:#1e477b;text-align:center;width:200px">LAPORAN PENANGANAN</th>
            <th style="background:#d99491;text-align:center;width:200px">USERNAME</th>
            <th style="background:#d99491;text-align:center;width:200px">EMAIL</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data ?? [] as $key => $context)
        <tr>
            <td class="text-align:center">{{$key + 1}}</td>
            <td style="text-align:center;">{{$context->klien->name ?? ''}}</td>
            <td style="text-align:center;">{{$context->klien->nik . '‎' ?? ''}} </td>
            <td style="text-align:center;">{{$context->klien->l_p ?? ''}}</td>
            <td style="text-align:center;">{{$context->klien->phone ?? ''}}</td>
            <td style="text-align:center;">{{$context->klien->address ?? ''}}</td>
            <td style="text-align:center;">{{$context->klien->rt ?? ''}}</td>
            <td style="text-align:center;">{{$context->klien->rw ?? ''}}</td>
            <td style="text-align:center;">{{$context->klien->kelurahan->name ?? ''}}</td>
            <td style="text-align:center;">{{$context->klien->kelurahan->kecamatan->name ?? ''}}</td>
            <td style="text-align:center;">{{$context->klien->kabupaten->name ?? ''}}</td>
            <td style="text-align:center;">{{ $context->jadwalDetail?->jadwal?->konselor?->name ?? 'N/A' }}</td>
            <td style="text-align:center;">{{ str_replace('Konselor ', '', $context->jadwalDetail?->kategori?->name ?? 'N/A') }}</td>
            <td style="text-align:center;">{{str_replace('&nbsp;', ' ', strip_tags($context->description ?? '')) }}</td>
            <td style="text-align:center;">{{str_replace('&nbsp;', ' ', strip_tags($context->result ?? '')) }}</td>
            <td style="text-align:center;border:1px black solid;vertical-align:middle">
                {{ round(25569 + (strtotime($context->date) / 86400), 0 )}}
            </td>
            <td style="text-align:center;">
                {{ \Carbon\Carbon::parse($context->jadwalDetail?->start_time)->format('H:i') ?? '' }}
            </td>
            <td style="text-align:center;">{{$context->klien->kabupaten->name ?? ''}}</td>
            {{-- <td style="text-align:center;">{{$context->status_string ?? ''}}</td> --}}
            <td style="text-align:center;">
                @switch($context->status)
                    @case(1)
                        Menunggu konfirmasi Konsultan
                        @break
            
                    @case(2)
                        Konsultasi dikonfirmasi dan dilaksanakan via Zoom Meeting <br>
                        Link: "https://telkomsel.zoom.us/j/7127622420?pwd=bHBoVG9OUGpNQzVtTnQ2Rk1aSTRCdz09"<br>
                        Meeting ID: 712 762 2420 <br>
                        Passcode: puspaga
                        @break
            
                    @case(3)
                        Selesai dengan Rujukan ke Psikolog
                        @break
            
                    @case(4)
                        Selesai tanpa Rujukan
                        @break
            
                    @case(5)
                        Ditolak dengan alasan
                        @if(!empty($context->note_reject))
                        ({{ $context->note_reject }})
                        @endif

                        @break
            
                    @case(6)
                        Kadaluarsa
                        @break
            
                    @case(7)
                        Tidak Hadir
                        @break
                @endswitch
            </td>
            <td style="text-align:center;">
                @switch($context->status)
                    @case(1)
                        Belum Disetujui
                        @break
            
                    @case(2)
                        Sudah Disetujui
                        @break
            
                    @case(3)
                        Selesai dengan Rujukan 
                        @break
            
                    @case(4)
                        Selesai tanpa Rujukan
                        @break
            
                    @case(5)
                        Ditolak
                        @break
            
                    @case(6)
                        Kadaluarsa
                        @break
            
                    @case(7)
                        Tidak Hadir
                        @break
                @endswitch
            </td>
            <td style="text-align:center;">
                {{ $context->pengaduan?->id ? 'Sudah Masuk Pengaduan' : 'Belum Masuk Pengaduan' }}
            </td>
            <td style="text-align:center;">{{$context->klien->user->username ?? ''}}</td>
            <td style="text-align:center;">{{$context->klien->email ?? ''}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
