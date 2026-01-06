<h2>Import Products</h2>

<form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
    @csrf

    <input type="file" name="file" required>
    <button type="submit">Import</button>
</form>
 

