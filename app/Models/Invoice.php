<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['user_id','service_id','disscount_code_id','final_amount','type','service_id_custom','status','time_price_of_dollars'];
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
    public function voucherAmount()
    {
        if ($this->service_id) {
            return $this->service->amount;
        } else {
            return $this->service_id_custom;
        }
    }
}
