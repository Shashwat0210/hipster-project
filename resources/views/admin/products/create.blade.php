<h2>Create Product</h2>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf 
    <input name="name" placeholder="Name" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input name="price" type="number" placeholder="Price" required>
    <input name="category" placeholder="Category" required>
    <input name="stock" type="number" placeholder="Stock" required>
    <input type="file" name="image">

    <button type="submit">Save</button>
</form>