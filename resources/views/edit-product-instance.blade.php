
<x-app-layout>
    <div>
        <x-edit-product-instance-form :product="$product" :productNutrition="$productNutrition" :UserProduct="$UserProduct" />   
    </div>
    <h2>Product</h2>

<div class="flex flex-wrap">
        <div class="w-1/4 p-4">
        @if(auth()->check())
            @can('isAdmin')
                @php
                    $hrefUrl = '/inventory/' . $product['id'] . '/edit';;
                    $hrefText = 'Edit';
                    $hidden = 'hidden';
                @endphp
            @elsecan('isUser')
                @php
                    $hrefUrl = '';
                    $hrefText = 'Buy';
                    $hidden = 'hidden';
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
                'best_before' => $UserProduct['best_before'],
                'price' => $product['price'],
                'quantity' => $UserProduct['stock'],
                'hrefUrl' => $hrefUrl,
                'stockMeasure' => $product['unit'],
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