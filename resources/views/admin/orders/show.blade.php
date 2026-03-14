@extends('layouts.admin')

@section('header', 'Order Details')

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
                                    <p class="text-muted mb-0">Price: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
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
                    <span class="h5 font-weight-bold text-dark">Total Amount</span>
                    <span class="h3 font-weight-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Customer Info -->
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Customer Info</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <div class="mb-3">
                    <p class="text-muted text-uppercase font-weight-bold mb-1" style="font-size: 0.8rem;">Name</p>
                    <p class="font-weight-bold">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-muted text-uppercase font-weight-bold mb-1" style="font-size: 0.8rem;">Email</p>
                    <p class="font-weight-bold">{{ $order->user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Manage Order</h2>
                </div>
            </div>
            <div class="padding_infor_info">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label class="font-weight-bold">Order Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Payment Status</label>
                        <select name="payment_status" class="form-control">
                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partially_paid" {{ $order->payment_status == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block font-weight-bold">Update Details</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
