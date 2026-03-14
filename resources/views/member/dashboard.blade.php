@extends('layouts.app')

@section('title', 'Member Dashboard - Appsakola')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">My Library</h1>
            <p class="text-slate-500 mt-2">Manage your purchased digital products and downloads.</p>
        </div>
        <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Total Purchases</p>
            <p class="text-2xl font-bold text-primary">{{ $orders->count() }} Items</p>
        </div>
    </div>

    <div class="space-y-6">
        @forelse($orders as $order)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                    <div class="flex space-x-6">
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold">Order Date</p>
                            <p class="text-sm font-semibold">{{ $order->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold">Total Amount</p>
                            <p class="text-sm font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold">Order Number</p>
                            <p class="text-sm font-semibold">#{{ $order->order_number }}</p>
                        </div>
                    </div>
                    <div>
                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>
                <div class="p-6 divide-y divide-slate-50">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-slate-100 rounded-xl flex-shrink-0 overflow-hidden">
                                    @if($item->product->thumbnail)
                                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $item->product->name }}</h4>
                                    <p class="text-sm text-slate-500 line-clamp-1">{{ Str::limit($item->product->description, 80) }}</p>
                                </div>
                            </div>
                            <div>
                                @if($order->payment_status == 'paid')
                                    <a href="#" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-secondary transition shadow-md shadow-primary/20 flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        <span>Download</span>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 font-medium italic">Available after payment</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">No purchases found</h3>
                <p class="text-slate-500 mt-2">Explore our products and start building your collection.</p>
                <a href="{{ route('landing') }}" class="inline-block mt-8 px-8 py-3 bg-primary text-white rounded-xl font-bold hover:bg-secondary transition shadow-lg shadow-primary/20">
                    Browse Products
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
