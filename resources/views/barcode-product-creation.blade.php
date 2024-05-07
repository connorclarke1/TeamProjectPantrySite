<x-app-layout>

    <div class="flex">
        <div class="w-1/2 mr-4">
            <x-barcode-product-creation-form :productData="$productData" />
        </div>
        <div class="w-1/2">
            <img src="{{$productData['image_url']}}" alt="Retrieved Photo">
        </div>
    </div>
 
</x-app-layout>