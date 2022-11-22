<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Classroom;
use App\Models\SppMaster;
use App\Models\SchoolYear;
use App\Models\StudentSchoolHistory;

class NaikKelas extends Component
{
    public $StudentModel;
    public $SchoolYearModel;
    public $ClassroomModel;
    public $SppMasterModel;
    public $TeacherModel;

    public $Query_SchoolYear;
    public $toggleCheckbox = false;
    public $Checkbox_StudenId = [];

    public $Form_PreviousClassroom;
    public $Form_AfterClassroom;
    public $Form_SchoolYear;
    public $Form_NewSchoolYear;
    public $Form_SppMaster;
    public $Form_Teacher;

    public $Form_SchoolYear_id;
    public $Form_NewSchoolYear_id;

    protected $rules = [
        'Form_PreviousClassroom' => 'required|Integer',
        'Form_AfterClassroom' => 'required|Integer|different:Form_PreviousClassroom',
        'Form_SppMaster' => 'required|Integer',
    ];
 

    public function mount(){
        
        // $this->redirect('/school-year');
        //     $this->redirectCustom($this->SchoolYearModel);
        // $this->Query_SchoolYear = SchoolYear::where('is_active', true)->first();
        $Query_SchoolYear = SchoolYear::all();
        $this->SppMasterModel = SppMaster::all();
        $this->TeacherModel = Teacher::all();
        $this->ClassroomModel = Classroom::all();
        $this->Query_SchoolYear = $Query_SchoolYear->where('is_active', true)->first();

        $this->SchoolYearModel =  $Query_SchoolYear->where('school_year_start','=',$this->Query_SchoolYear->school_year_start + 1)->first();
        // if SchoolYearModel not found then redirect to create new school year
        if($this->SchoolYearModel){
            $this->Form_SchoolYear =  $this->Query_SchoolYear->school_year_name;
            $this->Form_NewSchoolYear = $this->SchoolYearModel->school_year_name;
    
            $this->Form_SchoolYear_id =  $this->Query_SchoolYear->id;
            $this->Form_NewSchoolYear_id = $this->SchoolYearModel->id;
        }
        
        
    }

    public function redirectCustom(){
        // show alert first then redirect
        \Alert::add('warning', 'Silahkan buat tahun ajaran baru '.($this->Query_SchoolYear->school_year_start + 1).'/'.$this->Query_SchoolYear->school_year_start + 2)->flash();
        return redirect()->to(route('school-year.index'));
    }

    public function updatedFormPreviousClassroom(){
        if(!$this->Form_SchoolYear){
            $this->redirectCustom();
        }
        if($this->Form_PreviousClassroom){
            $this->Checkbox_StudenId = [];
            $this->StudentModel = StudentSchoolHistory::with('student')->where('classroom_id',$this->Form_PreviousClassroom)->where('school_year_id',$this->Query_SchoolYear->id)->get();
            foreach ($this->StudentModel as $key => $value) {
                $this->Checkbox_StudenId[] = $value->id;
            }
        }
    }

    public function render()
    {
        return view('livewire.naik-kelas');
    }

