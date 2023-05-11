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
        'date_of_purchase',
        'amount_paid',
        'date_paid',
        'official_receipt',
        'acknowledgement_receipt',
        'date_delivered',
        'record_status',
    ];
}
