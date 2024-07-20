<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['name','amount','description'];
    const Services=
        [
            [
                'name'=>"دلار",
                "amount"=>"1",
                "description"=>"سرویس یک دلاری"
            ],
            [
                'name'=>"دلار",
                "amount"=>"2",
                "description"=>"سرویس دو دلاری"
            ],
            [
                'name'=>"دلار",
                "amount"=>"3",
                "description"=>"سرویس سه دلاری"
            ],
            [
                'name'=>"دلار",
                "amount"=>"4",
                "description"=>"سرویس چهار دلاری"
            ],
            [
                'name'=>"دلار",
                "amount"=>"5",
                "description"=>"سرویس پنج دلاری"
            ],
        ];
}
