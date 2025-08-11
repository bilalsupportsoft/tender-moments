<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slot_id',
        'slot_date',
        'price',
        'status',
    ];

public function slot()
{
    return $this->belongsTo(Slot::class, 'slot_id');
}



}
