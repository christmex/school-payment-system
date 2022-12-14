<?php

namespace App\Http\Livewire;

use App\Helpers\Helper;
use App\Models\Invoice;
use App\Models\Student;
use Livewire\Component;
use App\Models\PettyCash;
use App\Models\PaymentWay;
use App\Models\InvoiceGroup;
use Illuminate\Support\Facades\DB;
use App\Models\StudentSchoolHistory;

class PayInvoice extends Component
{
    public $button = 'Create';
    public $buttonStatus;
    public $entry;
    public $entryIds;
    public $entryInvoiceNumber;
    public $entryTotal;

    public $student_name = [];
    public $student_ids = [];
    public $payment_month = [];
    public $paid_status = [];
    public $payment_month_id = [];
    public $amount = [];
    public $personal_discount = [];
    public $SubTotal = [];

    public $total = 0;
    public $fineAmount = 0;
    public $fineDiscount = 0;
    public $finalTotal = 0;

    public $print_id;

    public $ModelPaymentWay;
    public $PaymentWay;
    public $PaymentDate;
    public $description = NULL;

    public $classroom;

    protected $rules = [
        'PaymentWay' => 'required|Integer|min:1',
        'PaymentDate' => 'required|date',
    ];

    public function LoadingAnimation(){}

    public function mount($entry)
    {

        //Payment Way Model 
        $this->ModelPaymentWay = PaymentWay::all();
        $setting = Helper::getSetting('is_fine_of_amount_active');

        // Invoice
        $this->entry = $entry;
        $this->entryTotal = count($entry);
        // dd($entry);
        foreach ($entry as $key => $value) {
            $this->student_name[$key] = $value->student->student_name;
            $this->student_ids[$key] = $value->student->id;
            $this->payment_month[$key] = $value->PaymentForMonthInHumanWay;
            $this->payment_month_id[$key] = $value->payment_for_month;
            $this->paid_status[$key] = $value->paid_date ;
            $this->amount[$key] = $value->amount;
            $this->personal_discount[$key] = Helper::MoneyFormat($value->personal_discount);
            $this->SubTotal[$key] = $value->SubTotal;

            $this->entryIds[] = $value->id;
            $this->entryInvoiceNumber[] = $value->invoice_number;
            
            $this->fineAmount = $value->fine_amount >= $this->fineAmount ? $value->fine_amount : $this->fineAmount;

            $this->buttonStatus = $value->paid_date;
            $this->print_id = $value->invoice_group_id;
            $this->PaymentDate = $value->paid_date;
            $this->PaymentWay = $value->payment_way_id;
            // dd(count($value->student->StudentSchoolHistory->toArray()));
            if(count($value->student->StudentSchoolHistory->toArray())){
                $this->buttonStatus = true;
                $this->classroom = $value->student->StudentSchoolHistory->first()->Classroom->classroom_name;
            }else {
                $this->buttonStatus = null;
                $this->addError('buttonStatus', 'Terjadi kesalahan, tidak bisa membayar tagihan, kesalahan ini kemungkinan terjadi karna tahun ajaran yang bermasalah, silahkan hubungi developer');
            }
        }
        $this->total = array_sum($this->SubTotal);
        $this->fineDiscount = $setting->meta_value ?  Helper::MoneyFormat($this->fineAmount) : Helper::MoneyFormat($this->fineDiscount);
        $this->finalTotal = $this->total + ($this->fineAmount - Helper::sanitizeMoneyFormat($this->fineDiscount));
        $this->PaymentDate = date('Y-m-d');
    }
    
