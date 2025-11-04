<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contract_number',
        'date_signed',
        'customer_id',
        'date_desk',
        'contract_value',
        'deposit',
        'status',
        'pdf_file',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
