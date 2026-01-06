<h2>Products</h2>

<a href="{{ route('admin.products.create') }}">Add Product</a>

<ul>
    @foreach($products as $product)
        <li>
            {{ $product->name }} (Stock: {{ $product->stock }})
            <a href="{{ route('admin.products.edit', $product) }}">Edit</a>

            <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                @csrf 
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
        @endforeach
</ul>

{{ $products->links() }}