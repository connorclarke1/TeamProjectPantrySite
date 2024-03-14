<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'artist',
        'title',
        'price',
        'category'
    ];
    protected $casts = [
        'category' => 'string'
    ];

    public function getCategoryDisplayAttribute()
    {
        switch ($this->category) {
            case 'CD':
                return 'CD';
            case 'Book':
                return 'Book';
            case 'Game':
                return 'Game';
            default:
                return 'Category Error';
        }
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator');
    }

}
