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
    use \App\Traits\getActiveSchoolYear;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_name',
        // 'sex',
        'student_phone_number',
        // 'teacher_classroom_id',
        // 'spp_master_id',
        // 'personal_discount',
        // 'join_month',
        // 'school_year_id'
    ];

    // Ccostum var
    // protected $ActiveSchoolYear;


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    
    
    // public function getMonthById(){
    //     // dd($this);
    //     return Helper::getMonthById($this->join_month);
    // }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function Classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'teacher_classroom_id','id');
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

    // public function StudentHistory(){
    //     return $this->hasMany(StudentSchoolHistory::class, 'student_id', 'id');
    // }

    public function StudentLevel(){
        return $this->belongsToThrough(SchoolLevel::class, [Classroom::class, StudentSchoolHistory::class]);
    }

    public function StudentSchoolHistory()
    {
        return $this->hasMany(StudentSchoolHistory::class)->with('Classroom')->where('school_year_id', $this->ActiveSchoolYear);
    }

    public function StudentFundingDetail()
    {
        return $this->hasMany(StudentFundingDetail::class)->with('SppMaster')->where('school_year_id', $this->ActiveSchoolYear);
    }

    public function Invoices()
    {
        return $this->hasMany(Invoice::class);
    }


    // public function getStudentFundingDetail()
    // {
    //     $data = $this->StudentFundingDetail()->with('SppMaster')->first();
    //     return $data->SppMaster->amount;
    // }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
        // protected function personalDiscount(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => Helper::moneyFormat($value),
    //     );
    // }

    // protected function sppMasterId(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value,
    //     );
    // }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    
}
