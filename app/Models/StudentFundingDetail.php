<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentFundingDetail extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use \App\Traits\CreatedUpdatedBy;

    protected $fillable = [
        'student_id',
        'school_year_id',
        'spp_master_id',
        'personal_discount',
    ];

    public function SchoolYear()
    {
        return $this->belongsTo('App\Models\SchoolYear', 'school_year_id','id');
    }

    public function Student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id','id');
    }

    
    public function SppMaster()
    {
        return $this->belongsTo('App\Models\SppMaster', 'spp_master_id','id');
    }
    
    // public function SppMasterGet(){
    //     return Helper::moneyFormat($this->SppMaster()->first()->amount);
    // }

}
