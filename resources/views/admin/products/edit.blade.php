<h2>Edit Product</h2>

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @csrf 
    @method('PUT')

    <input name="name" value="{{ $product->name }}" required>
    <textarea name="description">{{ $product->description }}</textarea>
    <input name="price" type="number" value="{{ $product->price }}" required>
    <input name="category" value="{{ $product->category }}" required>
    <input name="stock" type="number" value="{{ $product->stock }}" required>
    <input type="file" name="image">

    <button type="submit">Update</button>
</form>