@extends('layouts.admin')

@section('header', 'Detail Order')

@section('content')
<div class="row column1">
    <div class="col-md-8">
        <!-- Order Items -->
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0 d-flex justify-content-between align-items-center w-100">
                    <h2>Order #{{ $order->order_number }}</h2>
                    <span class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
            <div class="padding_infor_info">
                <ul class="list-unstyled">
                    @foreach($order->items as $item)
                        <li class="media mb-4 border-bottom pb-3">
                            <div class="mr-3" style="width: 64px; height: 64px; background: #eee; border-radius: 5px; overflow: hidden;">
                                @if($item->product->thumbnail)
                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <div class="media-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mt-0 mb-1 font-weight-bold">{{ $item->product->name }}</h5>
                                    <p class="text-muted mb-0">Harga: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-weight-bold mb-0">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                    <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <span class="h5 font-weight-bold text-dark">Total</span>
                    <span class="h3 font-weight-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Info Pembayaran</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%" class="text-muted font-weight-bold">Metode Pembayaran</td>
                        <td>
                            @if($order->payment_method == 'midtrans')
                                <span class="badge badge-info">Midtrans (Online)</span>
                            @else
                                <span class="badge badge-secondary">Manual Bank Transfer</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">Status Pembayaran</td>
                        <td>
                            <span class="badge {{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-danger' }} p-2">
                                {{ $order->payment_status == 'paid' ? '✓ LUNAS' : '✗ BELUM BAYAR' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold">Status Order</td>
                        <td>
                            <span class="badge {{ $order->status == 'completed' ? 'badge-primary' : ($order->status == 'cancelled' ? 'badge-danger' : 'badge-warning') }} p-2">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @if($order->transaction_id)
                    <tr>
                        <td class="text-muted font-weight-bold">Transaction ID</td>
                        <td><code>{{ $order->transaction_id }}</code></td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Customer Info -->
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Info Member</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <p class="text-muted mb-1" style="font-size:0.8rem; font-weight:bold; text-transform: uppercase;">Nama</p>
                <p class="font-weight-bold">{{ $order->user->name }}</p>
                <p class="text-muted mb-1 mt-3" style="font-size:0.8rem; font-weight:bold; text-transform: uppercase;">Email</p>
                <p class="font-weight-bold">{{ $order->user->email }}</p>
            </div>
        </div>

        <!-- Quick Confirm (Bank Transfer) -->
        @if($order->payment_method == 'manual_bank' && $order->payment_status != 'paid')
        <div class="white_shd full margin_bottom_30" style="border: 2px solid #28a745;">
            <div class="full graph_head" style="background: #28a745;">
                <div class="heading1 margin_0">
                    <h2 style="color: white;">⚡ Konfirmasi Pembayaran</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <div class="alert alert-warning">
                    <strong>Transfer Bank Manual</strong><br>
                    Member sudah transfer? Klik tombol di bawah untuk konfirmasi dan aktifkan akses download produk.
                </div>
                <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran order #{{ $order->order_number }}?\n\nPastikan Anda sudah menerima transferan dari member.')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-block btn-lg font-weight-bold">
                        <i class="fa fa-check"></i> KONFIRMASI PEMBAYARAN LUNAS
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($order->payment_method == 'midtrans')
        <div class="white_shd full margin_bottom_30" style="border: 2px solid #17a2b8;">
            <div class="full graph_head" style="background: #17a2b8;">
                <div class="heading1 margin_0">
                    <h2 style="color: white;">Midtrans Payment</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                @if($order->payment_status == 'paid')
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i> Pembayaran dikonfirmasi otomatis oleh Midtrans.
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Pembayaran Midtrans akan dikonfirmasi otomatis melalui webhook. Jika status belum berubah setelah 5 menit, perbarui manual di bawah.
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Manual Update Status -->
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Update Manual</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label class="font-weight-bold">Status Order</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Status Pembayaran</label>
                        <select name="payment_status" class="form-control">
                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partially_paid" {{ $order->payment_status == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block font-weight-bold">Simpan Perubahan</button>
                </form>

                <hr>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-block">← Kembali ke Daftar Order</a>
            </div>
        </div>
    </div>
</div>
@endsection
