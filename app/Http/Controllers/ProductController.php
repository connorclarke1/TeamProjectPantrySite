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
use App\Http\Requests\UpdateInstanceRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Displays a list of products - filters applied using query - gathers total stock of products for product cards
     */
    public function index(Request $request)
    {
        //If statements stack to create one big SQL query
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%$search%");
            });
        }
        if ($request->filled('units')) {
            $query->where('unit', $request->units);
        }

        if ($request->filled('price_range')) {
            $priceRange = explode('-', $request->price_range);
            $query->whereBetween('price', [$priceRange[0], $priceRange[1]]);
        }

        if ($request->filled('order_by')) {
            $order_by = $request->order_by;
            list($sortField, $sortDirection) = explode('_', $order_by);

            $allowedFields = ['productName', 'price'];

            $allowedDirections = ['asc', 'desc'];
            if (in_array($sortField, $allowedFields) && in_array($sortDirection, $allowedDirections)) {
                if ($sortField == 'productName'){ $sortField = 'product_name';}
                $query->orderBy($sortField, $sortDirection);
            } else {
            }
        }
        else{
            $query->latest();
        }

        $query->whereHas('userProducts');
        
        


        $products = $query->paginate(8);


        //Iterate over each instance of userproduct to gather total stock count for inventory view
        $totalStocks = [];

        foreach($products as $product){
            $totalStock = UserProduct::where('productID', $product->id)->sum('stock');
            $totalStocks[$product->id] = $totalStock;
        }
        
        $inStockProducts = collect([]);


        //Iterate over each instance of userproduct to retreive the earliest bbf date to display
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
     * Store a newly created product in storage. StoreProductRequest has defined requirements
     */
    public function store(StoreProductRequest $request)
    {
        
        $product = Product::create($request->except('_token'));
        $product->creator = Auth::id();

        //If image uploaded , set
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            //Time used for unique names
            $imageName = time() . '_' . $image->getClientOriginalName();
    
            $image->move(public_path('images'), $imageName);
    
            $product->image = $imageName;
            $product->save();
        }
        else{
            //If no image - use default image
            $image_url = $request->input('pulledImage');
            $image_contents = file_get_contents($image_url);
            $filename = time() . '_' . basename($image_url);

            $path = public_path('images/' . $filename);
            file_put_contents($path, $image_contents);

            $product->image = $filename;
            $product->save();
        }
        //Add entry to product_nutrition table along with nutritional data
        $productNutritionData = $request->except('_token');
        $productNutritionData['productID'] = $product->id; 
        $productNutrition = ProductNutrition::create($productNutritionData);

        $products = Product::all();
        return Redirect::route('inventory'); 
    }

    //Store instance of product, StoreUserProductRequest has defined requirements
    public function storeInstance(StoreUserProductRequest $request)
    {

        $data = $request->except('_token');
  
        $UserProductData = [
            'userID' => Auth::id(),
            'stock' => $data['stock'],
            'best_before' => $data['best_before'],
            'productID' => intval($data['product_name']),
            
        ];
        
        $productInstance = UserProduct::create($UserProductData);

        return Redirect::route('inventory'); 
    }

    /**
     * Display the selected product page and instances below.
     */
    public function show(int $id)
    {
        $product = Product::find($id);
        $query = UserProduct::query();
        //Find all instances of products using productID
        $query -> where('productID', $id);

        $UserProducts = $query->paginate(4);
        $productInstances = $UserProducts->items();
        //Total stock count
        $totalStock = $query->sum('stock');

        return view('selectedproduct', compact('productInstances', 'product', 'totalStock'));
    }

    /**
     * Show the form for editing a product, also show nutritional info
     */
    public function edit(int $id)
    {
        if (!auth()->user()->can('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $product = Product::findOrFail($id);
            //Use relationship defined in model to get productNutrition, since product nutrition belongs to product
            $productNutrition = $product->productNutrition;
            return view('edit-product-form' , compact('product', 'productNutrition'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Update the products info, UpdateProductRequest has defined requirements
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $productNutrition = $product->productNutrition;
        
        //If image is uploaded change, if no it will be left the same
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
    
            $image->move(public_path('images'), $imageName);
    
            $product->image = $imageName;
        }
        //Enter new data into tables
        $productNutrition->fill($request->except('_token'));
        $productNutrition->save();
        $product->fill($request->except('_token'));
        $product->save();
        $products = Product::all();
 
        return Redirect::route('inventory'); 
    }

    //Load the edit instance page
    public function editInstance($user_productID)
    {
        if (!auth()->user()->can('isAdmin')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $UserProduct = UserProduct::findOrFail($user_productID);
            //HasOne relationship in model used to get product
            $product = $UserProduct->product;
            //BelongsTo relationship used
            $productNutrition = $product->productNutrition;
            return view('edit-product-instance' , compact('product', 'productNutrition', 'UserProduct'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    //Update the product instance, UpdateInstanceRequest has defined requirements
    public function updateInstance(UpdateInstanceRequest $request ,$user_productID)
    {
        
        $UserProduct = UserProduct::findOrFail($user_productID);
        $product = $UserProduct->product;
        $id = $product['id'];
        $UserProduct->fill($request->except('_token'));
        $UserProduct->save();

        //Product instance Updated, returned to view of selected product using ID
 
        return Redirect::route('inventory', ['id' => $id]);
        
        
    }

    /**
     * Remove the product from storage. Also delete all product instances
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        $userProducts = UserProduct::where('user_productID', $id)->delete();
        $product->delete();
        $products = Product::all();
        
        return Redirect::route('inventory'); 
    }

    //Delete an instance of the product
    public function destroyInstance($user_productID)
    {
        $UserProduct = UserProduct::findOrFail($user_productID);
        $product = $UserProduct->product;
        $id = $product['id'];
        $UserProduct->delete();
        //Returns view of product
        return Redirect::route('inventory', ['id' => $id]);
    }


    //Form submittion of barcode - executes python script which returns information about product
    public function findBarcode(FindBarcodeRequest $request)
    {
        $image = $request->file('image');
        if ($image) {
            $image->move(public_path('uploads'), $image->getClientOriginalName());

            
            $imagePath = public_path('uploads') . '/' . $image->getClientOriginalName();
        }
        //Get image from above and execute python script in order to get info about product
        //Python script uses library to read barcode, the api to get info 
        //Returns array of data
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
            
        }
        else {
            
        }
        //Data to be fed to creating product form then displayed
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

        //Create the view for the new product form, view is fed data from barcode scanning to be entered already
        
        return view('barcode-product-creation', compact('productData'));
        
    }
}
