@extends('layouts.admin')

@section('header', 'Orders')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-medium">
                <tr>
                    <th class="px-6 py-4">Order ID</th>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Payment</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm font-semibold">#{{ $order->order_number }}</td>
                    <td class="px-6 py-4 text-sm">
                        <p class="font-medium text-slate-700">{{ $order->user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $order->user->email }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-slate-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $order->status == 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-primary hover:text-secondary text-sm font-medium">View Details</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-slate-400 text-sm">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
