<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'company_tax_code',
        'company_name',
        'contact_point',
        'note',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_tax_code', 'tax_code');
    }
}
