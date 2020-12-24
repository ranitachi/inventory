<?php
namespace App\Helpers;

class FuncHelper{
    public static function tglIndo($date)
    {
        if(strpos($date,'0000') === false)
            return date('d-m-Y', strtotime($date));
        else
            return 'n/a';
    }

    public static function selisihtanggal($date1, $date2)
    {
        $diff = abs(strtotime($date2) - strtotime($date1));
        $date['year']=$years = floor($diff / (365*60*60*24));
        $date['month']=$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $date['day']=$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        return $years.'-'.$months.'-'.$days;
    }

    public static function selisihhari($date1,$date2)
    {
        // if($date1=='0000-00-00' || $date2=='0000-00-00')
        if(strpos($date1,'0000') !== false)
            return $date1;
        else
        {
            
            $diff=date_diff(date_create($date1) , date_create($date2));
            return $diff->days;
        }
    }
}
?>