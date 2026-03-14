@extends('layouts.admin')

@section('header', 'Orders')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0 d-flex justify-content-between align-items-center w-100">
                    <h2>Orders List</h2>
                    <div>
                        <span class="badge badge-danger mr-2">● Unpaid: {{ $orders->where('payment_status', 'unpaid')->count() }}</span>
                        <span class="badge badge-success">● Paid: {{ $orders->where('payment_status', 'paid')->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Pembayaran</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr class="{{ $order->payment_status == 'unpaid' && $order->payment_method == 'manual_bank' ? 'table-warning' : '' }}">
                                <td>
                                    <strong>#{{ $order->order_number }}</strong><br>
                                    <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                </td>
                                <td>
                                    <strong>{{ $order->user->name }}</strong><br>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </td>
                                <td><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                <td>
                                    @if($order->payment_method == 'midtrans')
                                        <span class="badge badge-info">Midtrans</span>
                                    @else
                                        <span class="badge badge-secondary">Bank Transfer</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $order->payment_status == 'paid' ? '✓ Lunas' : '✗ Belum Bayar' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $order->status == 'completed' ? 'badge-primary' : ($order->status == 'cancelled' ? 'badge-danger' : 'badge-warning') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    @if($order->payment_status == 'unpaid' && $order->payment_method == 'manual_bank')
                                        <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Konfirmasi pembayaran order #{{ $order->order_number }}?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check" style="color:white"></i> Konfirmasi</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm"><i class="fa fa-eye" style="color:white"></i> Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada order.</td>
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
