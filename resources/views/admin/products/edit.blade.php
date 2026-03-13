@extends('layouts.admin')

@section('header', 'Edit Product')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                        <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none bg-white">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Price (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none">
                            @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Sale Price (Optional)</label>
                            <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none">
                            @error('sale_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Thumbnail</label>
                        @if($product->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-20 h-20 object-cover rounded-lg border">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Digital File (Zip/PDF/etc)</label>
                        @if($product->file_path)
                            <p class="text-xs text-slate-500 mb-2">Current file: {{ basename($product->file_path) }}</p>
                        @endif
                        <input type="file" name="file_path" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-600 hover:file:bg-slate-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none bg-white">
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                <textarea name="description" rows="5" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-secondary transition shadow-lg shadow-primary/20">
                    Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-semibold hover:bg-slate-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
