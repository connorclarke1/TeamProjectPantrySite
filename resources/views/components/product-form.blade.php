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
    <form method="POST" action="/products" enctype="multipart/form-data">
    @csrf    
        <div class="p-2 m-2 rounded-lg shadow-lg bg-gray-50 border-2 border-blue-900 max-w-md">
        <select name="category" required>
            <option value="" disabled selected>Select Category</option>
            <option value="CD">CD</option>
            <option value="Book">Book</option>
            <option value="Game">Game</option>
        </select>
        <div class="font-bold text-sm mb-2">Title</div>
            <div class="font-bold text-sm mb-2">
                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="title" name="title" type="text" placeholder="title">
            </div>
            <div class="font-bold text-sm mb-2">Artist</div>
            <p class="text-gray-700 text-sm">
                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="artist" name="artist" type="text" placeholder="artist/author/console">
            </p>
            <div class="font-bold text-sm mb-2">Price in Pence</div>
            <p class="text-gray-500 text-base mt-2">
                <input type="number"  step='1' value='0' class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="price" name="price" type="text" placeholder="price">
            </p>   
            <p>
            <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                <input id="image" name="image" type="file" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            </p>
            <div class="flex items-center justify-end mt-4 top-auto">
                <button type="submit" class="bg-gray-800 text-white text-xs px-2 py-2 rounded-md mb-2 mr-2 uppercase hover:underline">Add New</button>
            </div>
       </div>
    </form>
    </div>