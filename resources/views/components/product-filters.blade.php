<div>
    <form action="{{ route('products') }}" method="GET">
        <!-- Add your filtering options here -->
        <input type="text" name="search" placeholder="Search...">
        <select name="category">
            <option value="">Select Category</option>
            <option value="CD">CD</option>
            <option value="Book">Book</option>
            <option value="Game">Game</option>
        </select>
        <input type="text" name="price_range" placeholder="Price Range (min-max)">
        <select name="order_by">
            <option value="">Order By</option>
            <option value="title_asc">Title A-Z</option>
            <option value="title_desc">Title Z-A</option>
            <option value="price_asc">Price Low to High</option>
            <option value="price_desc">Price High to Low</option>
        </select>
        <button type="submit">Apply Filters</button>
    </form>
</div>
