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
    return $this->hasOne(Booking::class, 'slot_id');
}

public function bookingSlot()
    {
        // A slot has one booking
        return $this->hasOne(Booking::class);
    }

    public function latestSlot()
{
    return $this->hasOne(Slot::class, 'slot_date', 'slot_date')->latestOfMany();
}

public function dateSlots()
{
    return $this->hasMany(Slot::class, 'slot_date', 'slot_date');
}

}
