@extends('layouts.admin')

@section('header', 'Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Cards -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-slate-500">Revenue</p>
            <p class="text-2xl font-bold">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-slate-500">Orders</p>
            <p class="text-2xl font-bold">{{ $stats['total_orders'] }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <div>
            <p class="text-sm text-slate-500">Products</p>
            <p class="text-2xl font-bold">{{ $stats['total_products'] }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 01-9-3.47m0-3.53a4 4 0 110-8m5 13H15m0 0V5a2 2 0 10-4 0v2m-2 4h4a2 2 0 012 2v3a2 2 0 01-2 2h-4a2 2 0 01-2-2v-3a2 2 0 012-2z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-slate-500">Customers</p>
            <p class="text-2xl font-bold">{{ $stats['total_users'] }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-bold">Recent Orders</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-medium">
                <tr>
                    <th class="px-6 py-4">Order ID</th>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($recent_orders as $order)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm font-semibold">#{{ $order->order_number }}</td>
                    <td class="px-6 py-4 text-sm">{{ $order->user->name }}</td>
                    <td class="px-6 py-4 text-sm">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400">No orders yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
