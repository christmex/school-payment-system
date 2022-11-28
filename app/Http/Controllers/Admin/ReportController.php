<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Models\PettyCash;
use App\Models\InvoiceGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

    public $SubTotal = [];
    public $total = 0;
    public $fineAmount = 0;
    public $fineDiscount = 0;
    public $finalTotal = 0;

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
        $getAllSetting = Helper::getAllSetting();
        return view('costum.report-petty-cash',compact('PettyCash','currentDate','getAllSetting'));
    }

    

    public function report_invoice(Request $request){
        $InvoiceGroup = InvoiceGroup::with('Invoices.Student')->where('id',$request->id)->first();
        // dd($InvoiceGroup->Invoices);

        foreach ($InvoiceGroup->Invoices as $key => $value) {
            $this->SubTotal[$key] = $value->SubTotal;
            $this->fineAmount = $value->fine_amount >= $this->fineAmount ? $value->fine_amount : $this->fineAmount;
            $this->fineDiscount = $value->fine_discount >= $this->fineDiscount ? $value->fine_discount : $this->fineDiscount;
        }

        $total = array_sum($this->SubTotal);
        $fineDiscount = $this->fineDiscount;
        $fineAmount = $this->fineAmount;
        $getAllSetting = Helper::getAllSetting();
        $finalTotal = $total + ($this->fineAmount - $this->fineDiscount);
        

        return view('costum.report-invoice',compact('InvoiceGroup','total','finalTotal','fineDiscount','fineAmount','getAllSetting'));
    }
}
