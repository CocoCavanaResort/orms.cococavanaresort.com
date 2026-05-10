<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Model;

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
