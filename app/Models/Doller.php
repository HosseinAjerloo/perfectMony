<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doller extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['amount_to_rials', 'description'];
    const Dollers =
        [
            [
                'amount_to_rials' => 573300,
                'description' => 'قیمت روز دلار'
            ]
        ];

    Const Commission=15;
    public function DollarRateWithAddedValue()
    {
        return ceil(((($this->amount_to_rials*Doller::Commission)/100)+$this->amount_to_rials));
    }
}
