
<table id="categories" width="100%">
    <tr>
        <td colspan="9" style="text-align:center">
            <h3 >
                <b>DAFTAR SITE YANG AKAN BERAKHIR DALAM WAKTU 3 BULAN</b>
            </h3>
        </td>
    </tr>
    <tr>
        <td colspan="9">
            &nbsp;
        </td>
    </tr>
    <tr>
        <th style="border:1px solid #000000;width:15px !important;"><b>Site ID</b></th>
        <th style="border:1px solid #000000;width:45px !important;"><b>Site Name</b></th>
        <th style="border:1px solid #000000;width:30px !important;"><b>Provinsi</b></th>
        <th style="border:1px solid #000000;width:30px !important;"><b>Kabupaten/Kota</b></th>
        <th style="border:1px solid #000000;width:30px !important;"><b>Kecamatan</b></th>
        <th style="border:1px solid #000000;width:30px !important;"><b>Kelurahan</b></th>
        <th style="border:1px solid #000000;width:10px !important;"><b>Awal Periode</b></th>
        <th style="border:1px solid #000000;width:10px !important;"><b>Akhir Periode</b></th>
        <th style="border:1px solid #000000;width:30px !important;"><b>Status</b></th>
    </tr>
    @foreach($tower as $s)
        <tr>
            <td style="border:1px solid #000000;">{{ $s->site_id }}</td>
            <td style="border:1px solid #000000;">{{ $s->site_name }}</td>
            <td style="border:1px solid #000000;">{{ $s->provinsi_name }}</td>
            <td style="border:1px solid #000000;">{{ $s->kabupaten_name }}</td>
            <td style="border:1px solid #000000;">{{ $s->kecamatan_name }}</td>
            <td style="border:1px solid #000000;">{{ $s->kelurahan_name }}</td>
            <td style="border:1px solid #000000;">
                {{ \App\Helpers\FuncHelper::tglIndo($s->awal_periode_kontrak) }}
            </td>
            <td style="border:1px solid #000000;">
                {{ \App\Helpers\FuncHelper::tglIndo($s->akhir_periode_kontrak) }}
            </td>
            <td style="border:1px solid #000000;">
                @php
                    $selisih = \App\Helpers\FuncHelper::selisihhari($s->akhir_periode_kontrak,date('Y-m-d'));
                    if($s->akhir_periode_kontrak > date('Y-m-d'))
                    {
                        echo 'Expired Dalam '.$selisih.' Hari Lagi';
                    }
                    else
                    {
                        echo 'Overdue Sejak '.$selisih.' Hari Lalu';
                    }        
                @endphp
            </td>
        </tr>
    @endforeach

</table>
