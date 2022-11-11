<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
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
        'petty_cash_code',
        'petty_cash_title',
        // 'petty_cash_type',
        'debit',
        'credit',
        'description',
        // 'student_id',
        // 'user_id',
        'trx_date'
    ];
}
