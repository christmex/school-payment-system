<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use \App\Traits\CreatedUpdatedBy;

    protected $fillable = [
        'invoice_group_id',
        'invoice_number',
        'student_id',
        'school_year_id',
        'classroom_id',
        'payment_for_month',
        'amount',
        'fine_amount',
        'personal_discount',
        'fine_discount',
        'due_date',
        'paid_date',
        'payment_way_id',
        'description'   
    ]; 

    protected function dueDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Helper::dateHumanDiff($value),
        );
    }

    public function getAmountMoneyFormatAttribute()
    { 
        return Helper::moneyFormat($this->amount);
    }

    public function getPersonalDiscountMoneyFormatAttribute()
    { 
        return Helper::moneyFormat($this->personal_discount);
    }

    public function getSubTotalAttribute()
    { 
        return $this->amount - $this->personal_discount;
    }

    public function getSubTotalMoneyFormatAttribute()
    { 
        return Helper::moneyFormat($this->amount - $this->personal_discount);
    }

    public function getPaymentForMonthInHumanWayAttribute()
    { 
        return Helper::getNormalMonthName($this->payment_for_month);
        // return Helper::getMonthById($this->payment_for_month);
        // return Helper::getMonthById($this->payment_for_month);
        // return $this->attributes['payment_for_month'];
    }

    public function Classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'classroom_id','id');
    }

    public function SchoolYear()
    {
        return $this->belongsTo('App\Models\SchoolYear', 'school_year_id','id');
    }

    public function Student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id','id');
    }

    public function InvoiceGroup()
    {
        return $this->belongsTo('App\Models\InvoiceGroup', 'invoice_group_id','id');
    }

    public function getNormalMonth(){
        return Helper::getNormalMonthName($this->payment_for_month);
    }

    // public function SppMaster()
    // {
    //     return $this->belongsTo('App\Models\SppMaster', 'spp_master_id','id');
    // }
}
