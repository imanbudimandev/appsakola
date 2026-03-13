<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        @set_time_limit(600);
        @ini_set('memory_limit', '512M');

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|image|max:5120', // 5MB
            'file_path' => 'nullable|file|max:102400', // 100MB
        ]);

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->sale_price = $request->sale_price;
        $product->status = $request->status ?? 'active';

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            if ($thumbnail && $thumbnail->isValid()) {
                $filename = time() . '_' . Str::slug($request->name) . '.' . $thumbnail->getClientOriginalExtension();
                $path = $thumbnail->storeAs('thumbnails', $filename, 'public');
                if ($path) {
                    $product->thumbnail = $path;
                }
            }
        }

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            if ($file && $file->isValid()) {
                $filename = time() . '_' . Str::slug($request->name) . '_file.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('products', $filename, 'local');
                if ($path) {
                    $product->file_path = $path;
                }
            }
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        @set_time_limit(600);
        @ini_set('memory_limit', '512M');

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|image|max:5120',
            'file_path' => 'nullable|file|max:102400',
        ]);

        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->sale_price = $request->sale_price;
        $product->status = $request->status ?? 'active';

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            if ($thumbnail && $thumbnail->isValid()) {
                $filename = time() . '_' . Str::slug($request->name) . '.' . $thumbnail->getClientOriginalExtension();
                $path = $thumbnail->storeAs('thumbnails', $filename, 'public');
                if ($path) {
                    $product->thumbnail = $path;
                }
            }
        }

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            if ($file && $file->isValid()) {
                $filename = time() . '_' . Str::slug($request->name) . '_file.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('products', $filename, 'local');
                if ($path) {
                    $product->file_path = $path;
                }
            }
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
