<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['sender', 'receiver'];

    public function scopeBySender($q, $sender)
    {
        $q->where('sender_id', $sender);
    }

    public function scopeByReceiver($q, $sender)
    {
        $q->where('receiver_id', $sender);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->select(['id', 'name']);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')->select(['id', 'name']);
    }
}
