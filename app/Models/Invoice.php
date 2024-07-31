<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['user_id','service_id','disscount_code_id','final_amount','type','service_id_custom','status'];
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
}
