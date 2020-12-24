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
            <form class="form-horizontal">
                <div class="row">
                    <div class="col-md-6">
                        @for ($i = 0; $i < (count($column)/2); $i++)    
                            <div class="form-group">
                                <label for="inputName" class="col-sm-4 control-label">{{ ucwords(strtolower(str_replace('_',' ',$column[$i]))) }}</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{ $get->{$column[$i]} }}" class="form-control" id="inputName" placeholder="Name" readonly>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="col-md-6">
                        @for ($i = (count($column)/2); $i < (count($column)-3); $i++)    
                            <div class="form-group">
                                <label for="inputName" class="col-sm-4 control-label">{{ ucwords(strtolower(str_replace('_',' ',$column[$i]))) }}</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{ $get->{$column[$i]} }}" class="form-control" id="inputName" placeholder="Name" readonly>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                  
            </form>
        </div>
        <!-- /.box-body -->
    </div>



@endsection
