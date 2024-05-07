<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'unit',
        'price',     
    ];



    public function creator()
    {
        return $this->belongsTo(User::class, 'creator');
    }


    public function productNutrition()
    {
        return $this->hasOne(ProductNutrition::class, 'productID');
    }

    public function userProducts()
{
    return $this->hasMany(UserProduct::class, 'productID');
}
    
}
