<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Invoice;
use App\Models\Setting;
use App\Models\Student;
use App\Models\SppMaster;
use App\Models\SchoolYear;
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
        DB::table('student_school_histories')->insert([
            'student_id' => $student->id,
            'school_year_id' => request()->school_year_id,
            'desc' => 'Fresh Year',
            'classroom_id' => request()->classroom_id,
            'created_by' => backpack_user()->id,
            'updated_by' => backpack_user()->id,
            'created_at' =>  Helper::timestampOnDb(),
            'updated_at' => Helper::timestampOnDb(),
        ]);
        
        DB::table('student_funding_details')->insert([
            'student_id' => $student->id,
            'school_year_id' => request()->school_year_id,
            'spp_master_id' => request()->spp_master_id,
            'personal_discount' => request()->personal_discount,
            'created_by' => backpack_user()->id,
            'updated_by' => backpack_user()->id,
            'created_at' =>  Helper::timestampOnDb(),
            'updated_at' => Helper::timestampOnDb(),
        ]);

        $SppMaster = SppMaster::find(request()->spp_master_id);
        $schoolyear = SchoolYear::find(request()->school_year_id);
        $fineData = Helper::calculateFineNewStudent();
        $joinMonth = request()->join_month;
        $getAllDueDate = Helper::getAllDueDate($joinMonth);
        $getNormalMonthAll = Helper::getNormalMonthAll($joinMonth,count($getAllDueDate));
        $queryInvoice = [];

        // Fitur jika tahun ini sudah selesai, maka generate kembali invoice number dari awal yaitu 1001 dan di bagian akhir tahunnya di buat tahun yg saat ini

        $generateInvoiceNumber = Helper::generateInvoiceNumber(count($getAllDueDate));
        for ($i=1; $i <= count($getAllDueDate); $i++) { 
            $queryInvoice[] = [
                'invoice_number' => $generateInvoiceNumber[$i],
                'student_id' => $student->id,
                'school_year_id' => request()->school_year_id,
                'payment_for_month' => $getNormalMonthAll[$i],
                'amount' => $SppMaster->amount,
                'fine_amount' => $fineData['fine'],
                'personal_discount' => request()->personal_discount,
                'fine_discount' => 0,
                'due_date' => $getAllDueDate[$i],
                'paid_date' => NULL,
                'payment_way_id' => NULL,
                // 'description' => 'SPP '.Helper::getNormalMonth($joinMonth, Helper::Months()).' '.$schoolyear->school_year_name,
                'description' => NULL,
                'created_by' => backpack_user()->id,
                'updated_by' => backpack_user()->id,
                'created_at' =>  Helper::timestampOnDb(),
                'updated_at' => Helper::timestampOnDb(),
            ];
        }
        
        DB::table('invoices')->insert($queryInvoice);
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
