<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property\Branch;

class Room extends Model
{
    protected $fillable = [
        'branch_id',
        'name',
        'capacity',
        'price',
        'status',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
