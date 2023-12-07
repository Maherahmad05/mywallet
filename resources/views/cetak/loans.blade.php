@extends('layouts.cetak')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <P>
                <b>
                    <h3>Laporan Tabungan
                        <br>
                        SMK AL-BAHRI
                    </h3>
                </b>
            </P>
        </div>

        @if (request('tgl_awal'))
        <small>dari tanggal {{ request('tgl_awal') }} sampai tanggal {{ request('tgl_akhir') }}</small>
        @endif

        <u>
            <h4>Laporan Pengajuan Ansuransi</h4>
        </u>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Month</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($savings as $saving)
                <tr>
                    <td>{{$saving['name']}}</td>
                    <td>{{$saving['kelas']}}</td>
                    <td>{{$saving['nameM']}}</td>
                    <td>{{$saving['nominal']}}</td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection
