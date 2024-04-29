<div class="productlist p-2">
    @if ($errors->any())
    <div class="bg-red-600 border-solid rounded-md border-2 border-red-700">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-lg text-gray-100">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="/inventory" enctype="multipart/form-data">
    @csrf    
        <div class="p-2 m-2 rounded-lg shadow-lg bg-gray-50 border-2 border-blue-900 max-w-md">
        <h2> ADD NEW PRODUCT TO DATABASE </h2>
        <div class="font-bold text-sm mb-2">Product Name</div>
            <div class="font-bold text-sm mb-2">
                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="product_name" name="product_name" type="text" placeholder="{{ $productData['product_name'] }}", value = "{{ $productData['product_name'] }}">
            </div>

            <div class="font-bold text-sm mb-2">Barcode</div>
            <p class="text-gray-500 text-base mt-2">
                <input type="number" value="{{ $productData['barcode'] }}" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="barcode" name="barcode" type="text" placeholder="{{ $productData['barcode'] }}">
            </p>  

            <div class="font-bold text-sm mb-2">Price per 100g</div>
            <p class="text-gray-500 text-base mt-2">
                <input type="number"  step='1' value='0' class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="price" name="price" type="text" placeholder="price">
            </p>  
            
            <div class="font-bold text-sm mb-2">Calories / 100g</div>
            <p class="text-gray-500 text-base mt-2">
                <input type="number"  step='1' value="{{$productData['calories']}}" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="calories" name="calories" type="text" placeholder="{{$productData['calories']}}">
            </p>  
            <div class="font-bold text-sm mb-2">Protein / 100g</div>
            <p class="text-gray-500 text-base mt-2">
                <input type="number"  step='1' value="{{$productData['protein']}}" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="protein" name="protein" type="text" placeholder="{{$productData['protein']}}">
            </p>  
            <div class="font-bold text-sm mb-2">Carbs / 100g</div>
            <p class="text-gray-500 text-base mt-2">
                <input type="number"  step='1' value="{{$productData['carbs']}}" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="carbs" name="carbs" type="text" placeholder="{{$productData['carbs']}}">
            </p>  
            <div class="font-bold text-sm mb-2">Fat / 100g</div>
            <p class="text-gray-500 text-base mt-2">
                <input type="number"  step='1' value="{{$productData['fat']}}" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="fat" name="fat" type="text" placeholder="{{$productData['fat']}}">
            </p>   
            <div class="font-bold text-sm mb-2">Grams Per Unit</div>
            <p class="text-gray-500 text-base mt-2">
                <input type="number"  step='1' value='0' class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="unit" name="unit" type="text" placeholder="Grams Per Unit">
            </p> 
            <p>
            <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Upload Product Photo</label>
                <input id="image" name="image" type="file" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            </p>
            <div class="flex items-center justify-end mt-4 top-auto">
                <button type="submit" class="bg-gray-800 text-white text-xs px-2 py-2 rounded-md mb-2 mr-2 uppercase hover:underline">Add New</button>
            </div>
       </div>
    </form>
    </div>