    public function updatedPersonalDiscount($value, $index){
        // Check dulu apakah int or string klo int lnjutkan, kalo bukan int ubah jadi 0  
        if($value ==""){
            // $this->personal_discount[$index] = 0;
            $this->personal_discount[$index] = "Rp 0";
        }
        if(Helper::sanitizeMoneyFormat($this->personal_discount[$index]) > $this->amount[$index]){
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
        if(Helper::sanitizeMoneyFormat($this->fineDiscount) > $this->fineAmount){
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


        DB::transaction(function () {
            $queryInvoice = [];
            $queryPettyCash = [];
            $activeSchoolYear = Helper::getActiveSchoolYear('all');
            // $as = StudentSchoolHistory::with('SchoolLevel')->whereIn('student_id',[1,2])->where('school_year_id',1)->get();
            $getSchoolLevel = StudentSchoolHistory::with('SchoolLevel')->whereIn('student_id',$this->student_ids)->where('school_year_id',$activeSchoolYear->id)->first()->SchoolLevel->id;
    
            if($this->entryTotal){
                for ($i=0; $i < $this->entryTotal; $i++) { 
                    $queryPettyCash[] = [
                        'petty_cash_code' => '',
                        'petty_cash_title'  => "BAYAR SPP <b>{$this->student_name[$i]}</b> BULAN <b>{$this->payment_month[$i]}</b> KELAS <b>{$this->classroom}</b> TAHUN AJARAN <b>{$activeSchoolYear->school_year_name} </b>",
                        'debit' => $this->amount[$i],
                        'credit' => 0,
                        'description' => NULL,
                        'school_level_id' => $getSchoolLevel,
                        'payment_way_id' => $this->PaymentWay,
                        'trx_date' => Helper::timestampOnDb(),
                        'created_by' => backpack_user()->id,
                        'updated_by' => backpack_user()->id,
                        'created_at' =>  Helper::timestampOnDb(),
                        'updated_at' => Helper::timestampOnDb(),
                    ];
                    if(Helper::sanitizeMoneyFormat($this->personal_discount[$i])){
                        $queryPettyCash[] = [
                            'petty_cash_code' => '',
                            'petty_cash_title'  => "DISCOUNT SPP <b>{$this->student_name[$i]}</b> BULAN <b>{$this->payment_month[$i]}</b> KELAS <b>{$this->classroom}</b> TAHUN AJARAN <b>{$activeSchoolYear->school_year_name} </b>",
                            'debit' => 0,
                            'credit' => Helper::sanitizeMoneyFormat($this->personal_discount[$i]),
                            'description' => NULL,
                            'school_level_id' => $getSchoolLevel,
                            'payment_way_id' => $this->PaymentWay,
                            'trx_date' => Helper::timestampOnDb(),
                            'created_by' => backpack_user()->id,
                            'updated_by' => backpack_user()->id,
                            'created_at' =>  Helper::timestampOnDb(),
                            'updated_at' => Helper::timestampOnDb(),
                        ];
                    }

                    $personal_discount = Helper::sanitizeMoneyFormat($this->personal_discount[$i]);
                    $cases_personal_discount[] = "WHEN id = {$this->entry[$i]['id']} THEN {$personal_discount}";

                    if(min($this->payment_month_id) == $this->entry[$i]['payment_for_month']){
                        $fine_discount = Helper::sanitizeMoneyFormat($this->fineDiscount);
                    }else {
                        $fine_discount = 0;
                    }

                    $cases_fine_discount[] = "WHEN id = {$this->entry[$i]['id']} THEN {$fine_discount}";
                    
                }
                // dd();
                if($this->fineAmount){
                    $minMonth = Helper::getSchoolYearMonthById(min($this->payment_month_id));
                    $queryPettyCash[] = [
                        'petty_cash_code' => '',
                        'petty_cash_title'  => "BAYAR DENDA <b>{$this->student_name[0]}</b> BULAN <b>{$minMonth}</b> KELAS <b>{$this->classroom}</b> TAHUN AJARAN <b>{$activeSchoolYear->school_year_name}</b>",
                        'debit' => $this->fineAmount,
                        'credit' => 0,
                        'description' => NULL,
                        'school_level_id' => $getSchoolLevel,
                        'payment_way_id' => $this->PaymentWay,
                        'trx_date' => Helper::timestampOnDb(),
                        'created_by' => backpack_user()->id,
                        'updated_by' => backpack_user()->id,
                        'created_at' =>  Helper::timestampOnDb(),
                        'updated_at' => Helper::timestampOnDb(),
                    ];
                    if(Helper::sanitizeMoneyFormat($this->fineDiscount)){
                        $queryPettyCash[] = [
                            'petty_cash_code' => '',
                            'petty_cash_title'  => "DISCOUNT DENDA <b>{$this->student_name[0]}</b> BULAN <b>{$minMonth}</b> KELAS <b>{$this->classroom}</b> TAHUN AJARAN <b>{$activeSchoolYear->school_year_name}</b>",
                            'debit' => 0,
                            'credit' => Helper::sanitizeMoneyFormat($this->fineDiscount),
                            'description' => NULL,
                            'school_level_id' => $getSchoolLevel,
                            'payment_way_id' => $this->PaymentWay,
                            'trx_date' => Helper::timestampOnDb(),
                            'created_by' => backpack_user()->id,
                            'updated_by' => backpack_user()->id,
                            'created_at' =>  Helper::timestampOnDb(),
                            'updated_at' => Helper::timestampOnDb(),
                        ];
                    }
                }

                $generatePettyCashNumber = Helper::generatePettyCashNumber(count($queryPettyCash));
                for ($i=1; $i <= count($generatePettyCashNumber); $i++) { 
                    $queryPettyCash[$i-1]['petty_cash_code'] = $generatePettyCashNumber[$i];
                }
                
            }
            
            $InvoiceGroup = InvoiceGroup::create([
                'invoice_group_number' => Helper::generateInvoiceGroupNumber(1)[1]
            ]);

            

            $ids = implode(',', $this->entryIds);
            $cases_personal_discount = implode(' ', $cases_personal_discount);
            $cases_fine_discount = implode(' ', $cases_fine_discount);
            if (!empty($ids)) {
                \DB::update("UPDATE invoices 
                SET invoice_group_id = {$InvoiceGroup->id}, 
                personal_discount = CASE {$cases_personal_discount} END,
                fine_discount = CASE {$cases_fine_discount} END,
                payment_way_id = {$this->PaymentWay},
                description = '{$this->description}',
                paid_date = '{$this->PaymentDate}'
                WHERE ID IN ({$ids})");
            }

            PettyCash::insert($queryPettyCash);
            $this->buttonStatus = true;
            $this->print_id = $InvoiceGroup->id;
        });
    }

    public function saveWithRedirectToInvoice(){
        $this->save();
        \Alert::add('success', 'Success paying the invoice')->flash();
        return redirect()->route('invoice.index');
    }
}
