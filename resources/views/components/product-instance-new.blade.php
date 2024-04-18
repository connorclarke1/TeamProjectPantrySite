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
    <form method="POST" action="/inventoryInstance" enctype="multipart/form-data">
    @csrf    
        <div class="p-2 m-2 rounded-lg shadow-lg bg-gray-50 border-2 border-blue-900 max-w-md">
        <h2> ADD NEW INSTANCE OF PRODUCT </h2>
        <div class="font-bold text-sm mb-2">
        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="product_name" name="product_name" placeholder="product name">
            <option value="">Select Product</option>
                @foreach($productNames as $id => $productName)
                    <option value="{{ $id }}">{{ $productName }}</option>
                @endforeach
        </select>
        </div>

            <div class="font-bold text-sm mb-2">Amount (ADD UNIT OPTION HERE ALSO)</div>
            <p class="text-gray-500 text-base mt-2">
                <input type="number"  step='1' value='0' class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="stock" name="stock" type="number" placeholder="stock">
            </p>  
            
            <div class="font-bold text-sm mb-2">Best Before</div>
            <p class="text-gray-700 text-sm">
                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="best_before" name="best_before" type="date">
            </p>
           
            <div class="flex items-center justify-end mt-4 top-auto">
                <button type="submit" class="bg-gray-800 text-white text-xs px-2 py-2 rounded-md mb-2 mr-2 uppercase hover:underline">Add New</button>
            </div>
       </div>
    </form>
    </div>