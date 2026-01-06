<?php

namespace App\Http\Controllers\Admin;

use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
        public function index()
        {
            $products = Product::latest()->paginate(20);
            return view('admin.products.index', compact('products'));
        }

        public function create()
        {
            return view('admin.products.create');
        }

        public function store(Request $request)
        {
            $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['required', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            ]);

            if ($request->hasFile('image')) 
            {
            $validated['image'] = $request->file('image')->store('products', 'public');
            } else {
            $validiated['image'] = 'products/default.png';
            }

            Product::create($validated);

            return redirect()->route('admin.products.index');
        }

        public function edit(Product $product)
        {
            return view('admin.products.edit', compact('product'));
        }

        public function update(Request $request, Product $product)
        {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'price' => ['required', 'integer', 'min:0'],
                'category' => ['required', 'string'],
                'stock' => ['required', 'integer', 'min:0'],
                'image' => ['nullable', 'image', 'max:2048'],
            ]);

            if($request->hasFile('image')) 
            {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($validated);

            return redirect()->route('admin.products.index');
        }

        public function  destroy(Product $product)
        {
            if ($product->image && Storage::disk('public')->exists($product->image))
            {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()->route('admin.products.index');
        }

        public function show()
        {
            return view('admin.products.import');
        }

        public function import(Request $request)
        {
            $request->validate([
                'file' => ['required', 'file', 'mimes:csv,xlsx'],
            ]);

            Excel::import(new ProductsImport, $request->file('file'));

            return redirect()->route('admin.products.index')
                ->with('success', 'Import started. Products will appear shortly.');
        }
}

