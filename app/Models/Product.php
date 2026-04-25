<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'sizes',
        'colors',
        'is_active'
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'price' => 'float'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute()
{
    if (!$this->image) {
        return 'https://via.placeholder.com/400x280/1a1a2e/c9a84c?text=' . urlencode($this->name);
    }
    if (str_starts_with($this->image, 'http')) {
        return $this->image;
    }
    return asset('storage/' . $this->image);
}
}
