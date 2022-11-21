<?php

namespace App\Http\Controllers\Admin;

use App\Models\PettyCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PettyCashReportController extends Controller
{
    //
    public function index(Request $request){
        // $PettyCash = PettyCash::groupBy('school_level_id')->get();
        //  $PettyCash = DB::table('petty_cashes')
        //  ->select(DB::raw("school_level_id, debit,payment_way_id"))
        //         ->where('debit','!=',0)
        //         ->groupBy(['school_level_id','debit','payment_way_id'])
        //         ->get();

        // return DB::table(function ($query) {
        //     $query->selectRaw('school_level_id,debit')
        //         ->from('petty_cashes')
        //         ->where('debit','!=',0)
        //         ->groupBy(['school_level_id','debit']);
        // }, 'petty_cashes')->get();


        // dd($request->date);
        // $currentDate = date('2022-11-18');
        $currentDate = $request->date;
        $PettyCash = PettyCash::select(['petty_cashes.petty_cash_title','petty_cashes.debit','petty_cashes.trx_date','school_levels.*','payment_ways.*'])
        ->join('school_levels','petty_cashes.school_level_id','=','school_levels.id')
        ->join('payment_ways','petty_cashes.payment_way_id','=','payment_ways.id')
        ->where('petty_cashes.debit','>',0)
        ->whereDate('petty_cashes.trx_date', '=', $currentDate)
        ->orderBy('payment_ways.id','asc')
        ->orderBy('school_levels.id','asc')
        ->get();
        // $PettyCash = PettyCash::with('SchoolLevel','PaymentWay')->where('debit','>',0)->orderBy('PaymentWay.id','desc')->get();
        return view('costum.report-petty-cash',compact('PettyCash','currentDate'));
    }
}
