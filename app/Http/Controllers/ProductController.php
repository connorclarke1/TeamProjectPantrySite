<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserProduct;
use App\Models\ProductNutrition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreUserProductRequest;
use App\Http\Requests\FindBarcodeRequest;
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
        $productNames = Product::pluck('product_name', 'id');
        //dd($productNames);
        return view('add-product-form', compact('productNames')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        
        $product = Product::create($request->except('_token'));
        $product->creator = Auth::id();



        //$product -> product_name = $product_name;
        //$product -> calories = $calories;
        //$product -> fat = $fat;
        //$product -> carbs = $carbs;
        //$product -> protein = $protein;
        //$product -> unit = $unit;

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

        $productNutritionData = $request->except('_token');
        $productNutritionData['productID'] = $product->id; // Set the product_id to the id of the newly created Product
        $productNutrition = ProductNutrition::create($productNutritionData);

        $products = Product::all();
        return Redirect::route('inventory'); 
    }


    public function storeInstance(StoreUserProductRequest $request)
    {

        $data = $request->except('_token');
  
        $UserProductData = [
            'userID' => Auth::id(),
            'stock' => $data['stock'],
            'best_before' => $data['best_before'],
            'productID' => intval($data['product_name']),
            //using dd($data) shows the productID is passed as product_name and is an int, easier to just change here
        ];
        
        $productInstance = UserProduct::create($UserProductData);

        return Redirect::route('inventory'); 
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

    public function findBarcode(FindBarcodeRequest $request)
    {
        $image = $request->file('image');
        if ($image) {
            $image->move(public_path('uploads'), $image->getClientOriginalName());

            
            $imagePath = public_path('uploads') . '/' . $image->getClientOriginalName();
        }
        $result = shell_exec("py \"C:\\Users\\Connor\\Desktop\\Team Project\\Barcode Scanning\\BarcodeScan.py\" ". escapeshellarg($imagePath));
        $resultArray = explode("\n", trim($result));
        
        if ($resultArray[0] == "Success"){
            $barcodeType = $resultArray[1];
            $barcodeNum = $resultArray[2];
            $product_name = $resultArray[3];
            $image_url = $resultArray[4];
            $calories = $resultArray[5];
            $protein = $resultArray[6];
            $carbs = $resultArray[7];
            $fat = $resultArray[8];
            //TODO add if not = None, as can be none
        }
        else {
            //TODO add error handling here, resultArray[1] will be error info
            //TODO add redirect here so further code is not executed
        }

        $productData = [
            'barcode' => $barcodeNum,
            'barcodeType' => $barcodeType,
            'product_name' => $product_name,
            'image_url' => $image_url,
            'calories' => $calories,
            'protein' => $protein,
            'carbs' => $carbs,
            'fat' => $fat, 
        ];

        //TODO check if barcode exists in db (this user only)
            //TODO if it does add all known data
        
        //TODO if not existing
            //TODO add info
            //Scrape from online?? if time allows
        
        //TODO redirect to form, send all data possible , $productData
        
        return view('barcode-product-creation', compact('productData'));
        //dd($barcodeNum);
    }
}
