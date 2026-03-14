@extends('layouts.app')

@section('title', 'Checkout - ' . $product->name)

@section('content')
@php
    $midtransKey    = \App\Models\Setting::get('midtrans_server_key');
    $enableMidtrans = !empty($midtransKey);
    $bankInfo       = \App\Models\Setting::get('manual_bank_info');
    $enableBank     = !empty($bankInfo);

    // Jika keduanya tidak dikonfigurasi, tampilkan bank sebagai fallback
    if (!$enableMidtrans && !$enableBank) {
        $enableBank = true;
    }

    // Default pilihan
    $defaultMethod = $enableMidtrans ? 'midtrans' : 'manual_bank';
@endphp

<div class="max-w-4xl mx-auto px-4 py-20">
    <div class="bg-white rounded-[32px] border border-slate-200 shadow-xl overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Product Preview -->
            <div class="md:w-1/2 bg-slate-50 p-8 flex flex-col justify-center border-b md:border-b-0 md:border-r border-slate-100">
                <div class="aspect-video rounded-2xl overflow-hidden mb-6 shadow-sm">
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>
                <h2 class="text-2xl font-bold text-slate-900">{{ $product->name }}</h2>
                <p class="text-slate-500 text-sm mt-2 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
                <div class="mt-6 p-4 bg-white rounded-2xl border border-slate-100">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Total Bayar</span>
                        <span class="text-2xl font-bold text-primary">Rp {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}</span>
                    </div>
                    @if($product->sale_price && $product->sale_price < $product->price)
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-xs text-slate-400">Harga Normal</span>
                        <span class="text-sm text-slate-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="md:w-1/2 p-8 md:p-12">
                <h3 class="text-2xl font-bold text-slate-900 mb-1">Selesaikan Pesanan</h3>
                <p class="text-slate-500 text-sm mb-8">Pilih metode pembayaran yang Anda inginkan.</p>

                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    {{ $errors->first() }}
                </div>
                @endif

                <form action="{{ route('member.orders.process', $product->slug) }}" method="POST">
                    @csrf

                    @if(request()->has('redirect'))
                        <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
                    @endif

                    <!-- Pilihan Metode Pembayaran -->
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-slate-700 mb-4 uppercase tracking-widest">Metode Pembayaran</label>
                        <div class="space-y-3">

                            {{-- Midtrans: only show if server key configured --}}
                            @if($enableMidtrans)
                            <label class="relative flex items-center p-4 cursor-pointer rounded-2xl border-2 {{ $defaultMethod == 'midtrans' ? 'border-primary bg-primary/5' : 'border-slate-100 hover:border-primary' }} transition payment-option">
                                <input type="radio" name="payment_method" value="midtrans" {{ $defaultMethod == 'midtrans' ? 'checked' : '' }} class="hidden">
                                <div class="flex-1 flex items-center">
                                    <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Bayar Online (Midtrans)</p>
                                        <p class="text-xs text-slate-500">QRIS, Virtual Account BCA/BNI/BRI, GoPay, ShopeePay, Kartu Kredit</p>
                                    </div>
                                </div>
                                <div class="text-primary check-icon {{ $defaultMethod == 'midtrans' ? '' : 'hidden' }} flex-shrink-0 ml-3">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                </div>
                            </label>
                            @endif

                            {{-- Bank Transfer: only show if bank info configured --}}
                            @if($enableBank)
                            <label class="relative flex items-center p-4 cursor-pointer rounded-2xl border-2 {{ $defaultMethod == 'manual_bank' ? 'border-primary bg-primary/5' : 'border-slate-100 hover:border-primary' }} transition payment-option">
                                <input type="radio" name="payment_method" value="manual_bank" {{ $defaultMethod == 'manual_bank' ? 'checked' : '' }} class="hidden">
                                <div class="flex-1 flex items-center">
                                    <div class="w-10 h-10 bg-slate-600 text-white rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Transfer Bank Manual</p>
                                        <p class="text-xs text-slate-500">Transfer ke rekening admin, menunggu konfirmasi manual</p>
                                    </div>
                                </div>
                                <div class="text-primary check-icon {{ $defaultMethod == 'manual_bank' ? '' : 'hidden' }} flex-shrink-0 ml-3">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                </div>
                            </label>
                            @endif

                        </div>
                    </div>

                    @auth
                        <button type="submit" class="w-full py-4 bg-primary text-white rounded-[20px] font-bold text-lg hover:bg-secondary transition shadow-2xl shadow-primary/30 flex items-center justify-center space-x-2">
                            <span>Buat Pesanan</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    @else
                        <div class="space-y-3">
                            <p class="text-center text-xs text-slate-400 mb-4">Anda perlu login untuk menyelesaikan pembelian.</p>
                            <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="block w-full py-4 bg-slate-900 text-white rounded-[20px] font-bold text-center hover:bg-slate-800 transition shadow-xl">
                                Login untuk Membeli
                            </a>
                            <a href="{{ route('register') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="block w-full py-4 bg-white text-slate-700 border border-slate-200 rounded-[20px] font-bold text-center hover:bg-slate-50 transition">
                                Daftar Akun Member
                            </a>
                        </div>
                    @endauth

                    <p class="text-center text-slate-400 text-[10px] mt-6 leading-relaxed">
                        Transaksi aman. Download tersedia setelah pembayaran dikonfirmasi.
                    </p>
                </form>

                <script>
                    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
                        input.addEventListener('change', function() {
                            document.querySelectorAll('.payment-option').forEach(label => {
                                label.classList.remove('border-primary', 'bg-primary/5');
                                label.classList.add('border-slate-100');
                                label.querySelector('.check-icon')?.classList.add('hidden');
                            });
                            if (this.checked) {
                                let label = this.closest('.payment-option');
                                label.classList.add('border-primary', 'bg-primary/5');
                                label.classList.remove('border-slate-100');
                                label.querySelector('.check-icon')?.classList.remove('hidden');
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
