<?php

namespace App\Helpers;

class Helper {

    static $school_year_month_start = 7;
    static $school_year_month_end = 6;

    public static function Months(){
        return [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
    }


    public static function getMonthById($id){
        return self::Months()[$id];
    }

    public static function moneyFormat($value){
        return "RP. ".number_format($value, 0);
    }
}