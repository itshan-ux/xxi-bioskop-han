<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'customer_name',
        'seat_number',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}