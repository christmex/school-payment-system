<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceGroup extends Model
{
    use HasFactory;
    use \App\Traits\CreatedUpdatedBy;
    
    protected $fillable = [
        'invoice_group_number'
    ]; 
}
