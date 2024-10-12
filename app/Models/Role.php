<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    const RoleName=['name'=>'گیرندگان هشدار'];
    use HasFactory,SoftDeletes;
    protected $fillable=['name'];

    protected function users()
    {
        return $this->belongsToMany(User::class,'role_user','role_id','user_id','id','id');
    }
}
