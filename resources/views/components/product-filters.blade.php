<div>
    <form action="{{ route('inventory') }}" method="GET">
        <!-- Add your filtering options here -->
        <input type="text" name="search" placeholder="Search...">
        <select name="units">
            <option value="">Select Stock Measure</option>
            <option value="Grams">Grams</option>
            <option value="Units">Units</option>
        </select>
        <input type="text" name="price_range" placeholder="Price Range (min-max)">
        <select name="order_by">
            <option value="">Order By</option>
            <option value="productName_asc">Title A-Z</option>
            <option value="productName_desc">Title Z-A</option>
            <option value="price_asc">Price Low to High</option>
            <option value="price_desc">Price High to Low</option>
        </select>
        <button type="submit">Apply Filters</button>
    </form>
</div>
