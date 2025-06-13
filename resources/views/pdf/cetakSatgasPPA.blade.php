<style>
    body {
        font-family: Arial !important;
        padding: 0 !important;
        margin: 0 !important
    }

    @page {
        padding: 0px;
        margin: 0px;
    }

    .table-print {
        font-family: Arial !important;
        width: 100%;
    }

</style>
<table class="table-print" cellpadding="0" cellspacing="0">
    <tr>
        <td style="vertical-align:top">
            <div>
                @if($data->foto_path && file_exists(storage_path('app/'.$data->foto_path)))
                <img src="{{storage_path('app/'.$data->foto_path)}}" style="height:420px;width:320px">
                @else
                <img src="{{public_path('assets/extends/img/noimage.png')}}" style="height:420px;width:320px">
                @endif
                <div style="background:black;width:320px;height:320px;">
                    <div
                        style="font-size:20px;color:#fff;font-weight:bold;padding-top:40px;padding-left:20px;padding-bottom:20px !important">
                        KONTAK
                        PERSON</div>
                    <table style="margin-top:20px;margin-left:20px;">
                        <tr>
                            <td>
                                <img src="{{public_path('assets/extends/img/icon-phone.png')}}" style="width:40px">
                            </td>
                            <td style="padding-left:15px;padding-right:15px">
                                <div style="color:#fff;font-weight:bold;font-size:18px">NO HP</div>
                                <div style="color:#fff;font-style:italic;font-size:16px;padding-top:10px;">{{$data->no_hp}}
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table style="margin-top:30px;margin-left:20px;">
                        <tr>
                            <td>
                                <img src="{{public_path('assets/extends/img/icon-email.png')}}" style="width:40px">
                            </td>
                            <td style="padding-left:15px;padding-right:15px">
                                <div style="color:#fff;font-weight:bold;font-size:18px">Email</div>
                                <div style="color:#fff;font-style:italic;font-size:16px;padding-top:10px;">
                                {{$data->email}}</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="vertical-align:top">
            <div style="padding:20px;height:700px">
                <div style=" font-size:28px;font-weight:bold;padding-top:20px;">Satuan Tugas Perlindungan Perempuan Dan
                    Anak (SATGAS PPA)
                </div>
                <div style="font-size:20px;padding-top:5px;">Kelurahan {{$data->kelurahan_name}}</div>
                <div style="font-size:18px;padding-top:25px;">No. SK : {{$data->sk_number}}</div>
                <div style="width:100%;height:3px;background:black;margin-top:15px;margin-bottom:15px;"></div>
                <div style="font-size:28px;font-weight:bold;">{{$data->name}}</div>
                <div style="font-size:18px;padding-top:5px;">{{$data->nik}}</div>
                <div style="font-size:17px;padding-top:25px;font-weight:bold">JABATAN DALAM INSTANSI</div>
                <div style="font-size:14px;padding-top:5px;">{{$data->jabatan_dalam_instansi_name}}</div>
                <div style="font-size:17px;padding-top:25px;font-weight:bold">KEDUDUKAN DALAM TIM</div>
                <div style="font-size:14px;padding-top:5px;">{{$data->kedudukan_dalam_tim_name}}</div>
                <div style="width:100%;height:3px;background:black;margin-top:15px;margin-bottom:15px;"></div>
                <table>
                    <tr>
                        <td style="width:130px;vertical-align:top">Alamat Domisili</td>
                        <td style="vertical-align:top">
                            <div>{{$data->alamat_domisili}}</div>
                            <div style="padding-top:5px;color:#616162;">RT {{$data->rt_domisili}}, RW {{$data->rw_domisili}}1</div>
                            <div style="padding-top:5px;color:#616162;">Kelurahan {{$data->kelurahan_domisili_name}}, Kecamatan {{$data->kecamatan_domisili_name}}</div>
                        </td>
                    </tr>
                </table>
                <table style="margin-top:10px">
                    <tr>
                        <td style="width:130px;vertical-align:top">Alamat KTP</td>
                        <td style="vertical-align:top">
                            <div>{{$data->alamat_ktp}}</div>
                            <div style="padding-top:5px;color:#616162;">RT {{$data->rt_ktp}}, RW {{$data->rw_ktp}}</div>
                            <div style="padding-top:5px;color:#616162;">Kelurahan {{$data->kelurahan_ktp_name}}, Kecamatan {{$data->kecamatan_ktp_name}}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            @if($data->ktp_path && file_exists(storage_path('app/'.$data->ktp_path)))
            <img src="{{storage_path('app/'.$data->ktp_path)}}" style="height:382px;width:100%">
            @else
            <img src="{{public_path('assets/extends/img/noimage.png')}}" style="height:382px;width:100%">
            @endif

        </td>
    </tr>
</table>
