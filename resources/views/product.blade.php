@can('loggedIn')
    <x-app-layout>
<x-product-filters />
<h2>Full List of Products</h2>
<table>
<div class="flex flex-wrap">
    @foreach ($products as $product)
        <div class="w-1/4 p-4">
            @php
                $hrefUrl = "/products/$product->id";
            @endphp
            @component('components.product-card', [
                'product' => $product,
                'id' => $product['id'],
                'imageUrl' => asset('images/' . $product->image),
                'title' => $product['title'],
                'artist' => $product['artist'],
                'price' => $product['price'],
                'category' => $product['category'],
                'hrefUrl' => $hrefUrl,
                'hrefText' => 'Select',
                'hidden' => ''
            ])
            @endcomponent
            
        </div>
    @endforeach
</div>
    <div class="mt-4">
        
    <!-- Display products -->
    <!-- ... -->

    <!-- Pagination links -->
            {{ $products->links() }}
        
    </div>
    </x-app-layout>

@else

<x-guest-layout>
<x-product-filters />
<h2>Full List of Products</h2>
<table>
<div class="flex flex-wrap">
    @foreach ($products as $product)
        <div class="w-1/4 p-4">
            @php
                $hrefUrl = "/products/$product->id";
            @endphp
            @component('components.product-card', [
                'product' => $product,
                'id' => $product['id'],
                'imageUrl' => asset('images/' . $product->image),
                'title' => $product['title'],
                'artist' => $product['artist'],
                'price' => $product['price'],
                'category' => $product['category'],
                'hrefUrl' => $hrefUrl,
                'hrefText' => 'Select',
                'hidden' => ''
            ])
            @endcomponent
            
        </div>
    @endforeach
</div>
    <div class="mt-4">
        
            {{ $products->links() }}
        
    </div>
    </x-guest-layout>

@endcan

