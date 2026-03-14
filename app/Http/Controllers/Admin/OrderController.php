<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'         => 'required|in:pending,completed,failed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,partially_paid',
        ]);

        $order->update([
            'status'         => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Status order berhasil diperbarui.');
    }

    /**
     * Confirm manual bank transfer payment & mark order completed.
     */
    public function confirmPayment(Request $request, Order $order)
    {
        $order->update([
            'payment_status' => 'paid',
            'status'         => 'completed',
        ]);

        return back()->with('success', 'Pembayaran order #' . $order->order_number . ' telah dikonfirmasi. Member sekarang bisa download produk.');
    }
}