    public function save(){
        // validation
        $this->validate();

        $ToarrayClassroomModel = $this->ClassroomModel->toArray();
        $arrayPreviousClassroom;
        $arrayAfterClassroom;
        
        foreach ($ToarrayClassroomModel as $key => $array) {
            if($array['id'] == $this->Form_PreviousClassroom){
                $arrayPreviousClassroom = $array;
            }

            if($array['id'] == $this->Form_AfterClassroom){
                $arrayAfterClassroom = $array;
            }
        }
        // check if the classroom level are equal or below current classroom if true return error
        if($arrayPreviousClassroom['school_level_id'] == $arrayAfterClassroom['school_level_id']){
            $this->addError('Form_AfterClassroom', 'form after classroom dan form previous classroom harus berbeda level');
        }else {
            DB::transaction(function () use ($arrayPreviousClassroom,$arrayAfterClassroom ) {

                // Check if students and the school years already exist
                $Check_StudentSchoolHistory = StudentSchoolHistory::where('school_year_id','=',$this->Form_NewSchoolYear_id)->get()->toArray();
                
                $query_student_school_histories = [];
                $query_student_funding_details = [];

                $queryInvoice = [];
                $joinMonth = 1;
                $getAllDueDate = Helper::getAllDueDate($joinMonth);
                $getSchoolYearMonthAll = Helper::getSchoolYearMonthAll($joinMonth,count($getAllDueDate));
                $generateInvoiceNumber = Helper::generateInvoiceNumber(count($getAllDueDate));
                

                for ($i=0; $i < count($this->Checkbox_StudenId); $i++) {
                    if(!Helper::in_array_r($Check_StudentSchoolHistory,'student_id',$this->Checkbox_StudenId[$i])){
                        $query_student_school_histories[] = [
                            'student_id' => $this->Checkbox_StudenId[$i],
                            'school_year_id' => $this->Form_NewSchoolYear_id,
                            'desc' => "Naik kelas ke {$arrayAfterClassroom['classroom_name']} dari Kelas {$arrayPreviousClassroom['classroom_name']} di Tahun Ajaran {$this->Form_NewSchoolYear}",
                            'classroom_id' => $arrayAfterClassroom['id'],
                            'created_by' => backpack_user()->id,
                            'updated_by' => backpack_user()->id,
                            'created_at' =>  Helper::timestampOnDb(),
                            'updated_at' => Helper::timestampOnDb(),
                        ];
    
                        $query_student_funding_details[] = [
                            'student_id' => $this->Checkbox_StudenId[$i],
                            'school_year_id' => $this->Form_NewSchoolYear_id,
                            'spp_master_id' => (int)$this->Form_SppMaster,
                            'personal_discount' => 0,
                            'created_by' => backpack_user()->id,
                            'updated_by' => backpack_user()->id,
                            'created_at' =>  Helper::timestampOnDb(),
                            'updated_at' => Helper::timestampOnDb(),
                        ];
    
                        for ($j=1; $j <= count($getAllDueDate); $j++) { 
                            $queryInvoice[] = [
                                'invoice_number' => $generateInvoiceNumber[$j],
                                'student_id' => $this->Checkbox_StudenId[$i],
                                'school_year_id' => $this->Form_NewSchoolYear_id,
                                'classroom_id' => $arrayAfterClassroom['id'],
                                'payment_for_month' => $getSchoolYearMonthAll[$j],
                                'amount' => $this->SppMasterModel->find($this->Form_SppMaster)->amount ,
                                'fine_amount' => 0,
                                'personal_discount' => 0,
                                'fine_discount' => 0,
                                'due_date' => $getAllDueDate[$j],
                                'paid_date' => NULL,
                                'payment_way_id' => NULL,
                                'description' => NULL,
                                'created_by' => backpack_user()->id,
                                'updated_by' => backpack_user()->id,
                                'created_at' =>  Helper::timestampOnDb(),
                                'updated_at' => Helper::timestampOnDb(),
                            ];
                        }
                    }
                }

                DB::table('student_school_histories')->insert($query_student_school_histories);
                DB::table('student_funding_details')->insert($query_student_funding_details);
                DB::table('invoices')->insert($queryInvoice);

                // check if teacher form exist then update classroom teacher_id
                if($this->Form_Teacher){
                    Classroom::where('id',$this->Form_AfterClassroom)->update([
                        'teacher_id' => $this->Form_Teacher
                    ]);
                }
            });

            // Reset after saving
            $this->Form_PreviousClassroom = NULL;
            $this->Form_AfterClassroom = NULL;
            $this->Form_SppMaster = NULL;
            $this->Form_Teacher = NULL;
            $this->StudentModel = NULL;
            $this->Checkbox_StudenId = [];


            // Send notify dispact to the browser with livewire 
            \Alert::add('success', 'Data berhasil tersimpan')->flash();
            return redirect()->to(route('naik-kelas.index'));
        }

        
    }
}
