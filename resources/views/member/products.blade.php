@extends('layouts.member')

@section('title', 'Cari Produk')
@section('header', 'Cari Produk')

@section('content')
<div class="row column1">
    <div class="col-md-12">

        {{-- Filter --}}
        <div class="white_shd full margin_bottom_30">
            <div class="padding_infor_info">
                <form method="GET" action="{{ route('member.products') }}" class="form-inline" style="gap:10px;flex-wrap:wrap;">
                    <div class="form-group mr-3 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}" style="min-width:250px;">
                        </div>
                    </div>
                    <div class="form-group mr-3 mb-2">
                        <select name="category" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fa fa-filter mr-1"></i> Filter
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('member.products') }}" class="btn btn-outline-secondary mb-2">
                            <i class="fa fa-times mr-1"></i> Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Daftar Produk --}}
        @if($products->isEmpty())
            <div class="white_shd full margin_bottom_30">
                <div class="padding_infor_info text-center py-5">
                    <i class="fa fa-search fa-4x text-muted mb-3 d-block"></i>
                    <h5>Produk tidak ditemukan</h5>
                    <p class="text-muted">Coba kata kunci yang lain atau reset filter.</p>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-4 col-sm-6 margin_bottom_30">
                    <div class="white_shd full h-100" style="border-radius:12px;overflow:hidden;display:flex;flex-direction:column;">
                        {{-- Thumbnail --}}
                        <div style="height:180px;background:#eee;overflow:hidden;position:relative;">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                     style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#ccc;">
                                    <i class="fa fa-image fa-3x"></i>
                                </div>
                            @endif

                            {{-- Badge sudah dibeli --}}
                            @if(in_array($product->id, $purchasedProductIds))
                                <span style="position:absolute;top:10px;right:10px;background:#28a745;color:white;font-size:11px;font-weight:bold;padding:4px 10px;border-radius:20px;">
                                    <i class="fa fa-check mr-1"></i> Dimiliki
                                </span>
                            @endif

                            {{-- Badge kategori --}}
                            @if($product->category)
                                <span style="position:absolute;top:10px;left:10px;background:rgba(0,0,0,0.6);color:white;font-size:10px;padding:3px 8px;border-radius:10px;">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="padding_infor_info d-flex flex-column" style="flex:1;">
                            <h5 class="font-weight-bold mb-1">{{ $product->name }}</h5>
                            <p class="text-muted mb-3" style="font-size:12px;flex:1;">{{ Str::limit($product->description, 80) }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <span class="font-weight-bold text-primary" style="font-size:16px;">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                        <br><small class="text-muted"><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></small>
                                    @else
                                        <span class="font-weight-bold text-primary" style="font-size:16px;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                @if(in_array($product->id, $purchasedProductIds))
                                    {{-- Sudah punya: tombol download --}}
                                    @php
                                        $paidOrder = \App\Models\Order::where('user_id', auth()->id())
                                            ->where('payment_status', 'paid')
                                            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
                                            ->first();
                                    @endphp
                                    @if($paidOrder)
                                        <a href="{{ route('member.orders.download', $paidOrder) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-download mr-1"></i> Download
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('member.orders.checkout', $product->slug) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-shopping-cart mr-1"></i> Beli
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
