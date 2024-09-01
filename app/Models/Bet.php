<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $fillable = ['user_id', 'channel_id', 'amount', 'odds', 'result'];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateProfit()
    {
        if ($this->result) {
            return $this->amount * $this->odds - $this->amount; // Ganancia neta
        }
        return -$this->amount; // Pérdida
    }
}

