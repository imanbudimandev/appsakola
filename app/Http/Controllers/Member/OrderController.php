<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Product $product)
    {
        // Simple manual checkout page
        return view('member.orders.checkout', compact('product'));
    }

    public function process(Request $request, Product $product)
    {
        $request->validate([
            'payment_method' => 'required|in:manual_bank,midtrans',
        ]);

        try {
            DB::beginTransaction();

            $orderNumber = 'ORD-' . strtoupper(Str::random(10));
            $amount = $product->sale_price ?? $product->price;

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'total_amount' => $amount,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $amount,
                'quantity' => 1,
            ]);

            DB::commit();

            if ($request->payment_method === 'midtrans') {
                // Midtrans Integration
                \Midtrans\Config::$serverKey  = \App\Models\Setting::get('midtrans_server_key');
                \Midtrans\Config::$isProduction = (\App\Models\Setting::get('midtrans_is_production') == '1');
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds       = true;

                $params = [
                    'transaction_details' => [
                        'order_id'    => $order->order_number,
                        'gross_amount'=> (int) $amount,
                    ],
                    'customer_details' => [
                        'first_name' => auth()->user()->name,
                        'email'      => auth()->user()->email,
                    ],
                    'item_details' => [
                        [
                            'id'       => $product->id,
                            'price'    => (int) $amount,
                            'quantity' => 1,
                            'name'     => $product->name,
                        ]
                    ],
                ];

                // Apply enabled payment methods if configured
                $savedMethods = json_decode(\App\Models\Setting::get('midtrans_payment_methods', '[]'), true);
                if (!empty($savedMethods)) {
                    $params['enabled_payments'] = $savedMethods;
                }

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $order->update(['transaction_id' => $snapToken]);
                
                return redirect()->route('member.orders.show', $order);
            }

            return redirect()->route('member.orders.show', $order)->with('success', 'Order placed successfully! Please complete your payment.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to process order. ' . $e->getMessage()]);
        }
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('member.orders.show', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('member.orders.index', compact('orders'));
    }

    public function download(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_status !== 'paid') {
            return back()->withErrors(['error' => 'Pembayaran belum dikonfirmasi. Silakan tunggu konfirmasi dari admin.']);
        }

        $order->load('items.product');
        $product = $order->items->first()?->product;

        if (!$product || !$product->file_path) {
            return back()->withErrors(['error' => 'File produk tidak tersedia. Hubungi admin.']);
        }

        $filePath = storage_path('app/private/' . $product->file_path);

        if (!file_exists($filePath)) {
            return back()->withErrors(['error' => 'File tidak ditemukan di server. Hubungi admin.']);
        }

        return response()->download($filePath, basename($filePath));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_status === 'paid') {
            return back()->withErrors(['error' => 'Order yang sudah dibayar tidak bisa dibatalkan. Hubungi admin.']);
        }

        if ($order->status === 'cancelled') {
            return back()->withErrors(['error' => 'Order ini sudah dibatalkan sebelumnya.']);
        }

        $order->update([
            'status'         => 'cancelled',
            'payment_status' => 'unpaid',
        ]);

        return redirect()->route('member.orders.index')
            ->with('success', 'Order #' . $order->order_number . ' berhasil dibatalkan.');
    }

    public function checkStatus(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_method !== 'midtrans' || !$order->transaction_id) {
            return back()->with('error', 'Metode pembayaran bukan Midtrans atau transaksi tidak ditemukan.');
        }

        \Midtrans\Config::$serverKey = \App\Models\Setting::get('midtrans_server_key');
        \Midtrans\Config::$isProduction = (\App\Models\Setting::get('midtrans_is_production') == '1');

        try {
            $status = \Midtrans\Transaction::status($order->order_number);
            
            $transaction = $status->transaction_status;
            
            if ($transaction == 'settlement' || $transaction == 'capture') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'completed'
                ]);
                return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
            } else if ($transaction == 'pending') {
                return back()->with('error', 'Pembayaran masih pending. Silakan selesaikan pembayaran Anda.');
            } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled'
                ]);
                return back()->with('error', 'Pembayaran gagal atau kedaluwarsa.');
            }

            return back()->with('info', 'Status pembayaran: ' . $transaction);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengecek status: ' . $e->getMessage());
        }
    }

    public function invoice(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product', 'user');
        return view('member.orders.invoice', compact('order'));
    }
}
