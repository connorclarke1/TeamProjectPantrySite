@can('loggedIn')
    <x-app-layout>
<table>

<div class="flex flex-wrap">
    <x-barcode-photo-form />
</div>
   

</x-app-layout>

@else

<x-guest-layout>
<h2>Full List of Products</h2>
<table>
<div class="flex flex-wrap">
    
</div>

</x-guest-layout>

@endcan