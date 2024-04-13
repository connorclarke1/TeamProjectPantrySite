@can('loggedIn')
<x-app-layout>
<h2>Product</h2>

<div class="flex flex-wrap">
        <div class="w-1/4 p-4">
        @if(auth()->check())
            @can('isAdmin')
                @php
                    $hrefUrl = '/inventory/' . $product['id'] . '/edit';;
                    $hrefText = 'Edit';
                    $hidden = '';
                @endphp
            @elsecan('isUser')
                @php
                    $hrefUrl = '';
                    $hrefText = 'Buy';
                    $hidden = '';
                @endphp
            @endcan
        @else
            @php
                $hrefUrl = '';
                $hrefText = 'Please Log in';
                $hidden = 'hidden';
            @endphp        
        @endif
            @component('components.product-card', [
                'product' => $product,
                'id' => $product['id'],
                'imageUrl' => asset('images/' . $product->image),
                'product_name' => $product['product_name'],
                'best_before' => $product['best_before'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'hrefUrl' => $hrefUrl,
                'hrefText' => $hrefText,
                'hidden' => $hidden
            ])
            @endcomponent
            
        </div>
        @php
            $productNutrition = $product->productNutrition;
        @endphp
        @component('components.nutrition-card' , [
                'product' => $product,
                'productNutrition' => $productNutrition,
                'calories' => $productNutrition['calories'],
                'protein' => $productNutrition['protein'],
                'carbs' => $productNutrition['carbs'],
                'fat' => $productNutrition['fat']
                ])
        @endcomponent
        
        
        
</div>



</x-app-layout>
@else
<x-guest-layout>
<h2>Product</h2>
<table>
<div class="flex flex-wrap">
        <div class="w-1/4 p-4">
        @if(auth()->check())
            @can('isAdmin')
                @php
                    $hrefUrl = '/products/' . $product['id'] . '/edit';;
                    $hrefText = 'Edit';
                    $hidden = '';
                @endphp
            @elsecan('isUser')
                @php
                    $hrefUrl = '';
                    $hrefText = 'Buy';
                    $hidden = '';
                @endphp
            @endcan
        @else
            @php
                $hrefUrl = '';
                $hrefText = 'Please Log in';
                $hidden = 'hidden';
            @endphp        
        @endif
            @component('components.product-card', [
                'product' => $product,
                'id' => $product['id'],
                'imageUrl' => asset('images/' . $product->image),
                'product_name' => $product['product_name'],
                'best_before' => $product['best_before'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'hrefUrl' => $hrefUrl,
                'hrefText' => $hrefText,
                'hidden' => $hidden
            ])
            @endcomponent
            
        </div>
</div>
</x-guest-layout>
@endcan
