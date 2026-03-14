<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->get();

        return view('member.dashboard', compact('orders'));
    }

    public function products(Request $request)
    {
        $query = Product::where('status', 'active')->with('category');

        // Filter by search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products   = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        // Get list of product IDs that user already purchased
        $purchasedProductIds = Order::where('user_id', auth()->id())
            ->where('payment_status', 'paid')
            ->with('items')
            ->get()
            ->pluck('items')
            ->flatten()
            ->pluck('product_id')
            ->toArray();

        return view('member.products', compact('products', 'categories', 'purchasedProductIds'));
    }
}
