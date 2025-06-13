<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    table,
    th,
    td {
        border: 1px #8e8e8e solid;
    }

</style>
<table cellspacing="0">
    <thead>
        <tr>
            <th style="width:300px;background-color: #7e7e7e;color:white;text-align:left;font-weight:bold;">
                TIPE PERMASALAHAN</th>
            @if(count($data) > 0)
            <th style="text-align:left;font-weight:bold;background-color: #7e7e7e;color:white;text-align:center;width:200px;"
                rowspan="2" colspan="{{count($data[0]->bulan)}}">Bulan</th>
            @endif
            <th rowspan="3"
                style="background-color: #7e7e7e;color:white;text-align:center;font-weight:bold;width:200px;">
                GRAND TOTAL</th>
        </tr>
        <tr>
            <th
                style="width:300px;background-color: #7e7e7e;color:white;text-align:left;font-weight:bold;padding-left:15px;">
                KATEGORI KASUS</th>
        </tr>
        <tr>
            <th
                style="width:300px;background-color: #7e7e7e;color:white;text-align:left;font-weight:bold;padding-left:30px;">
                JENIS KASUS</th>
            @if(count($data) > 0)
            @foreach($data[0]->bulan as $key => $value)
            <th style="background-color: #7e7e7e;color:white;text-align:center;font-weight:bold;">{{$value->bulan}}
                {{$value->tahun}}</th>
            @endforeach
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($data as $tipe)
        <tr>
            <td style="background-color:#a6a6a6;font-weight:bold;">{{$tipe->name}}</td>
            @foreach($tipe->bulan as $tipeBulan)
            <td style="background-color:#a6a6a6;font-weight:bold;text-align:center;">{{$tipeBulan->count}}</td>
            @endforeach
            <td style="background-color:#a6a6a6;font-weight:bold;text-align:center;">{{$tipe->grand_total}}</td>
        </tr>
        @if(isset($tipe->anak))
        <tr>
            <td style="background-color:#a6a6a6;font-weight:bold;padding-left:15px;">
                ANAK</td>
            @foreach($tipe->anak->bulan as $tipeAnakBulan)
            <td style="background-color:#a6a6a6;font-weight:bold;text-align:center;">
                {{$tipeAnakBulan->count}}</td>
            @endforeach
            <td style="background-color:#a6a6a6;font-weight:bold;text-align:center;">
                {{$tipe->anak->grand_total}}</td>
        </tr>

        @foreach($tipe->anak->kategori_kasus as $kategoriAnak)
        <tr>
            <td style="background-color:#d9d9d9;padding-left: 30px;">
                {{$kategoriAnak->name}}</td>
            @foreach($kategoriAnak->bulan as $kategoriAnakBulan)
            <td style="background-color:#d9d9d9;text-align:center;">{{$kategoriAnakBulan->count}}</td>
            @endforeach
            <td style="background-color:#d9d9d9;font-weight:bold;text-align:center;">
                {{$kategoriAnak->grand_total}}</td>
        </tr>
        @foreach($kategoriAnak->jenis_kasus as $jenisAnak)

        <tr>
            <td style="background-color:#f2f0f0;padding-left: 45px;">
                {{$jenisAnak->name}}</td>
            @foreach($jenisAnak->bulan as $jenisAnakBulan)
            <td style="background-color:#f2f0f0;text-align:center;">{{$jenisAnakBulan->count}}</td>
            @endforeach
            <td style="background-color:#f2f0f0;font-weight:bold;text-align:center;">{{$jenisAnak->grand_total}}</td>
        </tr>
        @endforeach
        @endforeach
        @endif
        @if(isset($tipe->dewasa))
        <tr>
            <td style="background-color:#a6a6a6;font-weight:bold;padding-left:15px;">
                DEWASA</td>
            @foreach($tipe->dewasa->bulan as $tileDewasaBulan)
            <td style="background-color:#a6a6a6;font-weight:bold;text-align:center;">
                {{$tileDewasaBulan->count}}</td>
            @endforeach
            <td style="background-color:#a6a6a6;font-weight:bold;text-align:center;">
                {{$tipe->dewasa->grand_total}}</td>
        </tr>

        @foreach($tipe->dewasa->kategori_kasus as $kategoriDewasa)
        <tr>
            <td style="background-color:#d9d9d9;padding-left: 30px;">
                {{$kategoriDewasa->name}}</td>
            @foreach($kategoriDewasa->bulan as $kategoriDewasaBulan)
            <td style="background-color:#d9d9d9;text-align:center;">{{$kategoriDewasaBulan->count}}</td>
            @endforeach
            <td style="background-color:#d9d9d9;font-weight:bold;text-align:center;">
                {{$kategoriDewasa->grand_total}}</td>
        </tr>
        @foreach($kategoriDewasa->jenis_kasus as $jenisDewasa)

        <tr>
            <td style="background-color:#f2f0f0;padding-left: 45px;">
                {{$jenisDewasa->name}}</td>
            @foreach($jenisDewasa->bulan as $jenisDewasaBulan)
            <td style="background-color:#f2f0f0;text-align:center;">{{$jenisDewasaBulan->count}}</td>
            @endforeach
            <td style="background-color:#f2f0f0;font-weight:bold;text-align:center;">{{$jenisDewasa->grand_total}}</td>
        </tr>
        @endforeach
        @endforeach
        @endif
        @endforeach

        <?php
            $datas = $data;                       
            $countYear = function ($index = null) use($datas){          
                $response = 0;

                if ($index === null) {
                    for ($i = 0; $i < count($datas); $i++) {
                        $response += $datas[$i]->grand_total;
                    }                    
                } else {
                    for ($i = 0; $i < count($datas); $i++) {
                        for ($x = 0; $x < count($datas[$i]->bulan); $x++) {
                            if ($index == $x) {
                                $response += $datas[$i]->bulan[$x]->count;
                            }

                        }
                    }
                }

                return $response;

                $response = 0;
                for ($i = 0; $i < count($datas); $i++) {
                    for ($x = 0; $x < count($datas[$i]->tahun); $x++) {
                        if ($index == $x) {
                            if ($type == 'anak') {
                                $response += $datas[$i]->tahun[$x]->anak;
                            } else if ($type == 'dewasa') {
                                $response += $datas[$i]->tahun[$x]->dewasa;
                            } else if ($type == 'yearTotal') {
                                $response += $datas[$i]->tahun[$x]->total;
                            }
                        }

                    }
                }

                return $response;
            }
          
            ?>
        @if(count($data) > 0)
        <tr>
            <td style="background:#fff !important;font-weight:bold;">Grand Total</td>
            @foreach($data[0]->bulan as $index => $value)

            <td style="color:black;font-weight:bold;background:#fff;text-align:center;" class="text-center">
                {{$countYear($index)}}
            </td>

            @endforeach
            <td style="color:black;font-weight:bold;background:#fff;text-align:center;" class="text-center">
                {{$countYear()}}
            </td>
        </tr>
        @endif
    </tbody>
</table>

</html>
