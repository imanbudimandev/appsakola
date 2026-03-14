@extends('layouts.member')

@section('title', 'Detail Order #' . $order->order_number)
@section('header', 'Detail Order')

@section('content')
<div class="row column1">
    {{-- Kiri: Info Produk --}}
    <div class="col-md-8">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0 d-flex justify-content-between align-items-center w-100">
                    <h2>Order #{{ $order->order_number }}</h2>
                    <span class="text-muted" style="font-size:13px;">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
            <div class="padding_infor_info">
                @foreach($order->items as $item)
                <div class="media mb-4 pb-4 border-bottom">
                    <div class="mr-3" style="width:70px;height:70px;background:#eee;border-radius:10px;overflow:hidden;flex-shrink:0;">
                        @if($item->product->thumbnail)
                            <img src="{{ asset('storage/' . $item->product->thumbnail) }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#ccc;">
                                <i class="fa fa-image fa-lg"></i>
                            </div>
                        @endif
                    </div>
                    <div class="media-body ml-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="font-weight-bold mb-1">{{ $item->product->name }}</h5>
                            <p class="text-muted mb-0" style="font-size:13px;">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        @if($order->payment_status == 'paid' && $item->product->file_path)
                            <a href="{{ route('member.orders.download', $order) }}" class="btn btn-success btn-sm ml-3" style="flex-shrink:0;">
                                <i class="fa fa-download mr-1"></i> Download
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h5 class="font-weight-bold">Total</h5>
                    <h4 class="font-weight-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

        {{-- Instruksi Pembayaran --}}
        @if($order->payment_status == 'unpaid' && $order->status != 'cancelled')
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    @if($order->payment_method == 'midtrans')
                        <h2><i class="fa fa-credit-card mr-2 text-primary"></i> Selesaikan Pembayaran</h2>
                    @else
                        <h2><i class="fa fa-bank mr-2 text-primary"></i> Instruksi Transfer Bank</h2>
                    @endif
                </div>
            </div>
            <div class="padding_infor_info">
                @if($order->payment_method == 'midtrans')
                    <div class="text-center py-4">
                        <p class="text-muted mb-4">Klik tombol di bawah untuk membuka halaman pembayaran. Pilih QRIS, Virtual Account, GoPay, dll.</p>
                        @if($order->transaction_id)
                            <button id="pay-button" class="btn btn-primary btn-lg px-5 mb-3">
                                <i class="fa fa-credit-card mr-2"></i> Bayar Sekarang dengan Midtrans
                            </button>
                            <br>
                            <a href="{{ route('member.orders.verify', $order) }}" class="btn btn-outline-info">
                                <i class="fa fa-refresh mr-1"></i> Sudah Bayar? Cek Status Pembayaran
                            </a>
                        @else
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-circle mr-2"></i>
                                Snap Token tidak ditemukan. Silakan batalkan dan buat order ulang atau hubungi admin.
                            </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle mr-2"></i>
                        Silakan transfer total pembayaran ke rekening berikut, lalu tunggu konfirmasi dari admin.
                    </div>
                    <div class="p-4 bg-light rounded" style="font-family:monospace;font-size:15px;font-weight:bold;white-space:pre-line;">
                        {!! nl2br(e(\App\Models\Setting::get('manual_bank_info', 'Hubungi admin untuk info rekening.'))) !!}
                    </div>
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="fa fa-exclamation-triangle mr-2"></i>
                        Setelah transfer, admin akan memverifikasi dan mengaktifkan akses download Anda.
                    </div>
                @endif
            </div>
        </div>
        @endif

        @if($order->payment_status == 'paid')
        <div class="alert alert-success">
            <i class="fa fa-check-circle mr-2"></i>
            <strong>Pembayaran terverifikasi!</strong> Silakan download produk Anda di atas.
        </div>
        @endif

        @if($order->status == 'cancelled')
        <div class="alert alert-danger">
            <i class="fa fa-times-circle mr-2"></i>
            <strong>Order ini telah dibatalkan.</strong>
        </div>
        @endif
    </div>

    {{-- Kanan: Status & Aksi --}}
    <div class="col-md-4">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0"><h2>Status Order</h2></div>
            </div>
            <div class="padding_infor_info">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="font-size:13px;">Status</td>
                        <td>
                            @if($order->status == 'cancelled')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @elseif($order->status == 'completed')
                                <span class="badge badge-primary">Selesai</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="font-size:13px;">Pembayaran</td>
                        <td>
                            @if($order->payment_status == 'paid')
                                <span class="badge badge-success">Lunas</span>
                            @else
                                <span class="badge badge-danger">Belum Bayar</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="font-size:13px;">Metode</td>
                        <td>
                            @if($order->payment_method == 'midtrans')
                                <span class="badge badge-info">Midtrans</span>
                            @else
                                <span class="badge badge-secondary">Transfer Bank</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted" style="font-size:13px;">Tanggal</td>
                        <td style="font-size:13px;">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($order->payment_status == 'unpaid' && $order->status != 'cancelled')
        <div class="white_shd full margin_bottom_30">
            <div class="padding_infor_info">
                <form action="{{ route('member.orders.cancel', $order) }}" method="POST"
                      onsubmit="return confirm('Batalkan order ini?\nOrder yang dibatalkan tidak bisa dikembalikan.')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline-danger btn-block">
                        <i class="fa fa-times mr-1"></i> Batalkan Order
                    </button>
                </form>
            </div>
        </div>
        @endif

        <a href="{{ route('member.orders.invoice', $order) }}" target="_blank" class="btn btn-outline-primary btn-block mb-2">
            <i class="fa fa-file-text-o mr-1"></i> Lihat Invoice
        </a>

        <a href="{{ route('member.orders.index') }}" class="btn btn-outline-secondary btn-block">
            <i class="fa fa-arrow-left mr-1"></i> Kembali ke Riwayat
        </a>
    </div>
</div>

{{-- Midtrans Snap JS --}}
@if($order->payment_method === 'midtrans' && $order->payment_status === 'unpaid' && $order->transaction_id)
@php
    $isProduction = \App\Models\Setting::get('midtrans_is_production') == '1';
    $snapUrl = $isProduction
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
    $clientKey = \App\Models\Setting::get('midtrans_client_key');
@endphp
@push('scripts')
<script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    document.getElementById('pay-button').onclick = function() {
        window.snap.pay('{{ $order->transaction_id }}', {
            onSuccess: function(result) {
                alert('Pembayaran berhasil!');
                window.location.reload();
            },
            onPending: function(result) {
                alert('Pembayaran sedang diproses.');
                window.location.reload();
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {}
        });
    };
</script>
@endpush
@endif
@endsection
