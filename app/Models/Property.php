<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'address_id',
        'price',
        'code',
        'description',
        'category',
        'isForRent',
        'status',
        'bedrooms',
        'bathrooms',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
