@extends('layouts.admin')

@section('header', 'Order Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Items -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-bold">Order #{{ $order->order_number }}</h3>
                <span class="text-sm text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="p-6 divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-slate-50 rounded-xl overflow-hidden border">
                                @if($item->product->thumbnail)
                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $item->product->name }}</h4>
                                <p class="text-sm text-slate-500">Price: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-400">Qty: {{ $item->quantity }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-6 bg-slate-50 border-t border-slate-100">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold text-slate-700">Total Amount</span>
                    <span class="text-2xl font-black text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Customer Info -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold mb-4">Customer Info</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Name</p>
                    <p class="font-medium text-slate-800">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Email</p>
                    <p class="font-medium text-slate-800">{{ $order->user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold mb-4">Manage Order</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Order Status</label>
                    <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none bg-white">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Payment Status</label>
                    <select name="payment_status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-4 focus:ring-primary/10 transition outline-none bg-white">
                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partially_paid" {{ $order->payment_status == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                    </select>
                </div>
                <button type="submit" class="w-full py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/10">
                    Update Details
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
