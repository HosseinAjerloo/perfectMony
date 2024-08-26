<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['user_id', 'subject', 'status'];

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function ticketStatus()
    {
        return match ($this->status) {
            'waiting_for_an_answer' => 'درانتظارپاسخ',
            'has_been_answered' => 'پاسخ داده شده',
            'closed' => 'بسته شده',
            default=>' '
        };
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
