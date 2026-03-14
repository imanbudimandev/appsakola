@extends('layouts.admin')

@section('header', 'Edit Product')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Edit Product: {{ $product->name }}</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Product Name</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="form-control">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Category</label>
                                <select name="category_id" required class="form-control">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-4">
                                    <label class="font-weight-bold">Price (Rp)</label>
                                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="form-control">
                                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 form-group mb-4">
                                    <label class="font-weight-bold">Sale Price (Optional)</label>
                                    <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="form-control">
                                    @error('sale_price') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold d-block">Thumbnail</label>
                                @if($product->thumbnail)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" style="width: 100px; height: 100px; object-fit: cover;" class="rounded border">
                                    </div>
                                @endif
                                <input type="file" name="thumbnail" accept="image/*" class="form-control-file">
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="font-weight-bold d-block">Digital File (Zip/PDF/etc)</label>
                                @if($product->file_path)
                                    <small class="text-muted mb-2 d-block">Current file: {{ basename($product->file_path) }}</small>
                                @endif
                                <input type="file" name="file_path" class="form-control-file">
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Status</label>
                                <select name="status" class="form-control">
                                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Description</label>
                        <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-4 pt-2">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
