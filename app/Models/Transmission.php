<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transmission extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['user_id','finance_id','payee_account','payment_batch_num','voucher_num','voucher_amount'];
    public function financeTransaction()
    {
        $this->belongsTo(FinanceTransaction::class,'finance_id');
    }
}
