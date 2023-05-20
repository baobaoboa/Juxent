<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'contact_number',
    ];

    public function clients() {
        return $this->hasMany(Client::class);
    }
}
