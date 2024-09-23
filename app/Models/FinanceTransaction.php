<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'payment_id', 'voucher_id', 'voucher_id', 'amount', 'type', 'creadit_balance', 'description', 'time_price_of_dollars','status'];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function transmission()
    {
        return $this->hasOne(Transmission::class,'finance_id');
    }

    public function scopePurchaseLimit(Builder $query, $Date = null, $mount = null): void
    {
        $user = Auth::user();
        if (!$mount) {
            $query->where('status', 'success')->where('user_id', $user->id)->whereNotNull('voucher_id')->whereDate('created_at', $Date);
        } else {
            $query->where('status', 'success')->where('user_id', $user->id)->whereNotNull('voucher_id')->whereMonth('created_at', $mount);
        }
    }
    public function scopeGetFailTransaction(Builder $query,$date)
    {
        $query->select('user_id')->distinct()->orderBy('user_id','asc')->whereDate('created_at',">=",$date)->limit(10);
    }


}
