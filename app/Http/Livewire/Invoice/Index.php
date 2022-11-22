<?php

namespace App\Http\Livewire\Invoice;

use App\Helpers\Helper;
use App\Models\Student;
use Livewire\Component;

class Index extends Component
{
    public $studentModel;
    public $studentInvoiceModel;
    public $studentForm;
    public $FilterMonth_;
    public $Checkbox_MonthId = [];

    public $ListTheStudents;

    protected $rules = [
        'studentForm' => 'required|string',
    ];

    public function mount(){
        // $this->studentModel = Student::with('Invoices')->get();
    }

    public function updatedStudentForm(){
        // $this->studentForm = NULL;
        $this->studentInvoiceModel = NULL;
    }

    public function FilterMonth($filter = 'THIS MONTH'){
        $this->FilterMonth_ = $filter;
        $this->Checkbox_MonthId = [];
        $this->validate();
        if($this->checkStudentExist()){
            if($filter == 'THIS MONTH'){
                // $this->studentInvoiceModel = $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices->where('paid_date','=',NULL)->where('payment_for_month','<=',Helper::getSchoolYearMonth(Helper::getMonthById(date('m'))));

                $this->studentInvoiceModel = Student::with(['Invoices' => function ($q) {
                    $q->with('SchoolYear')->where('paid_date','=',NULL)->where('payment_for_month','<=',Helper::getSchoolYearMonth(Helper::getMonthById(date('m'))))->where('school_year_id',Helper::getActiveSchoolYear());
                }])->where('student_name',$this->studentForm)->first()->Invoices;
            }
            if($filter == 'PAID'){
                
                // $this->studentInvoiceModel = $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices->where('paid_date','!=',NULL);
                $this->studentInvoiceModel = Student::with(['Invoices' => function ($q) {
                    $q->with('SchoolYear')->where('paid_date','!=',NULL);
                }])->where('student_name',$this->studentForm)->first()->Invoices;
            }
            if($filter == 'UNPAID'){
                // $this->studentInvoiceModel = $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices->where('paid_date','=',NULL);
                $this->studentInvoiceModel = Student::with(['Invoices' => function ($q) {
                    $q->with('SchoolYear')->where('paid_date','=',NULL);
                }])->where('student_name',$this->studentForm)->first()->Invoices;
            }
            if($filter == 'ALL'){
                
                // $this->studentInvoiceModel =  $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices;
                $this->studentInvoiceModel = Student::with(['Invoices.SchoolYear'])->where('student_name',$this->studentForm)->first()->Invoices;
                // dd($this->studentInvoiceModel);
            }
        }
    }

    public function render()
    {
        return view('livewire.invoice.index');
    }

    public function checkStudentExist(){
        $check = Student::where('student_name','like','%'.$this->studentForm.'%')->get();
        
        if($check->count() == 1){
            $this->studentForm = $check->first()->student_name;
            $this->ListTheStudents = NULL;
            return true;
        }elseif($check->count() > 1){
            $this->ListTheStudents = $check;
            return false;
        }else {
            $this->addError('studentForm', 'Siswa tidak ditemukan');
            $this->ListTheStudents = NULL;
            return false;
        }
    }

    public function SetstudentForm($student){
        $this->studentForm = $student;
        $this->ListTheStudents = NULL;
        $this->filter();

    }

    public function filter(){
        // dd('as');
        $this->validate();

        if($this->checkStudentExist()){
            
            
            if($this->FilterMonth_){
                $this->FilterMonth($this->FilterMonth_);
            }else {
                
                // $this->studentInvoiceModel = $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices->where('payment_for_month',Helper::getSchoolYearMonth(Helper::getMonthById(date('m'))));
    
                // $this->studentInvoiceModel = $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices->where('paid_date','=',NULL)->where('payment_for_month','<=',Helper::getSchoolYearMonth(Helper::getMonthById(date('m'))));

                $this->studentInvoiceModel = Student::with(['Invoices' => function ($q) {
                    $q->with('SchoolYear')->where('paid_date','=',NULL)->where('payment_for_month','<=',Helper::getSchoolYearMonth(Helper::getMonthById(date('m'))))->where('school_year_id',Helper::getActiveSchoolYear());
                }])->where('student_name',$this->studentForm)->first()->Invoices;
                // dd($this->studentInvoiceModel);
            }
        }
    }

    public function pay(){
        $this->validate();
        if(count($this->Checkbox_MonthId)){
            $id = base64_encode(serialize($this->Checkbox_MonthId));
            return redirect()->route('invoice.PreviewInvoice', compact('id'));
        }else {
            // $this->addError('warningCheckboxEmpty', 'Silahkan pilihdata dahulu');
        }
    }
}
