<?php

namespace App\Observers;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentObserver
{

    /**
     * Handle the Student "created" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function created(Student $student)
    {
        //
        // DB::beginTransaction();
        // try {
          
            // $SSH = DB::table('student_school_histories')->insert([
            //     'student_id' => $student->id,
            //     'school_year_id' => request()->school_year_id,
            //     'classroom_id' => request()->classroom_id
            // ]);
            
            // $SFD = DB::table('student_funding_details')->insert([
            //     'student_id' => $student->id,
            //     'school_year_id' => request()->school_year_id,
            //     'spp_master_id' => request()->spp_master_id,
            //     'personal_discount' => request()->personal_discount,
            // ]);

        //     if($SSH & $SFD){
        //         DB::commit();
        //     }else {
        //         DB::rollback();
        //     }

        // }catch(\Exception $e) {
        //     DB::rollback();
        // }

        DB::table('student_school_histories')->insert([
            'student_id' => $student->id,
            'school_year_id' => request()->school_year_id,
            'desc' => 'Fresh Year',
            'classroom_id' => request()->classroom_id
        ]);
        
        DB::table('student_funding_details')->insert([
            'student_id' => $student->id,
            'school_year_id' => request()->school_year_id,
            'spp_master_id' => request()->spp_master_id,
            'personal_discount' => request()->personal_discount,
        ]);

        DB::table('invoice')->insert([
            
        ]);
    }

    /**
     * Handle the Student "updated" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function updated(Student $student)
    {
        //
    }
}
