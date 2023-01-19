<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{

    use HasFactory;

    const SUPER_ADMINISTRATOR_ID = 1;
    const ADMINISTRATOR_ID = 2;
    const SELLER_ID = 3;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'slug',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
}
