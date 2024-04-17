<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductNutrition extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'productID',
        'calories',
        'protein',
        'fat',
        'carbs'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }

}
