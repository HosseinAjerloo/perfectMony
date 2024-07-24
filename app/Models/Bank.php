<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['name','url','username','password','terminal_id','description','is_active','logo_url'];
    const Banks=[
        [
            'name'=>'درگاه پرداخت بانک سامان',
            'url'=>'https://sep.shaparak.ir/MobilePG/MobilePayment',
            'terminal_id'=>13595227,
            'description'=>'درگاه پرداخت بانک سامان',
            'is_active'=>1,
            'logo_url'=>'src/images/samanBank.png'


        ]
    ];
}
