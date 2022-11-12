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

    public function sumDebit($date = null){
        if($date){
            return $this->where('trx_date',$date)->sum('debit');
        }
        return $this->sum('debit');
    }

    public function sumCredit($date = null){
        if($date){
            return $this->where('trx_date',$date)->sum('credit');
        }
        return $this->sum('credit');
    }

    public function sumCreditAndDebitMoneyFormat($date = null){
        // return $this->sumDebit() - $this->sumCredit();
        return Helper::MoneyFormat($this->sumDebit($date) - $this->sumCredit($date));
    }
}
