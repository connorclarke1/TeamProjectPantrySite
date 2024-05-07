<div class="relative bg-gray-100 border border-gray-300 p-4 rounded-lg w-64">
    <div class="text-center mb-4">
        <h2 class="text-lg font-bold">{{ $product_name }}</h2>
        <p class="text-sm italic text-gray-600">Best Before: {{ $best_before }}</p>
        
    </div>
    <div class="flex justify-center mb-4">
        <img src="{{ $imageUrl }}" alt="Product Image" class="max-w-full max-h-32">
    </div>
    <div class="text-center">
        <p class="font-semibold">Stock: {{ $quantity }}</p>
    </div>
    
    <div class="absolute bottom-4 right-4">
        <a href="{{ $hrefUrl }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded" {{$hidden}}>{{$hrefText}}</a>
    </div>
</div>
