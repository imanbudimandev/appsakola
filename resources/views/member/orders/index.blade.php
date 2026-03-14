@extends('layouts.member')

@section('title', 'Riwayat Pembelian')
@section('header', 'Riwayat Pembelian')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0 d-flex justify-content-between align-items-center w-100">
                    <h2>Daftar Order</h2>
                    <div>
                        <span class="badge badge-success mr-1">Lunas: {{ $orders->where('payment_status','paid')->count() }}</span>
                        <span class="badge badge-warning mr-1">Menunggu: {{ $orders->where('payment_status','unpaid')->where('status','!=','cancelled')->count() }}</span>
                        <span class="badge badge-danger">Dibatalkan: {{ $orders->where('status','cancelled')->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="table_section padding_infor_info">
                @forelse($orders as $order)
                <div class="card mb-3 border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
                    {{-- Header Order --}}
                    <div class="card-header d-flex justify-content-between align-items-center" style="background:#f8f9fa;">
                        <div>
                            <strong>#{{ $order->order_number }}</strong>
                            <span class="text-muted ml-3" style="font-size:12px;"><i class="fa fa-clock-o mr-1"></i>{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="d-flex align-items-center" style="gap:8px;">
                            @if($order->status == 'cancelled')
                                <span class="badge badge-danger"><i class="fa fa-times mr-1"></i>Dibatalkan</span>
                            @elseif($order->payment_status == 'paid')
                                <span class="badge badge-success"><i class="fa fa-check mr-1"></i>Lunas</span>
                            @else
                                <span class="badge badge-warning"><i class="fa fa-clock-o mr-1"></i>Belum Bayar</span>
                            @endif

                            @if($order->payment_method == 'midtrans')
                                <span class="badge badge-info">Midtrans</span>
                            @else
                                <span class="badge badge-secondary">Transfer Bank</span>
                            @endif
                        </div>
                    </div>

                    {{-- Produk --}}
                    @foreach($order->items as $item)
                    <div class="card-body py-3">
                        <div class="media align-items-center">
                            <div class="mr-3" style="width:60px;height:60px;background:#eee;border-radius:8px;overflow:hidden;flex-shrink:0;">
                                @if($item->product->thumbnail)
                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#bbb;">
                                        <i class="fa fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="media-body">
                                <h6 class="mb-0 font-weight-bold">{{ $item->product->name }}</h6>
                                <small class="text-muted">Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                            </div>
                            <div class="ml-auto text-right" style="flex-shrink:0;">
                                @if($order->status == 'cancelled')
                                    {{-- tidak ada aksi --}}
                                @elseif($order->payment_status == 'paid')
                                    <a href="{{ route('member.orders.download', $order) }}" class="btn btn-success btn-sm">
                                        <i class="fa fa-download mr-1"></i> Download
                                    </a>
                                @elseif($order->payment_method == 'midtrans')
                                    <a href="{{ route('member.orders.show', $order) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-credit-card mr-1"></i> Bayar Sekarang
                                    </a>
                                @else
                                    <span class="text-warning" style="font-size:13px;"><i class="fa fa-hourglass-half mr-1"></i>Menunggu Konfirmasi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    {{-- Footer Order --}}
                    <div class="card-footer d-flex justify-content-between align-items-center" style="background:#f8f9fa;font-size:13px;">
                        <span class="font-weight-bold">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        <div style="gap:8px;display:flex;">
                            <a href="{{ route('member.orders.invoice', $order) }}" target="_blank" class="btn btn-outline-primary btn-sm" title="Invoice">
                                <i class="fa fa-file-text-o"></i>
                            </a>
                            <a href="{{ route('member.orders.show', $order) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-eye mr-1"></i> Detail
                            </a>
                            @if($order->payment_status == 'unpaid' && $order->status != 'cancelled')
                                <form action="{{ route('member.orders.cancel', $order) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Batalkan order #{{ $order->order_number }}?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fa fa-times mr-1"></i> Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fa fa-shopping-bag fa-4x text-muted mb-4 d-block"></i>
                        <h5>Belum ada order</h5>
                        <p class="text-muted">Belum ada pembelian yang dilakukan.</p>
                        <a href="{{ route('landing') }}" class="btn btn-primary mt-2">
                            <i class="fa fa-search mr-1"></i> Lihat Produk
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
