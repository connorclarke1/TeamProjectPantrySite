<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    use HasFactory;

    protected $table = 'user_product';

    protected $primaryKey = 'user_productID';

    public $timestamps = false;

    protected $fillable = [
        'best_before',
        'stock',
        'userID',
        'productID'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }

}