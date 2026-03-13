@extends('layouts.admin')

@section('header', 'Products')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-bold">Product List</h2>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition shadow-sm">
        Add Product
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-medium">
                <tr>
                    <th class="px-6 py-4">Product</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Price</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($products as $product)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-slate-100 flex-shrink-0">
                                @if($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500">{{ $product->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm px-2 py-1 bg-slate-100 rounded text-slate-600 font-medium">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold">
                        @if($product->sale_price)
                            <span class="text-slate-400 line-through mr-1">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-primary">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                        @else
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $product->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-primary hover:text-secondary text-sm font-medium">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium" onclick="return confirm('Delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
