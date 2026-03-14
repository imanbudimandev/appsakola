<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        \Midtrans\Config::$serverKey = Setting::get('midtrans_server_key');
        \Midtrans\Config::$isProduction = (Setting::get('midtrans_is_production') == '1');
        
        try {
            $notification = new \Midtrans\Notification();

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $order_id = $notification->order_id;
            $fraud = $notification->fraud_status;

            $order = Order::where('order_number', $order_id)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['payment_status' => 'pending']);
                    } else {
                        $order->update(['payment_status' => 'paid', 'status' => 'completed']);
                    }
                }
            } else if ($transaction == 'settlement') {
                $order->update(['payment_status' => 'paid', 'status' => 'completed']);
            } else if ($transaction == 'pending') {
                $order->update(['payment_status' => 'pending']);
            } else if ($transaction == 'deny') {
                $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            } else if ($transaction == 'expire') {
                $order->update(['payment_status' => 'expired', 'status' => 'cancelled']);
            } else if ($transaction == 'cancel') {
                $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            }

            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }
}
