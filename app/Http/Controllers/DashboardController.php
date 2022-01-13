<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Utils;

class DashboardController extends Controller
{
    public function index()
    {
        $total_sales_today = Order::whereRaw('Date(created_at) = CURDATE()')->sum('amount');
        $users_count = User::count('id');
        $orders_today_count = Order::whereRaw('Date(created_at) = CURDATE()')->count('order_id');
        return view('admin.dashboard', compact('total_sales_today', 'users_count', 'orders_today_count'));
    }

    public function phpInfo() {
        return phpinfo();
    }
}
