@extends('layouts.admin')

@section('header', 'Products')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0 d-flex justify-content-between align-items-center w-100">
                    <h2>Product List</h2>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">Add Product</a>
                </div>
            </div>
            <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3" style="width: 50px; height: 50px; background: #eee; border-radius: 5px; overflow: hidden;">
                                            @if($product->thumbnail)
                                                <img src="{{ asset('storage/' . $product->thumbnail) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center h-100"><i class="fa fa-image text-muted"></i></div>
                                            @endif
                                        </div>
                                        <div>
                                            <strong>{{ $product->name }}</strong><br>
                                            <small class="text-muted">{{ $product->slug }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-secondary">{{ $product->category->name }}</span></td>
                                <td>
                                    @if($product->sale_price)
                                        <del class="text-muted d-block" style="font-size: 0.8rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</del>
                                        <span class="text-success font-weight-bold">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                    @else
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $product->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil" style="color: white;"></i></a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No products found.</td>
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
