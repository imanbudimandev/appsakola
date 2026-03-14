@extends('layouts.admin')

@section('header', 'Create Category')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Create New Category</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Category Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="form-control" placeholder="e.g. Source Code, Assets">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Description</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="Enter category description...">{{ old('description') }}</textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-4 pt-2">
                        <button type="submit" class="btn btn-primary">Create Category</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
