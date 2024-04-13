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
        
        <div class="w-1/4 p-4">
                <h2 style="font-weight: bold;">Nutritional Information</h2>
                <table class="w-1/4 p-4">
                    <tr>
                        <td>Calories</td>
                        <td>100</td>
                    </tr>
                    <tr>
                        <td>Protein</td>
                        <td>10g</td>
                    </tr>
                    <tr>
                        <td>Carbs</td>
                        <td>6g</td>
                    </tr>
                    <tr>
                        <td>Fat</td>
                        <td>8g</td>
                    </tr>
                </table>
        </div>
        
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
