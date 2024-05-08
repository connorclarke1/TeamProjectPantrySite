@if ($errors->any())
    <div class="bg-red-600 border-solid rounded-md border-2 border-red-700">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-lg text-gray-100">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('products.updateInstance', ['user_productID' => $userProduct->user_productID]) }}" enctype="multipart/form-data">
    @csrf    
    @method('PUT')
        <input type="number" name="user_productID" id="user_productID" value="$userProduct->user_productID" hidden>
        <div class="p-2 m-2 rounded-lg shadow-lg bg-gray-50 border-2 border-blue-900 max-w-md">
        <h2> EDIT STOCK OF PRODUCT </h2>
            <div class="font-bold text-sm mb-2">Edit Stock Count</div>
            <p class="text-gray-500 text-base mt-2">
                <input type="number"  step='1' value="{{$userProduct['stock']}}" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="stock" name="stock" type="number">
            </p>  
            
            <div class="font-bold text-sm mb-2">Edit Best Before</div>
            <p class="text-gray-700 text-sm">
                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="best_before" name="best_before" type="date" value="{{$userProduct['best_before']}}">
            </p>
           
            <div class="flex items-center justify-end mt-4 top-auto">
                <button type="submit" class="bg-gray-800 text-white text-xs px-2 py-2 rounded-md mb-2 mr-2 uppercase hover:underline">Update Stock</button>
            </div>
       </div>
    </form>
    <form action="{{ route('products.destroyInstance', ['user_productID' => $userProduct->user_productID]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
        Delete Instance
    </button>
</form>