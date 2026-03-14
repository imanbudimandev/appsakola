@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
<div class="row column1">
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div> 
                <i class="fa fa-money yellow_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                <p class="total_no" style="font-size: 20px;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                <p class="head_couter">Revenue</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div> 
                <i class="fa fa-shopping-cart blue1_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                <p class="total_no" style="font-size: 24px;">{{ $stats['total_orders'] }}</p>
                <p class="head_couter">Orders</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div> 
                <i class="fa fa-cubes green_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                <p class="total_no" style="font-size: 24px;">{{ $stats['total_products'] }}</p>
                <p class="head_couter">Products</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div> 
                <i class="fa fa-users red_color"></i>
                </div>
            </div>
            <div class="counter_no">
                <div>
                <p class="total_no" style="font-size: 24px;">{{ $stats['total_users'] }}</p>
                <p class="head_couter">Customers</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- graph -->
<div class="row column2 graph margin_bottom_30">
    <div class="col-md-l2 col-lg-12">
        <div class="white_shd full">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                <h2>Recent Orders</h2>
                </div>
            </div>
            <div class="full graph_revenue p-4">
                <div class="table-responsive">
                    <table class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_orders as $order)
                            <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $order->status == 'completed' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No orders yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end graph -->

@endsection
