@extends('layouts.app')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-20">
    <!-- Success Badge -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full mb-4 shadow-sm">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h1 class="text-3xl font-bold text-slate-900">Order Successfully Placed!</h1>
        <p class="text-slate-500 mt-2">Order #{{ $order->order_number }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[24px] border border-slate-200 p-8 shadow-sm">
                <h3 class="text-xl font-bold text-slate-900 mb-6">Order Summary</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center">
                        <div class="w-16 h-16 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                            @if($item->product->thumbnail)
                                <img src="{{ asset('storage/' . $item->product->thumbnail) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="font-bold text-slate-800">{{ $item->product->name }}</p>
                            <p class="text-sm text-slate-500">1 x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-slate-900">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-8 pt-8 border-t border-slate-100 flex justify-between items-center">
                    <span class="text-lg font-bold text-slate-600">Total Amount</span>
                    <span class="text-2xl font-black text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-white rounded-[24px] border border-slate-200 p-8 shadow-sm">
                @if($order->payment_method === 'midtrans' && $order->payment_status === 'unpaid')
                    <h3 class="text-xl font-bold text-slate-900 mb-6">Complete Automated Payment</h3>
                    <div class="bg-indigo-50 rounded-2xl p-8 border border-indigo-100 text-center">
                        <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Ready to Pay?</h4>
                        <p class="text-slate-500 mb-8 max-w-sm mx-auto">Click the button below to open the secure payment gateway and choose your preferred method.</p>
                        
                        <button id="pay-button" class="px-10 py-4 bg-primary text-white rounded-2xl font-bold text-lg hover:bg-secondary transition shadow-2xl shadow-primary/40 inline-flex items-center space-x-3">
                            <span>Pay with Midtrans</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                    </div>

                    @php
                        $isProduction = \App\Models\Setting::get('midtrans_is_production') == '1';
                        $snapUrl = $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
                        $clientKey = \App\Models\Setting::get('midtrans_client_key');
                    @endphp
                    
                    <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
                    <script type="text/javascript">
                        var payButton = document.getElementById('pay-button');
                        if(payButton) {
                            payButton.onclick = function(){
                                window.snap.pay('{{ $order->transaction_id }}', {
                                    onSuccess: function(result){
                                        window.location.reload();
                                    },
                                    onPending: function(result){
                                        window.location.reload();
                                    },
                                    onError: function(result){
                                        alert("Payment failed!");
                                    },
                                    onClose: function(){
                                        // alert('you closed the popup without finishing the payment');
                                    }
                                });
                            };
                        }
                    </script>
                @else
                    <h3 class="text-xl font-bold text-slate-900 mb-6">Payment Instruction</h3>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <p class="text-slate-700 leading-relaxed mb-4">
                            Please transfer the total amount to the bank account listed below.
                        </p>
                        <div class="p-4 bg-white rounded-xl border border-slate-200 font-mono text-lg text-primary font-bold">
                            {!! nl2br(e(\App\Models\Setting::get('manual_bank_info', 'Please contact admin for bank details.'))) !!}
                        </div>
                        <div class="mt-6 p-4 rounded-xl bg-blue-50 border border-blue-100 flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-xs text-blue-700 leading-relaxed">
                                Once payment is made, our admin will verify your transaction. You will be able to download your product from the member dashboard after verification.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <div class="bg-white rounded-[24px] border border-slate-200 p-8 shadow-sm">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Status Information</p>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Order Status</p>
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold uppercase">
                            {{ $order->status }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Payment Method</p>
                        <p class="font-bold text-slate-800">Manual Bank Transfer</p>
                    </div>
                </div>
                
                <div class="mt-8 pt-8 border-t border-slate-100">
                    <a href="{{ route('member.orders.index') }}" class="w-full py-4 border-2 border-slate-100 text-slate-600 rounded-2xl font-bold text-center flex items-center justify-center hover:bg-slate-50 transition">
                        My Order List
                    </a>
                </div>
            </div>

            <div class="p-8 bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-[24px] text-white shadow-xl">
                <h4 class="font-bold mb-2">Need Help?</h4>
                <p class="text-indigo-100 text-sm mb-6">If you have any issues with your payment, contact our support team.</p>
                <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'support@appsakola.com') }}" class="block w-full py-3 bg-white text-indigo-800 rounded-xl font-bold text-center text-sm shadow-inner transition hover:bg-indigo-50">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
