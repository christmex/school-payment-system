<?php


use App\Helpers\Helper;
use App\Models\Invoice;
use App\Models\Setting;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $Students = Student::with('StudentSchoolHistory.Classroom')->get();
    // dd($Students);
    foreach ($Students as $StudentSchoolHistory) {
        // dd($StudentSchoolHistory->StudentSchoolHistory->classroom_id);
        dd($StudentSchoolHistory->StudentSchoolHistory()->Classroom);
    }
    // dd($a->school_year);
    // dd(last([1,2,3]));
    // $latest = Invoice::latest()->first();
    // $setting = Setting::where('meta_key','school_short_name')->first();
    // if (! $latest) {
    //     return 'SPP0001/'.$setting->meta_value.'/INV/'.date('Y');
    // }

    // $string = preg_replace("/[^0-9\.]/", '', 'SPP0001');

    // // return 'SPP' . sprintf('%04d', $string+1) .'/'.$setting->meta_value.'/INV/'.date('Y');

    // $currentNumber = '0001';
    // $dfaul = preg_replace("/[^0-9\.]/", '', $currentNumber);
    // dd();

    // $val = preg_replace("/[^0-9\.]/", '', 'SPP0001');
    // for ($i=0; $i < 5; $i++) { 
    //     echo str_pad($val,4,"0",STR_PAD_LEFT)."<br>";
    //     $val++;
    // }
        // dd(Helper::generateInvoiceNumber(7,'2023'));
    // return array_search(Helper::getSchoolYearMonthById(1), Helper::Months());


    // return $dfaul.sprintf('%04d', $string+1) .'/'.$setting->meta_value.'/INV/'.date('Y');
});
