<?php

namespace App\Http\Controllers;

use DB;
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
        $jenis = 'index';
        return view('tower.index')
                ->with('jenis',$jenis)
                ->with('tower',$tower);
    }
    public function overdue()
    {
        $tower = SiteTower::all();
        $jenis = 'overdue';
        return view('tower.index')
                ->with('jenis',$jenis)
                ->with('tower',$tower);
    }
    public function expired()
    {
        $tower = SiteTower::all();
        $jenis = 'expired';
        return view('tower.index')
                ->with('jenis',$jenis)
                ->with('tower',$tower);
    }
    public function show($id)
    {
        $get = SiteTower::find($id);
        $column = DB::getSchemaBuilder()->getColumnListing('site_tower');
        // return $column;
        return view('tower.show')
                ->with('column',$column)
                ->with('get',$get);
    }
    public function apiTowers($jenis)
    {
        if($jenis=='index')
            $tower = SiteTower::all();
        
        if($jenis=='overdue')
            $tower = SiteTower::where('akhir_periode_kontrak','<',date('Y-m-d'))->get();

        if($jenis=='expired')
            $tower = SiteTower::whereRaw('akhir_periode_kontrak BETWEEN curdate() AND curdate() + INTERVAL 3 MONTH ')->get();

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
                    return '<b>Expired</b> Dalam <span class="label label-success" <b>'.$selisih.'</b> </span>&nbsp;Hari Lagi';
                }
                else
                {
                    return '<b>Overdue</b> Sejak <span class="label label-danger"> <b>'.$selisih.'</b> </span>&nbsp;Hari Lalu';
                }
            })
            ->addColumn('action', function($tower){
                return '<a href="'.route('data-tower.show',$tower->id).'" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ' .
                    // '<a onclick="editForm('. $tower->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a> ' .
                    '<a onclick="deleteData('. $tower->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>';
            })
            ->rawColumns(['awal_periode_kontrak','akhir_periode_kontrak','status','action'])->make(true);
    }
}
