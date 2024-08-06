<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class FinanceTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'payment_id', 'voucher_id', 'voucher_id', 'amount', 'type', 'creadit_balance', 'description', 'time_price_of_dollars'];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
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

}
