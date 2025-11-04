<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tax_code',
        'address',
        'ceo',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
