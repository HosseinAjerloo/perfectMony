<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const users=
        [
            'name'=>"حسین",
            'family'=>"آجرلو",
            'mobile'=>"09386542718",
        ];
    protected $fillable = [
        'name',
        'email',
        'password',
        "family",
        "national_code",
        "username",
        "mobile",
        "tel",
        "address",
        "is_active",
        "type"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function  financeTransactions()
    {
        return $this->hasMany(FinanceTransaction::class,'user_id');
    }

    public function getCreaditBalance()
    {
        return $this->financeTransactions()->orderBy('id','desc')->first()->creadit_balance??0;
    }
}
