<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSchoolHistory extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use \App\Traits\CreatedUpdatedBy;

    protected $fillable = [
        'student_id',
        'school_year_id',
        'classroom_id',
        'desc',
    ];

    public function SchoolYear()
    {
        return $this->belongsTo('App\Models\SchoolYear', 'school_year_id','id');
    }

    public function Student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id','id');
    }

    public function Classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'classroom_id','id');
    }

}
