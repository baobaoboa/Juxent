<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{    protected $fillable = [
    'street',
    'address_line_2',
    'barangay',
    'city',
    'region',
    'country',
    'zipcode'
];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
    use HasFactory;
}
