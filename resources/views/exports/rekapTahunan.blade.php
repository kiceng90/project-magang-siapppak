<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table cellspacing="0">
    <thead>
        <tr>
            <th style="width:300px;background-color: #7e7e7e;color:white;">TIPE PERMASALAHAN
            </th>
            @if(count($data) > 0)
                <th style="background-color: #7e7e7e;text-align:center;color:white;" colspan="{{count($data[0]->tahun) * 3}}">Tahun</th>
            @endif                      
            <th rowspan="3" style="width:200px;background-color: #7e7e7e;text-align:center;color:white;">Grand Total</th>
        </tr>
        <tr>
            <th style="width:300px;background-color: #7e7e7e;text-align:left;padding-left:15px;color:white;">KATEGORI
                KASUS
            </th>
            @if(count($data) > 0)
                @foreach($data[0]->tahun as $key => $value)
                    <th colspan="2" style="width:300px;background-color: #7e7e7e;text-align:center;color:white;">{{$value->tahun}}</th>
                    <th rowspan="2" style="width:200px;background-color: #7e7e7e;text-align:center;color:white;">{{$value->tahun}} Total</th>
                @endforeach
            @endif                       
        </tr>
        <tr>
            <th style="width:300px;background-color: #7e7e7e;text-align:left;padding-left:30px;color:white;">JENIS
                KASUS
            </th>
            @if(count($data) > 0)
                @foreach($data[0]->tahun as $key => $value)
                    <th style="width:150px;background-color: #7e7e7e;text-align:center;color:white;">ANAK</th>
                    <th style="width:150px;background-color: #7e7e7e;text-align:center;color:white;">DEWASA</th>
                @endforeach
            @endif                
        </tr>
    </thead>
    <tbody>
        @foreach($data as $keyTipe => $tipe)                      
            <tr>
                <td style="color:black;background-color: #a6a6a6;font-weight:bold;">{{$tipe->name}}</td>
                @foreach($tipe->tahun as $keyTipeYear => $tipeYear)              
                    <td style="color:black;background-color:#a6a6a6;text-align:center;font-weight:bold;">
                        {{$tipeYear->anak}}
                    </td>
                    <td style="color:black;background-color:#a6a6a6;text-align:center;font-weight:bold;">
                        {{$tipeYear->dewasa}}
                    </td>
                    <td style="color:black;background-color:#a6a6a6;text-align:center;font-weight:bold;">
                        {{$tipeYear->total}}
                    </td>               
                @endforeach
                <td style="color:black;background-color:#a6a6a6;text-align:center;font-weight:bold;">{{$tipe->grand_total}}
                </td>
            </tr>
            @foreach($tipe->kategori_kasus as $keyKategori => $kategori)                
                <tr>
                    <td style="background-color: #d9d9d9;" class="text-indent">{{$kategori->name}}</td>
                    @foreach($kategori->tahun as $keyKategoriYear => $kategoriYear)                    
                        <td style="background-color:#d9d9d9;text-align:center">{{$kategoriYear->anak}}</td>
                        <td style="background-color:#d9d9d9;text-align:center">{{$kategoriYear->dewasa}}</td>
                        <td style="background-color:#d9d9d9;text-align:center">{{$kategoriYear->total}}</td>                    
                    @endforeach
                    <td style="background-color:#d9d9d9;text-align:center;font-weight:bold;">{{$kategori->grand_total}}</td>
                </tr>

                @foreach($kategori->jenis_kasus as $keyJenis => $jenis)                
                <tr>
                    <td style="background-color: #f2f0f0">    {{$jenis->name}}</td>
                    @foreach($jenis->tahun as $keyJenisYear => $jenisYear)                    
                        <td style="background-color:#f2f0f0;text-align:center">{{$jenisYear->anak}}</td>
                        <td style="background-color:#f2f0f0;text-align:center">{{$jenisYear->dewasa}}</td>
                        <td style="background-color:#f2f0f0;text-align:center">{{$jenisYear->total}}</td>                    
                    @endforeach
                    <td style="background-color:#f2f0f0;text-align:center;font-weight:bold;">{{$jenis->grand_total}}</td>
                </tr>
            @endforeach
            @endforeach
        @endforeach 
        @if(count($data) > 0)    
            @php
                $grandTotal = 0;
            @endphp

            @foreach ($data as $key)        
                @php                  
                        $grandTotal += $key->grand_total;                    
                @endphp                
            @endforeach

            <?php
            $datas = $data;                       
            $countYear = function ($type, $index) use($datas){                                
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
        <tr>
            <td style="font-weight:bold;">Grand Total</td>
            @foreach($data[0]->tahun as $keyParentYear => $parentYear)                              
                <td style="color:black;text-align:center;font-weight:bold;">
                   {{$countYear('anak', $keyParentYear)}}
                </td>
                <td style="color:black;text-align:center;font-weight:bold;">
                    {{$countYear('dewasa', $keyParentYear)}}
                </td>
                <td style="color:black;text-align:center;font-weight:bold;">
                    {{$countYear('yearTotal', $keyParentYear)}}
                </td>               
            @endforeach
            <td style="color:black;text-align:center;font-weight:bold;">
                {{$grandTotal}}
            </td>
        </tr>   
        @endif
    </tbody>
</table>

</html>
