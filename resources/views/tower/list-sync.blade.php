@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Data Tower</h3>
        </div>

        <div class="box-header">
            <a href="{{ route('data-tower.index') }}" class="btn btn-primary" ><i class="fa fa-chevron-left"></i> Kembali Data Tower</a>
            {{-- <a href="{{ route('exportPDF.towersAll') }}" class="btn btn-danger">Export PDF</a>
            <a href="{{ route('exportExcel.towersAll') }}" class="btn btn-success">Export Excel</a> --}}
        </div>


        <!-- /.box-header -->
        <div class="box-body">
            <table id="sales-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($file as $no => $item)
                        <tr>
                            <td>{{ ($no+1) }}</td>
                            <td>{{ $item }}</td>
                            <td>
                                <a href="{{ url('tower/getdata/'.$item) }}" class="btn btn-sm btn-info"><i class="fa fa-refresh"></i> Sync Data</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>



@endsection
