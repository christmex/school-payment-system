<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolYear extends Model
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
        'school_year_name',
        'school_year_start',
        'school_year_end',
        'date_of_fine',
        'fine_amount',
        'is_active'
    ];

    
    // public function setSchoolYearNameAttribute($value)
    // { 
    //     if($value == null){
    //         $this->attributes['school_year_name'] =  $this->school_year_start;
    //     }
    //     // if($value == null){
    //     //     $this->school_year_name =  $this->school_year_start.'/'.$this->school_year_end;
    //     // }
    // }
}
