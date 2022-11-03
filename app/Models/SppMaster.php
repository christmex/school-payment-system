<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SppMaster extends Model
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
        'spp_name',
        'amount'
    ];


    // protected function amount(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => Helper::moneyFormat($value),
    //     );
    // }

    // protected function amountMoneyFormat(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value,
    //     ); 
    // }

    public function getAmountMoneyFormatAttribute()
    { 
      return Helper::moneyFormat($this->amount);
    }
    
}
