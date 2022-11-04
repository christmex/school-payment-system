<?php

namespace App\Helpers;


class Helper {

    // DO NOT CHANGE EVERYTHING FROM HERE
    static $max_school_year_month = 12;
    static $school_year_month_start = 7;
    static $school_year_month_end = 6;
    // DO NOT CHANGE EVERYTHING FROM HERE

    public static function Months(){
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    }

    public static function SchoolYearMonth(){
        return [
            1 => 'Juli',
            2 => 'Agustus',
            3 => 'September',
            4 => 'Oktober',
            5 => 'November',
            6 => 'Desember',
            7 => 'Januari',
            8 => 'Februari',
            9 => 'Maret',
            10 => 'April',
            11 => 'Mei',
            12 => 'Juni',
        ];
    }

    public static function getMonthById($id){
        return self::Months()[$id];
    }

    public static function getSchoolYearMonthById($id){
        return self::SchoolYearMonth()[$id];
    }

    public static function moneyFormat($value){
        return "RP. ".number_format($value, 0);
    }

    public static function getActiveSchoolYear(){
        $data = \App\Models\SchoolYear::where('is_active', true)->first();
        return $data->id;
    }
}