<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Setting;


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

    
    public static function getAllDueDate($startMonth){
        // Get all SchoolYear
        $SchoolYear = \App\Models\SchoolYear::where('is_active', true)->first();        
        // Init allduedate
        $allDueDate = [];
        // set index array
        $index = 1;
        for ($i=$startMonth; $i <= count(self::SchoolYearMonth()); $i++) { 
            // Get Normal Month by School Year Month
            $getNormalMonth = self::getNormalMonth($i);
            // 
            if($i > self::$school_year_month_end){
                $allDueDate[$index] = date($SchoolYear->school_year_end.'-'.$getNormalMonth.'-'.$SchoolYear->date_of_fine);
            }
            if($i < self::$school_year_month_start){
                $allDueDate[$index] = date($SchoolYear->school_year_start.'-'.$getNormalMonth.'-'.$SchoolYear->date_of_fine);
            }
            $index++;
        }

        return $allDueDate;
    }

    public static function getNormalMonth($month){
        return array_search(self::getSchoolYearMonthById($month), self::Months());
    }

    public static function getNormalMonthAll($joinMonth, $count){
        $data = [];
        for ($i=1; $i <= $count; $i++) { 
            $data[$i] = self::getNormalMonth($joinMonth);
            $joinMonth++;
        }
        return $data;
    }

    public static function getMonthById($id){
        return self::Months()[$id];
    }

    public static function generateInvoiceNumber($count){
        $setting = Setting::where('meta_key','school_short_name')->first();
        $latest = Invoice::orderBy('id','desc')->limit(1)->first();
        $startVal = 10001;

        if(!$latest){
            $val = $startVal;
        }else {
            $val = preg_replace("/[^0-9\.]/", '', explode('/',$latest->invoice_number)[0])+1;
        }
        $generateInvoiceNumber = [];

        if($latest){
            $explodeLatest = last(explode('/',$latest->invoice_number));
            if($explodeLatest != date('Y')){
                $val = $startVal;
            }
        }
        for ($i=1; $i <= $count; $i++) { 
            $generateInvoiceNumber[$i] = 'SPP'.str_pad($val,4,"0",STR_PAD_LEFT).'/'.$setting->meta_value.'/INV/'.rand(1000000000,99999999).'/'.date('Y');
            $val++;
        }
        return $generateInvoiceNumber;

    }

    public static function getSchoolYearMonthById($id){
        return self::SchoolYearMonth()[$id];
    }

    public static function moneyFormat($value){
        return "Rp ".number_format($value, 0,',', '.');
    }

    public static function getActiveSchoolYear($attribute = NULL){
        $data = \App\Models\SchoolYear::where('is_active', true)->first();
        if($attribute == 'all'){
            return $data;
        }
        return $data->id;
    }

    public static function getCurrentMonth(){
        return now()->month;
    }

    public static function getCurrentdate(){
        return now()->date;
    }

    public static function timestampOnDb(){
        return Carbon::now();
    }

    public static function calculatePinalties($date, $fine_amount = 0){
        $date = new Carbon(date($date));
        $now = Carbon::now();
        $pinlaties = 0;
        $difference = ($date->diff($now)->days < 1)
                ? 'today'
                : $date->diff($now);
        $pinlaties = $difference->days * $fine_amount;
        return $pinlaties;
        // dd([
        //     'date' => $date,
        //     'now' => $now,
        //     'difference' => $difference,
        //     'pinlaties' => $pinlaties,
        // ]);
    }

    public static function calculateFineNewStudent(){
        $getActiveSchoolYear = self::getActiveSchoolYear('all');
        $thisMonthFine = new Carbon(date('Y-m-'.$getActiveSchoolYear->date_of_fine));
        $now = Carbon::now();
        $fine = 0;
        // check jika $now di atas $thisMonthFine
        if($now > $thisMonthFine){
            $difference = ($thisMonthFine->diff($now)->days < 1)
                                ? 'today'
                                : $thisMonthFine->diff($now);
            $fine = $difference->d * $getActiveSchoolYear->fine_amount;
        }

        return [
            'fine' => $fine,
            'now' => $now,
            'datefine' => $getActiveSchoolYear->date_of_fine,
            'thisMonthFine' => $thisMonthFine,
        ];
    }

    public static function dateHumanDiff($date){
        $exp = explode('-', $date);
        return last($exp).' '.self::getMonthById((int)$exp[1]).' '.$exp[0];
        // $carbonDate = new Carbon($date);
        // return $carbonDate->diffForHumans();
    }

    public static function carbonDateHumanDiff($date){
        return Carbon::parse($date)->diffForHumans();
        // $carbonDate = new Carbon($date);
        // return $carbonDate->diffForHumans();
        // return $date->diffForHumans();
    }

    // public static function InvoiceNumberGenerator(){
    //     //get last record
    //     $record = Invoice::latest()->first();
    //     if($record == null){
    //         return date('Y').'-0001';
    //     }
    //     $expNum = explode('-', $record->invoice_number);
        
    //     //check first day in a year
    //     if ( date('l',strtotime(date('Y-01-01'))) ){
    //         $nextInvoiceNumber = date('Y').'-0001';
    //     } else {
    //         //increase 1 with last invoice number
    //         $nextInvoiceNumber = $expNum[0].'-'. $expNum[1]+1;
    //     }

    //     return $nextInvoiceNumber;
    // }

    public static function sanitizeMoneyFormat($value){
        return preg_replace("/[^0-9]/", "", $value);
    }

}