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
            @foreach($data['header']['category2']['child'] as $header)
                <th style="background-color: #7e7e7e;text-align:center;color:white;">
                    {{$header}}
                </th>
            @endforeach
        </tr>

    </thead>
    <tbody>
        @foreach($data['body']['category'] as $d)
            <tr>
                <td style="text-align: center;">{{ $d['name'] }}</td>
                @foreach($d['child'] as $c)
                    <td style="text-align: center;"> {{$c['count']}} </td>
                @endforeach
                <td style="text-align: center;"> {{ $d['count'] }}</td>
            </tr>
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
