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
                \Midtrans\Config::$serverKey = \App\Models\Setting::get('midtrans_server_key');
                \Midtrans\Config::$isProduction = (\App\Models\Setting::get('midtrans_is_production') == '1');
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_number,
                        'gross_amount' => (int) $amount,
                    ],
                    'customer_details' => [
                        'first_name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                    ],
                    'item_details' => [
                        [
                            'id' => $product->id,
                            'price' => (int) $amount,
                            'quantity' => 1,
                            'name' => $product->name,
                        ]
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $order->update(['transaction_id' => $snapToken]); // We'll use this as temporary snap token storage or add a column
                
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
}
