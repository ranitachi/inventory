<?php

namespace App\Http\Controllers;

use App\SiteTower;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function updatedActivity()
    {
        $activity = Telegram::getUpdates();
        dd($activity);
    }

    public function storeMessage(Request $request)
    {
 
        $site_expired = SiteTower::where('akhir_periode_kontrak','<',date('Y-m-d'))->get()->count();
        $site_overdue = SiteTower::whereRaw('akhir_periode_kontrak BETWEEN curdate() AND curdate() + INTERVAL 3 MONTH ')->get()->count();

        $link_expired = url('site-expired');
        $link_overdue = url('site-overdue');
        $time = date('d-m-Y H:i:s');

        $text = "<b>Rekapitulasi Data Site : </b>\n<i>update : $time Wib</i>\n\nJumlah Expired Dalam 3 Bulan : <b><u>$site_expired Site</u></b>\nJumlah Overdue : <b><u>$site_overdue Site</u></b>\n\n\nLink Unduh Excel : \nExpired : $link_expired\nOverdue : $link_overdue";
 
        $send = Telegram::sendMessage([
            'chat_id' => '770213227',
            'parse_mode' => 'HTML',
            'text' => $text
        ]);

        $send = Telegram::sendMessage([
            'chat_id' => '221836329',
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
 
        return $send;
        // return redirect()->back();
    }
}
