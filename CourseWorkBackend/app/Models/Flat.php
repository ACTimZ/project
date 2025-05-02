<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    use HasFactory;

    protected $fillable = [
        'rooms_count',
        'square_meters',
        'floor',
        'floors_in_house',
        'housing_complex',
        'price_current',
        'price_start',
        'has_balcony',
        'bathroom_combined',
        'house_type',
        'description',
        'images'
    ];

    protected $casts = [
        'images' => 'array',
        'has_balcony' => 'boolean',
        'bathroom_combined' => 'boolean',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
