@extends('layouts.app')

@section('title', 'Checkout - ' . $product->name)

@section('content')
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
                            <i class="fa fa-image fa-3x"></i>
                        </div>
                    @endif
                </div>
                <h2 class="text-2xl font-bold text-slate-900">{{ $product->name }}</h2>
                <div class="mt-4 p-4 bg-white rounded-2xl border border-slate-100">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Subtotal</span>
                        <span class="text-xl font-bold text-slate-900">Rp {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="md:w-1/2 p-8 md:p-12">
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Complete Your Order</h3>
                <p class="text-slate-500 mb-8">Securely process your payment for this digital asset.</p>

                <form action="{{ route('member.orders.process', $product->slug) }}" method="POST">
                    @csrf
                    
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-slate-700 mb-4 uppercase tracking-widest">Select Payment Method</label>
                        <div class="space-y-4">
                            <!-- Manual Bank -->
                            <label class="relative flex items-center p-4 cursor-pointer rounded-2xl border-2 border-primary bg-primary/5 transition payment-option">
                                <input type="radio" name="payment_method" value="manual_bank" checked class="hidden">
                                <div class="flex-1 flex items-center">
                                    <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">Manual Bank Transfer</p>
                                        <p class="text-xs text-slate-500">Pay via ATM or Mobile Banking</p>
                                    </div>
                                </div>
                                <div class="text-primary check-icon">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </label>

                            <!-- Midtrans -->
                            <label class="relative flex items-center p-4 cursor-pointer rounded-2xl border-2 border-slate-100 hover:border-primary transition payment-option">
                                <input type="radio" name="payment_method" value="midtrans" class="hidden">
                                <div class="flex-1 flex items-center">
                                    <div class="w-10 h-10 bg-indigo-500 text-white rounded-xl flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">Midtrans Checkout</p>
                                        <p class="text-xs text-slate-500">QRIS, VA, Credit Card</p>
                                    </div>
                                </div>
                                <div class="text-primary check-icon hidden">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </label>
                        </div>
                    </div>

                    @auth
                        <button type="submit" class="w-full py-4 bg-primary text-white rounded-[20px] font-bold text-lg hover:bg-secondary transition shadow-2xl shadow-primary/30 flex items-center justify-center space-x-2">
                            <span>Place Order & Pay</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    @else
                        <div class="space-y-3">
                            <p class="text-center text-xs text-slate-400 mb-4">You need to be logged in to complete your purchase.</p>
                            <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="block w-full py-4 bg-slate-900 text-white rounded-[20px] font-bold text-center hover:bg-slate-800 transition shadow-xl">
                                Login to Purchase
                            </a>
                            <a href="{{ route('register') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="block w-full py-4 bg-white text-slate-700 border border-slate-200 rounded-[20px] font-bold text-center hover:bg-slate-50 transition">
                                Create Member Account
                            </a>
                        </div>
                    @endauth
                    
                    <p class="text-center text-slate-400 text-[10px] mt-6 leading-relaxed">
                        Secure checkout powered by appsakola. Your download will be available immediately after payment confirmation.
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
