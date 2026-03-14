@extends('layouts.admin')

@section('header', 'Categories')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0 d-flex justify-content-between align-items-center w-100">
                    <h2>Category List</h2>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">Add Category</a>
                </div>
            </div>
            <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Products</th>
                                <th>Created At</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td>{{ $category->slug }}</td>
                                <td><span class="badge badge-info">{{ $category->products_count }} Products</span></td>
                                <td>{{ $category->created_at->format('d M Y') }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil" style="color: white;"></i></a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No categories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
