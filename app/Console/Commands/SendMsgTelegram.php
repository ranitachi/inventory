<?php

namespace App\Console\Commands;

use App\SiteTower;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendMsgTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:notif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim Notif Telegram Otomatis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $site_expired = SiteTower::where('akhir_periode_kontrak','<',date('Y-m-d'))->get()->count();
        $site_overdue = SiteTower::whereRaw('akhir_periode_kontrak BETWEEN curdate() AND curdate() + INTERVAL 3 MONTH ')->get()->count();

        $link_expired = url('site-expired');
        $link_overdue = url('site-overdue');
        $time = date('d-m-Y H:i:s');

        $text = "<b>Rekapitulasi Data Site : </b>\n<i>update : $time Wib</i>\n\nJumlah Expired Dalam 3 Bulan : <b><u>$site_expired Site</u></b>\nJumlah Overdue : <b><u>$site_overdue Site</u></b>\n\n\nLink Unduh Excel : \nExpired : $link_expired\nOverdue : $link_overdue";
 
        // 'chat_id' => env('TELEGRAM_CHANNEL_ID', '770213227'),
        $send = Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', '221836329'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
        $send = Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', '770213227'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
    }
}
