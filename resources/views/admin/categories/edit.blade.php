@extends('layouts.admin')

@section('header', 'Edit Category')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none">{{ old('description', $category->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-secondary transition shadow-lg shadow-primary/20">
                    Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-semibold hover:bg-slate-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
