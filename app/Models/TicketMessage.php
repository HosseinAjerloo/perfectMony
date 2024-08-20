<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    use HasFactory;
    protected $fillable=['ticket_id','user_id','admin_id','message','seen_at','type'];

    public function image()
    {
        return $this->morphOne(File::class,'fileable');
    }
}
