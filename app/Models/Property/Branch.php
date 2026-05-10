<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'location',
        'contact_number',
        'email',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
