@extends('layouts.admin')

@section('header', 'Categories')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-bold">Category List</h2>
    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition shadow-sm">
        Add Category
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-medium">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Slug</th>
                    <th class="px-6 py-4">Products</th>
                    <th class="px-6 py-4">Created At</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($categories as $category)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm font-semibold text-slate-700">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">{{ $category->slug }}</td>
                    <td class="px-6 py-4 text-sm">{{ $category->products_count }} Products</td>
                    <td class="px-6 py-4 text-sm text-slate-500">{{ $category->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-primary hover:text-secondary text-sm font-medium">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium" onclick="return confirm('Delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">No categories found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
