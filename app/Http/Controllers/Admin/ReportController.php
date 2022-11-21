<?php

namespace App\Http\Controllers\Admin;

use App\Models\PettyCash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

    public function report_petty_cash_index(){
        return view('costum.report-petty-cash-index');
    }


    public function report_petty_cash(Request $request){
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

    

    public function report_invoice(Request $request){

    }
}
