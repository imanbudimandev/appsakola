@extends('layouts.member')

@section('title', 'My Library - Appsakola')
@section('header', 'My Library')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        @forelse($orders->where('payment_status', 'paid') as $order)
            @foreach($order->items as $item)
            <div class="white_shd full margin_bottom_30">
                <div class="padding_infor_info">
                    <div class="media">
                        <div class="mr-3" style="width:80px;height:80px;background:#eee;border-radius:10px;overflow:hidden;flex-shrink:0;">
                            @if($item->product->thumbnail)
                                <img src="{{ asset('storage/' . $item->product->thumbnail) }}" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#bbb;">
                                    <i class="fa fa-image fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="media-body ml-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="font-weight-bold mb-1">{{ $item->product->name }}</h5>
                                <p class="text-muted mb-1" style="font-size:13px;">{{ Str::limit($item->product->description, 100) }}</p>
                                <span class="badge badge-success"><i class="fa fa-check-circle mr-1"></i> Sudah Dibayar</span>
                            </div>
                            <div class="ml-4 text-right" style="flex-shrink:0;">
                                @if($item->product->file_path)
                                    <a href="{{ route('member.orders.download', $order) }}" class="btn btn-primary">
                                        <i class="fa fa-download mr-1"></i> Download
                                    </a>
                                @else
                                    <span class="text-muted" style="font-size:13px;"><i class="fa fa-clock-o mr-1"></i> File belum tersedia</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @empty
            <div class="white_shd full margin_bottom_30">
                <div class="padding_infor_info text-center py-5">
                    <i class="fa fa-shopping-bag fa-4x text-muted mb-4 d-block"></i>
                    <h4 class="font-weight-bold">Belum ada produk</h4>
                    <p class="text-muted">Anda belum memiliki produk yang sudah dibayar.</p>
                    <a href="{{ route('landing') }}" class="btn btn-primary mt-3">
                        <i class="fa fa-search mr-1"></i> Cari Produk
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
