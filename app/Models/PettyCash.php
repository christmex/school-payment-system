<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'school_level_id',
        'payment_way_id',
        // 'student_id',
        // 'user_id',
        'trx_date'
    ];

    public function setPettyCashCodeAttribute($value)
    { 
        if($value == null){
            $this->attributes['petty_cash_code'] =  Helper::generatePettyCashNumber(1)[1];
        }
    }

    public function getCreditMoneyFormatAttribute()
    { 
        return Helper::moneyFormat($this->credit);
    }

    public function getDebitMoneyFormatAttribute()
    { 
        return Helper::moneyFormat($this->debit);
    }

    public function sumCreditAndDebitToday(){
        $debit = $this->sum('debit');
        $credit = $this->sum('credit');
        return $debit - $credit;
    }
    
    public function sumDebit($date = null, $enddate = null, $search = NULL){
        // if($date ){
        //     return $this->where('trx_date',$date)->sum('debit');
        // }
        return $this->whereBetween('trx_date',[$date, $enddate])->where('petty_cash_title', 'like', '%'.$search.'%')->sum('debit');
    }

    public function sumCredit($date = null, $enddate = null, $search = NULL){
        // if($date){
        //     return $this->where('trx_date',$date)->sum('credit');
        // }
        return $this->whereBetween('trx_date',[$date, $enddate])->where('petty_cash_title', 'like', '%'.$search.'%')->sum('credit');
    }

    public function countTrx($date = null, $enddate = null, $search = NULL){
        return $this->whereBetween('trx_date',[$date, $enddate])->where('petty_cash_title', 'like', '%'.$search.'%')->get()->count();
    }

    public function sumCreditAndDebitMoneyFormat($date = null, $enddate = null, $search = NULL){
        // return $this->sumDebit() - $this->sumCredit();
        return Helper::MoneyFormat($this->sumDebit($date, $enddate,$search) - $this->sumCredit($date, $enddate,$search));
    }
}
