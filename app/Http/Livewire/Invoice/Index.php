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
        $this->studentModel = Student::with('Invoices')->get();
    }

    public function updatedStudentForm(){
        // $this->studentForm = NULL;
        $this->studentInvoiceModel = NULL;
    }

    public function FilterMonth($filter = 'THIS MONTH'){
        $this->FilterMonth_ = $filter;
        $this->Checkbox_MonthId = [];
        $this->validate();
        // dd('as');
        if($this->studentForm){
            if($filter == 'THIS MONTH'){
                $this->studentInvoiceModel = $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices->where('paid_date','=',NULL)->where('payment_for_month','<=',Helper::getSchoolYearMonth(Helper::getMonthById(date('m'))));
            }
            if($filter == 'PAID'){
                $this->studentInvoiceModel = $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices->where('paid_date','!=',NULL);
            }
            if($filter == 'UNPAID'){
                $this->studentInvoiceModel = $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices->where('paid_date','=',NULL);
            }
            if($filter == 'ALL'){
                $this->studentInvoiceModel =  $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices;
            }
        }
    }

    public function render()
    {
        return view('livewire.invoice.index');
    }

    public function checkStudentExist(){
        $check = Student::with('Invoices')->where('student_name','like','%'.$this->studentForm.'%')->get();
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
        $this->validate();

        if($this->checkStudentExist()){
            if($this->FilterMonth_){
                $this->FilterMonth($this->FilterMonth_);
            }else {
                // $this->studentInvoiceModel = $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices->where('payment_for_month',Helper::getSchoolYearMonth(Helper::getMonthById(date('m'))));
    
                $this->studentInvoiceModel = $this->studentModel->where('student_name',$this->studentForm)->first()->Invoices->where('paid_date','=',NULL)->where('payment_for_month','<=',Helper::getSchoolYearMonth(Helper::getMonthById(date('m'))));
            }
        }
    }

    public function pay(){
        $this->validate();
        if(count($this->Checkbox_MonthId)){
            $id = base64_encode(serialize($this->Checkbox_MonthId));
            return redirect()->route('invoice.PreviewInvoice', compact('id'));
        }
    }
}
