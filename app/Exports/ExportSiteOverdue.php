<?php

namespace App\Exports;

use App\Sale;
use App\SiteTower;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class ExportSiteOverdue implements FromView,ShouldAutoSize
{
    /**
     * melakukan format dokumen menggunakan html, maka package ini juga menyediakan fungsi lainnya agar dapat me-load data tersebut dari file html / blade di Laravel
     */
    use Exportable;

    public function view(): View
    {
        // TODO: Implement view() method.
        return view('tower.TowerAllExcel',[
            'tower' => SiteTower::where('akhir_periode_kontrak','<',date('Y-m-d'))->get()
        ]);
    }
}
