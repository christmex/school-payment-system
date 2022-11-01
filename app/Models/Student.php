<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use \App\Traits\CreatedUpdatedBy;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_name',
        // 'sex',
        'student_phone_number',
        'teacher_classroom_id',
        'spp_master_id',
        'personal_discount',
        'join_month',
        'school_year_id'
    ];

    // accessors-and-mutators
    protected function personalDiscount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Helper::moneyFormat($value),
        );
    }

    protected function sppMasterId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
        );
    }

    public function TeacherClassroom()
    {
        return $this->belongsTo('App\Models\TeacherClassroom', 'teacher_classroom_id','id');
    }

    public function SppMaster()
    {
        return $this->belongsTo('App\Models\SppMaster', 'spp_master_id','id');
    }

    public function SppMasterGet(){
        return Helper::moneyFormat($this->SppMaster()->first()->amount);
    }

    public function SchoolYear()
    {
        return $this->belongsTo('App\Models\SchoolYear', 'school_year_id','id');
    }

    public function getMonthById(){
        // dd($this);
        return Helper::getMonthById($this->join_month);
    }
    
}
