<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TicketReply;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'status',
        'priority'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

  /*   public function replies()
    {
        return $this->hasMany(TicketReply::class);
    } */

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class)->orderBy('created_at','asc');
    }

    
}