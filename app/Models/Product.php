<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'client_id',
        'software_type_id',
        'product_type',
        'product_status',
        'product_purchased',
        'date_delivered',
    ];
    public function warranties() {
        return $this->hasMany(Warranty::class)->orderBy('created_at', 'desc');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
