<?php

namespace App\Http\Controllers\Admin;

use App\Models\PettyCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PettyCashReportController extends Controller
{
    //
    public function index(){
        // $PettyCash = PettyCash::groupBy('school_level_id')->get();
         $PettyCash = DB::table('petty_cashes')
         ->select(DB::raw("school_level_id, debit,payment_way_id"))
                ->where('debit','!=',0)
                ->groupBy(['school_level_id','debit','payment_way_id'])
                ->get();

        // return DB::table(function ($query) {
        //     $query->selectRaw('school_level_id,debit')
        //         ->from('petty_cashes')
        //         ->where('debit','!=',0)
        //         ->groupBy(['school_level_id','debit']);
        // }, 'petty_cashes')->get();


        // dd($PettyCash);

        return view('costum.report-petty-cash',compact('PettyCash'));
    }
}
