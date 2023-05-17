<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'client_id',
        'amount_paid',
        'date_paid',
        'official_receipt',
        'acknowledgement_receipt',
        'record_status',
        'starting_date_of_warranty_availed',
    ];
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
