@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative pt-20 pb-32 overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-secondary/10 blur-[120px] rounded-full"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-6xl md:text-7xl font-extrabold text-slate-900 tracking-tight mb-8">
            Digital Products for <br>
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">Modern Developers</span>
        </h1>
        <p class="text-xl text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
            Premium source codes, UI kits, and digital assets to accelerate your development workflow. Built with quality in mind.
        </p>
        <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="#products" class="px-8 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-secondary transition shadow-2xl shadow-primary/40 flex items-center space-x-2">
                <span>Browse Marketplace</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
            <a href="/register" class="px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-2xl font-bold hover:bg-slate-50 transition">
                Become a Member
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="max-w-7xl mx-auto px-4 mb-32">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 bg-white/50 backdrop-blur-md border border-slate-200 p-10 rounded-[32px]">
        <div class="text-center">
            <p class="text-3xl font-bold text-slate-900 mb-1">500+</p>
            <p class="text-sm text-slate-500 uppercase font-bold tracking-widest">Products</p>
        </div>
        <div class="text-center">
            <p class="text-3xl font-bold text-slate-900 mb-1">12K+</p>
            <p class="text-sm text-slate-500 uppercase font-bold tracking-widest">Happy Users</p>
        </div>
        <div class="text-center">
            <p class="text-3xl font-bold text-slate-900 mb-1">24/7</p>
            <p class="text-sm text-slate-500 uppercase font-bold tracking-widest">Support</p>
        </div>
        <div class="text-center">
            <p class="text-3xl font-bold text-slate-900 mb-1">100%</p>
            <p class="text-sm text-slate-500 uppercase font-bold tracking-widest">Safe</p>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="max-w-7xl mx-auto px-4 mb-32">
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-4xl font-bold text-slate-900">Latest Drops</h2>
            <p class="text-slate-500 mt-2">Check out our newest digital assets.</p>
        </div>
        <div class="flex space-x-2">
            @php 
                $categories = \App\Models\Category::all();
            @endphp
            @foreach($categories as $category)
                <button class="px-5 py-2 rounded-full border border-slate-200 text-sm font-medium hover:border-primary hover:text-primary transition">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @php
            $products = \App\Models\Product::with('category')->where('status', 'active')->latest()->take(6)->get();
        @endphp
        @forelse($products as $product)
            <div class="group bg-white rounded-[24px] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-primary/5 transition duration-500 overflow-hidden">
                <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-md rounded-full text-xs font-bold text-slate-800 shadow-sm">
                        {{ $product->category->name }}
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-800 group-hover:text-primary transition">{{ $product->name }}</h3>
                    <p class="text-slate-500 text-sm mt-2 line-clamp-2 leading-relaxed">
                        {{ $product->description }}
                    </p>
                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex flex-col">
                            @if($product->sale_price)
                                <span class="text-xs text-slate-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="text-xl font-extrabold text-slate-900">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                            @else
                                <span class="text-xl font-extrabold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <a href="{{ route('member.orders.checkout', $product->slug) }}" class="w-12 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center group-hover:bg-primary transition shadow-xl shadow-slate-900/10 group-hover:shadow-primary/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <p class="text-slate-400">Our marketplace is preparing new items. Stay tuned!</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
