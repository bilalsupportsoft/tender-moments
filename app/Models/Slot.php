<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'slot_date',
        'start_time',
        'end_time',
    ];

    public function booking()
{
    return $this->hasMany(Booking::class);
}

public function bookingSlot()
    {
        // A slot has one booking
        return $this->hasOne(Booking::class);
    }


}
