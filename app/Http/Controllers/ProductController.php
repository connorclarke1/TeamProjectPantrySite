<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('artist', 'like', "%$search%");
            });
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('price_range')) {
            $priceRange = explode('-', $request->price_range);
            $query->whereBetween('price', [$priceRange[0], $priceRange[1]]);
        }

        if ($request->filled('order_by')) {
            $order_by = $request->order_by;
            list($sortField, $sortDirection) = explode('_', $order_by);

            $allowedFields = ['title', 'artist', 'price'];
            $allowedDirections = ['asc', 'desc'];
            if (in_array($sortField, $allowedFields) && in_array($sortDirection, $allowedDirections)) {
                $query->orderBy($sortField, $sortDirection);
            } else {
            }
        }
        else{
            $query->latest();
        }

        //TODO add stock total sql query
        
        
        //TODO add closest bbf date query


        $products = $query->paginate(8);

        //TODO for each product do sql query on total stock
        $totalStocks = [];

        foreach($products as $product){
            $totalStock = UserProduct::where('productID', $product->id)->sum('stock');
            $totalStocks[$product->id] = $totalStock;
        }
        //var_dump($totalStocks);

        $earliestBBF = [];

        foreach ($products as $product) {
            $earliestBBFDate = UserProduct::where('productID', $product->id)
            ->orderBy('best_before', 'asc')
            ->value('best_before');

            $earliestBBF[$product->id] = $earliestBBFDate;
        }

        return view('product', compact('products', 'totalStocks', 'earliestBBF'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        return view('add-product-form'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        
        $product = Product::create($request->except('_token'));
        $product->creator = Auth::id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
    
            $image->move(public_path('images'), $imageName);
    
            $product->image = $imageName;
            $product->save();
        }
        else{
            $product->image = '1704237336_download.jfif';
            $product->save();
        }
        $products = Product::all();
        return Redirect::route('products'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $product = Product::find($id);
        $query = UserProduct::query();

        //product id is $id
        $query -> where('productID', $id);

        $UserProducts = $query->paginate(4);
        $productInstances = $UserProducts->items();
        $totalStock = $query->sum('stock');
        //var_dump($product);
        //var_dump($UserProducts);
        //dd($products);
        return view('selectedproduct', compact('productInstances', 'product', 'totalStock'));
        //return view('selectedproduct', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        if (!auth()->user()->can('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $product = Product::findOrFail($id);
            return view('edit-product-form' , ['product' => $product]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
    
            $image->move(public_path('images'), $imageName);
    
            $product->image = $imageName;
        }

        $product->fill($request->except('_token'));
        $product->save();
        $products = Product::all();
 
        return Redirect::route('products'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        $products = Product::all();
        return Redirect::route('products'); 
    }
}
