<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'event_name',
        'event_date',
        'venue',
        'description',
        'image',
        'price',
        'available_seats',
        'category',
    ];
    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
