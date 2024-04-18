<x-app-layout>

    <div class="flex">
        <div class="w-1/2 mr-4">
            <x-product-form-new />
        </div>
        <div class="w-1/2">
            <x-product-instance-new :productNames="$productNames"/>
        </div>
    </div>
 
</x-app-layout>