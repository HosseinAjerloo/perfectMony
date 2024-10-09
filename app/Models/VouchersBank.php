<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VouchersBank extends Model
{
    use HasFactory,SoftDeletes;
    public $table='vouchers_bank';
    protected $fillable=['serial','code','amount','status','description'];
}
