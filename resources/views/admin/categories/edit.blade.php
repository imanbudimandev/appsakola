@extends('layouts.admin')

@section('header', 'Edit Category')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Edit Category #{{ $category->id }}</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Category Name</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="form-control">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Description</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $category->description) }}</textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-4 pt-2">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
