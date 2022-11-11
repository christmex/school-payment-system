<?php

namespace App\Http\Livewire;

use App\Helpers\Helper;
use App\Models\Invoice;
use Livewire\Component;
use App\Models\PettyCash;
use App\Models\PaymentWay;
use Illuminate\Support\Facades\DB;

class PayInvoice extends Component
{
    public $entry;
    public $entryIds;
    public $entryTotal;

    public $student_name = [];
    public $payment_month = [];
    public $amount = [];
    public $personal_discount = [];
    public $SubTotal = [];

    public $total = 0;
    public $fineAmount = 0;
    public $fineDiscount = 0;
    public $finalTotal = 0;


    public $ModelPaymentWay;
    public $PaymentWay;
    public $description = NULL;

    protected $rules = [
        'PaymentWay' => 'required|Integer|min:1',
    ];


    public function mount($entry)
    {
        //Payment Way Model 
        $this->ModelPaymentWay = PaymentWay::all();

        // Invoice
        $this->entry = $entry;
        $this->entryTotal = count($entry);

        foreach ($entry as $key => $value) {
            $this->student_name[$key] = $value->student->student_name;
            $this->payment_month[$key] = $value->PaymentForMonthInHumanWay;
            $this->amount[$key] = $value->amount;
            $this->personal_discount[$key] = Helper::MoneyFormat($value->personal_discount);
            $this->SubTotal[$key] = $value->SubTotal;

            $this->entryIds[] = $value->id;
            
            $this->fineAmount = $value->fine_amount >= $this->fineAmount ? $value->fine_amount : $this->fineAmount;
            
        }
        $this->total = array_sum($this->SubTotal);
        $this->finalTotal = $this->total + ($this->fineAmount - $this->fineDiscount);
        $this->fineDiscount = Helper::MoneyFormat($this->fineDiscount);
    }
    
    public function updatedPersonalDiscount($value, $index){
        // Check dulu apakah int or string klo int lnjutkan, kalo bukan int ubah jadi 0  
        if($value ==""){
            // $this->personal_discount[$index] = 0;
            $this->personal_discount[$index] = "Rp 0";
        }
        // $this->personal_discount[$index] = Helper::sanitizeMoneyFormat($value);
        $operation = $this->amount[$index] - Helper::sanitizeMoneyFormat($this->personal_discount[$index]);
        if($operation < 0){
            // dd(\Alert::error('Employee status cant perform this action')->flash());
            // \Alert::error('Employee status cant perform this action');
            // return \Alert::add('info', 'This is a blue bubble.');
            return false;
        }
        $this->SubTotal[$index] = $operation;
        $this->total = array_sum($this->SubTotal);
        $this->finalTotal = $this->total + ($this->fineAmount - Helper::sanitizeMoneyFormat($this->fineDiscount));
        

    }

    public function updatedFineDiscount($value){
        if($value ==""){
            // $this->fineDiscount = 0;
            $this->fineDiscount = "Rp 0";
        }
        $operation =  $this->total + ($this->fineAmount - Helper::sanitizeMoneyFormat($this->fineDiscount));
        if($operation < 0){
            return false;
        }

        $this->finalTotal =$operation;
        // dd($this->finalTotal);
        
    }
    
    public function CheckValidData(){
        // if((count($this->student_name) == count($this->student_name)) && (count($this->amount) == count($this->personal_discount)) && (count($this->SubTotal) == count($this->fineAmount))){
        //     return true;
        // }
        return true;
    } 

    public function render()
    {
        return view('livewire.pay-invoice');
    }

    public function save(){
        $validate = $this->validate();
        // dd($this->entry);
        // check apakah sudah bayar or belum klo sudah bayar tidak bisa bayar lgi



        // Invoice::whereIn('id', $this->entryIds)->update([
        //     'personal_discount'
        //     'payment_way_id' => $this -> PaymentWay,
        //     'description' => $this -> description,
        //     'paid_date' => Helper::timestampOnDb()
        // ]);

        $queryInvoice = [];
        $queryPettyCash = [];

        if($this::CheckValidData()){
            for ($i=0; $i < count($this->entry); $i++) { 
                $queryPettyCash[] = [
                    'petty_cash_code' => 'asas',
                    'petty_cash_title'  => 'BAYAR SPP',
                    'debit' => $this->amount[$i],
                    'credit' => 0,
                    'description' => NULL,
                    'trx_date' => Helper::timestampOnDb(),
                    'created_by' => backpack_user()->id,
                    'updated_by' => backpack_user()->id,
                    'created_at' =>  Helper::timestampOnDb(),
                    'updated_at' => Helper::timestampOnDb(),
                ];
                $queryPettyCash[] = [
                    'petty_cash_code' => 'asas',
                    'petty_cash_title'  => 'DISCOUNT SPP',
                    'debit' => 0,
                    'credit' => Helper::sanitizeMoneyFormat($this->personal_discount[$i]),
                    'description' => NULL,
                    'trx_date' => Helper::timestampOnDb(),
                    'created_by' => backpack_user()->id,
                    'updated_by' => backpack_user()->id,
                    'created_at' =>  Helper::timestampOnDb(),
                    'updated_at' => Helper::timestampOnDb(),
                ];
                $queryInvoice[] = [
                    'personal_discount' => Helper::sanitizeMoneyFormat($this->personal_discount[$i]),
                    'fine_discount' => 0,
                    'payment_way_id' => $this -> PaymentWay,
                    'description' => $this -> description,
                    'paid_date' => Helper::timestampOnDb()
                ];
                
                
            }
            if($this->fineAmount){
                $queryPettyCash[] = [
                    'petty_cash_code' => 'asas',
                    'petty_cash_title'  => 'BAYAR DENDA',
                    'debit' => $this->fineAmount,
                    'credit' => 0,
                    'description' => NULL,
                    'trx_date' => Helper::timestampOnDb(),
                    'created_by' => backpack_user()->id,
                    'updated_by' => backpack_user()->id,
                    'created_at' =>  Helper::timestampOnDb(),
                    'updated_at' => Helper::timestampOnDb(),
                ];
                $queryPettyCash[] = [
                    'petty_cash_code' => 'asas',
                    'petty_cash_title'  => 'DISCOUNT DENDA',
                    'debit' => 0,
                    'credit' => Helper::sanitizeMoneyFormat($this->fineDiscount),
                    'description' => NULL,
                    'trx_date' => Helper::timestampOnDb(),
                    'created_by' => backpack_user()->id,
                    'updated_by' => backpack_user()->id,
                    'created_at' =>  Helper::timestampOnDb(),
                    'updated_at' => Helper::timestampOnDb(),
                ];
            }
            
        }

        // dd($queryPettyCash);
        PettyCash::insert($queryPettyCash);
        // DB::table('petty_cashes')->insert($queryPettyCash);


    }

    public function saveWithRedirectToInvoice(){
        $this->save();
        \Alert::add('success', 'Success paying the invoice')->flash();
        return redirect()->route('invoice.index');
    }
}
