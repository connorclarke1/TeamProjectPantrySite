<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductNutrition extends Model
{
    use HasFactory;

    protected $fillable = [
        'calories',
        'protein',
        'fat',
        'carbss'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }

}
