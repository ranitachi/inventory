<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use File;
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
                return '<a href="'.route('data-tower.show',$tower->id).'" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> ';
                    // '<a onclick="editForm('. $tower->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a> ' .
                    // '<a onclick="deleteData('. $tower->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>';
            })
            ->rawColumns(['awal_periode_kontrak','akhir_periode_kontrak','status','action'])->make(true);
    }

    public function getdata()
    {
        // $files = File::files(public_path().'/storage');
        $path = public_path().'/storage';
        $files = scandir($path);
        $get = array();
        foreach($files as $index => $value)
        {
            if($value!='.' && $value!='..')
            {
                // if($value=='page-1.txt')
                // {
                    $json_data = file_get_contents($path.'/'.$value);
                    // $json_data = preg_replace('/[^\00-\255]+/u', '',$json_data);
                    // $json_data = str_replace(chr(194),"",$json_data);
                    $json_data = preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','',$json_data);
                    $json_str = json_decode($json_data, true);
                    $chunked = array_chunk($json_str, 50);
                    foreach($chunked as $idx_c => $val_c)
                    {
                        foreach($val_c as $idx => $val)
                        {
                            $site_id = $val['site_id'];
    
                            $cek=SiteTower::where('site_id',$site_id)->first();
                            if(!$cek)
                            {
                                $simpan = SiteTower::create($val);  
                                if($simpan)
                                    $get[] = $site_id.' Sukses Simpan';  
                                else
                                    $get[] = $site_id.' Gagal Simpan';
                            }
                            else
                            {
                                $update = SiteTower::where('site_id',$site_id)->update($val);
                                if($update)
                                    $get[] = $site_id.' Sukses Update';  
                                else
                                    $get[] = $site_id.' Gagal Update';
                            }
    
                            // $get[] = 
                        }
                    }
                // }
            }
        }
        // return count($get);
        return redirect('data-tower-success')->with('success','Data Tower Berhasil Di Sinkronisasi Ulang');    
    }

    public function success()
    {
        return view('tower.success');
    }
    
}
