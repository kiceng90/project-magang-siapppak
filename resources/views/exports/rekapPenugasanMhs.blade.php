<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table cellspacing="0">
    <thead>
        <tr>
            @foreach($data['header'] as $header)
                <th 
                    @if(!empty($header['child'])) 
                        colspan="{{ count($header['child']) }}" 
                    @else 
                        rowspan="2" 
                    @endif 
                style="width:300px;background-color: #7e7e7e;color:white;text-align:center;">
                    {{ $header['name'] }}
                </th>
            @endforeach
        </tr>
        <tr>
            @foreach($data['header']['subcategory']['child'] as $header)
                <th style="background-color: #7e7e7e;text-align:center;color:white;">
                    {{$header}}
                </th>
            @endforeach
        </tr>

    </thead>
    <tbody>
        @foreach($data['body']['kecamatan'] as $kecamatan)
            <tr>
                <td style="text-align: center;background-color: #a7a7a7;">{{ $kecamatan['name'] }}</td>
                @foreach($kecamatan['subcategory'] as $subcategory)
                    <td style="text-align: center;background-color: #a7a7a7;"> {{$subcategory['count']}} </td>
                @endforeach
                <td style="text-align: center;background-color: #a7a7a7;"> {{ $kecamatan['count'] }}</td>
            </tr>
            @foreach($kecamatan['kelurahan'] as $kelurahan)
                <tr>
                    <td style="text-align: center;background-color: #b9b9b9;">{{ $kelurahan['name'] }}</td>
                    @foreach($kelurahan['subcategory'] as $subcategory)
                        <td style="text-align: center;background-color: #b9b9b9;"> {{$subcategory['count']}} </td>
                    @endforeach
                    <td style="text-align: center;background-color: #b9b9b9;"> {{ $kelurahan['count'] }}</td>
                </tr>
                @foreach($kelurahan['balai'] as $balai)
                    <tr>
                        <td style="text-align: center;">{{ $balai['name'] }}</td>
                        @foreach($balai['subcategory'] as $subcategory)
                            <td style="text-align: center;"> {{$subcategory['count']}} </td>
                        @endforeach
                        <td style="text-align: center;"> {{ $balai['count'] }}</td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
        <tr>
            <td style="background-color: #7e7e7e;color:white;text-align:center;">{{$data['body']['total']['name']}}</td>
            @foreach($data['body']['total']['child'] as $c)
                <td style="background-color: #7e7e7e;color:white;text-align:center;"> {{$c['count']}} </td>
            @endforeach
            <td style="background-color: #7e7e7e;color:white;text-align:center;">{{$data['body']['total']['count']}}</td>
        </tr>
    </tbody>
</table>

</html>
