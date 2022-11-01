<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
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
        'payment_invoice',
        'student_id',
        'spp_master_id',
        'school_year_id',
        'payment_for_month',
        'fine_amount',
        'discount_fine',
        'total_amount',
        'discount_personal',
        'paid_amount',
        'description',
        'payment_way_id',
        'payment_date',
        'is_paid',
        'user_id'
    ];
}
