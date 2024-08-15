<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transmission extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['user_id','finance_id','payee_account_name','payee_account','payer_account','payment_amount','payment_batch_num','invoice_id'];
    public function financeTransaction()
    {
        $this->belongsTo(FinanceTransaction::class,'finance_id');
    }
}
