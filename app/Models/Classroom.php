<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
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
        'school_level_id',
        'classroom_name',
        'teacher_id'
    ];

    public function SchoolLevel()
    {
        return $this->belongsTo('App\Models\SchoolLevel', 'school_level_id','id');
    }

    public function Teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'teacher_id','id');
    }
}
