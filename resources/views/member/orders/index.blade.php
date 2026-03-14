@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-20">
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-slate-900">Purchase History</h1>
        <p class="text-slate-500 mt-2">Manage your orders and downloads here.</p>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-[40px] border border-slate-200 p-20 text-center shadow-sm">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 118 0m-4 10v4m-8-8H4m0 0l-1-1m1 1l1-1m8 8h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">No orders yet</h2>
            <p class="text-slate-500 mt-2 max-w-xs mx-auto mb-10">You haven't made any purchases. Explore our marketplace to find premium digital assets.</p>
            <a href="{{ route('landing') }}" class="px-8 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-secondary transition shadow-xl shadow-primary/20">Explore Products</a>
        </div>
    @else
        <div class="bg-white rounded-[32px] border border-slate-200 overflow-hidden shadow-xl">
            <div class="table-responsive">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 uppercase tracking-widest text-[10px] font-black text-slate-400">
                            <th class="px-8 py-6">Order Details</th>
                            <th class="px-8 py-6">Amount</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition duration-300">
                            <td class="px-8 py-6">
                                <p class="font-bold text-slate-900 mb-1">#{{ $order->order_number }}</p>
                                <p class="text-xs text-slate-400 font-medium tracking-tight">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="font-bold text-slate-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-600 border-amber-200',
                                        'completed' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                        'processing' => 'bg-blue-100 text-blue-600 border-blue-200',
                                        'cancelled' => 'bg-red-100 text-red-600 border-red-200',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $statusClasses[$order->status] ?? 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('member.orders.show', $order) }}" class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-primary transition shadow-lg shadow-slate-900/10 hover:shadow-primary/20">
                                    View Logic
                                    <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
