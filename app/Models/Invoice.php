<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use \App\Traits\CreatedUpdatedBy;

    protected $fillable = [
        'payment_invoice',
        'student_id',
        'cost',
        'teacher_classroom_id',
        'school_year_id',
        'payment_for_month',
        'description',
    ]; 

    public function TeacherClassroom()
    {
        return $this->belongsTo('App\Models\TeacherClassroom', 'teacher_classroom_id','id');
    }

    public function SchoolYear()
    {
        return $this->belongsTo('App\Models\SchoolYear', 'school_year_id','id');
    }

    public function Student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id','id');
    }

    public function getMonthById(){
        return Helper::getMonthById($this->payment_for_month);
    }

    public function SppMaster()
    {
        return $this->belongsTo('App\Models\SppMaster', 'spp_master_id','id');
    }
}
