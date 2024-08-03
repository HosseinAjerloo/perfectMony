<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceTransaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['user_id','payment_id','voucher_id','voucher_id','amount','type','creadit_balance','description','time_price_of_dollars'];
    public function voucher()
    {
        return $this->belongsTo(Voucher::class,'voucher_id');
    }
}
