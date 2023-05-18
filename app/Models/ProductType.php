<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_type'
    ];
    public function role(){
        return $this->belongsTo(EmployeeRole::class, 'role_id');
    }
}
