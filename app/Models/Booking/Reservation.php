<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'branch_id',
        'customer_id',
        'check_in_date',
        'check_out_date',
        'stay_type',
        'number_of_adults',
        'number_of_kids',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
