<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
