<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'code',
        'description',
        'amount',
        'is_percentage',
    ];
}
