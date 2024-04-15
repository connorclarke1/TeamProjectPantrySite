<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    //

    public function index($product_id)
    {
        $query = UserProduct::query();

        //TODO Query here
        $query -> where('productID', $product_id);

        $UserProducts = $query->paginate(4);
        return view('product', compact('UserProducts'));
    }
}
