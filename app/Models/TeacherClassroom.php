<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherClassroom extends Model
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
        'classroom_id',
        'school_year_id',
        'teacher_id'
    ];

    public function Classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'classroom_id','id');
    }

    public function SchoolYear()
    {
        return $this->belongsTo('App\Models\SchoolYear', 'school_year_id','id');
    }

    public function Teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'teacher_id','id');
    }
}
