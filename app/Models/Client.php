<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'created_by',
        'client_name',
        'company_address',
        'contact_id',
        'created_at',
        'updated_at',
    ];

    public function contact(){
        return $this->belongsTo(ClientContact::class, 'contact_id');
    }
}
