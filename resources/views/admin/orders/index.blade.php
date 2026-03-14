@extends('layouts.admin')

@section('header', 'Orders')

@section('content')
<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Orders List</h2>
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
                                <th>Payment</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td><strong>#{{ $order->order_number }}</strong></td>
                                <td>
                                    <strong>{{ $order->user->name }}</strong><br>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </td>
                                <td><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                <td>
                                    <span class="badge {{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $order->status == 'completed' ? 'badge-primary' : 'badge-warning' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm"><i class="fa fa-eye" style="color: white;"></i> View Details</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No orders found.</td>
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
