<?php

namespace App\Http\Controllers;

use PDF;
use Excel;
use App\SiteTower;
use App\Helpers\FuncHelper;
use Illuminate\Http\Request;
use App\Exports\ExportSuppliers;
use App\Imports\SuppliersImport;
use Yajra\DataTables\DataTables;

class SiteTowerController extends Controller
{
    public function index()
    {
        $tower = SiteTower::all();
        return view('tower.index')
                ->with('tower',$tower);
    }

    public function apiTowers()
    {
        $tower = SiteTower::all();

        return Datatables::of($tower)
            ->addColumn('awal_periode_kontrak',function($tower){
                return FuncHelper::tglIndo($tower->awal_periode_kontrak);
            })
            ->addColumn('akhir_periode_kontrak',function($tower){
                return FuncHelper::tglIndo($tower->akhir_periode_kontrak);
            })
            ->addColumn('status',function($tower){
                $selisih = FuncHelper::selisihhari($tower->akhir_periode_kontrak,date('Y-m-d'));
                if($tower->akhir_periode_kontrak > date('Y-m-d'))
                {
                    return 'Akan Berakhir <span class="label label-success" <b>'.$selisih.'</b> </span>&nbsp;Hari Lagi';
                }
                else
                {
                    return 'Telah Berakhir <span class="label label-danger"> <b>'.$selisih.'</b> </span>&nbsp;Hari Lalu';
                }
            })
            ->addColumn('action', function($tower){
                return '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ' .
                    '<a onclick="editForm('. $tower->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a> ' .
                    '<a onclick="deleteData('. $tower->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>';
            })
            ->rawColumns(['awal_periode_kontrak','akhir_periode_kontrak','status','action'])->make(true);
    }
}
