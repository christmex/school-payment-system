<?php

namespace App\Http\Livewire;

use App\Helpers\Helper;
use Livewire\Component;

class PayInvoice extends Component
{
    public $entry;
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


    public $tesa = [];
    public $tesi = [];
    public $tesu = [];


    public function mount($entry)
    {
        $this->entry = $entry;
        $this->entryTotal = count($entry);

        foreach ($entry as $key => $value) {
            $this->student_name[$key] = $value->student->student_name;
            $this->payment_month[$key] = $value->PaymentForMonthInHumanWay;
            $this->amount[$key] = $value->amount;
            $this->personal_discount[$key] = Helper::MoneyFormat($value->personal_discount);
            $this->SubTotal[$key] = $value->SubTotal;

            
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
    // 1.140.000 +1 200 000 

    public function render()
    {
        return view('livewire.pay-invoice');
    }
}
