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
        'product_type_id',
        'product_status',
        'product_purchased',
        'date_delivered',
        'date_of_purchase',
        'record_status'
    ];
    public function warranties() {
        return $this->hasMany(Warranty::class)->orderBy('created_at', 'desc');
    }
    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function softwareType() {
        return $this->belongsTo(SoftwareType::class, 'software_type_id');
    }
    public function productType() {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }


}
