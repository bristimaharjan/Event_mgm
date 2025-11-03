<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_name',
        'location',
        'image',
        'description',
        'base_price',
        'price_type',
        'package_price',
        'package_details',
        'has_catering',
        'catering_price_per_person',
        'catering_menu',
        'vendor_id',
        'user_id',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }
}
