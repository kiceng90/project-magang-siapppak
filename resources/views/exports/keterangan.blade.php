<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
            <th colspan="3" style="background:#f69546;text-align:center;">IDENTITAS
                KLIEN</th>
            <th style="background:#9bbb59;text-align:center;"></th>
            <th style="background:#9bbb59;text-align:center;"></th>
            <th style="background:#9bbb59;text-align:center;"></th>
            <th colspan="4" style="background:#9bbb59;text-align:center;">KONDISI KLIEN</th>
        </tr>
        <tr>
            <th style="background:#f69546;text-align:center;">NO</th>
            <th style="background:#f69546;text-align:center;width:200px">NAMA KLIEN</th>
            <th style="background:#f69546;text-align:center;width:200px">NIK</th>
            <th style="background:#9bbb59;text-align:center;width:200px">SITUASI KELUARGA</th>
            <th style="background:#9bbb59;text-align:center;width:200px">KRONOLOGI KEJADIAN</th>
            <th style="background:#9bbb59;text-align:center;width:200px">HARAPAN KLIEN DAN KELUARGA</th>
            <th style="background:#9bbb59;text-align:center;width:200px">FISIK</th>
            <th style="background:#9bbb59;text-align:center;width:200px">PSIKOLOGIS</th>
            <th style="background:#9bbb59;text-align:center;width:200px">SOSIAL</th>
            <th style="background:#9bbb59;text-align:center;width:200px">SPIRITUAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data ?? [] as $key => $context)
        <tr>
            <td class="text-center">{{$key + 1}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nama}}</td>
            <td style="text-align:center;">{{$context->identitas_klien->nik . '‎'}}</td>
            <td style="text-align:center;">{{ preg_replace("/[^[:print:]]/", "", (($context->situasi_keluarga))) }}</td>
            <td style="text-align:center;">{{ preg_replace("/[^[:print:]]/", "", (($context->kronologi_kejadian))) }}</td>
            <td style="text-align:center;">{{ preg_replace("/[^[:print:]]/", "", (($context->harapan_klien))) }}</td>
            <td style="text-align:center;">{{$context->kondisi_klien->fisik}}</td>
            <td style="text-align:center;">{{$context->kondisi_klien->psikologi}}</td>
            <td style="text-align:center;">{{$context->kondisi_klien->sosial}}</td>
            <td style="text-align:center;">{{$context->kondisi_klien->spiritual}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</html>
