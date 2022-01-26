<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Auth;
use Utils;
use DB;

class DashboardController extends Controller
{
    private $page = "Dashboard";

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $allowed_pages = explode(",",Auth::user()->allowed_pages);
                if (!in_array($this->page, $allowed_pages)) {
                    return redirect('/not-auth');
                }
            }
            return $next($request);
        });
    }

    public function index()
    {      
        $total_sales_today = Order::whereRaw('Date(created_at) = CURDATE()')->sum('amount');
        $users_count = User::count('id');
        $orders_today_count = Order::whereRaw('Date(created_at) = CURDATE()')->count('order_id');
        $total_sales_this_year = Order::whereYear('created_at', date('Y'))->sum('amount');
        $percentage_rate = $this->getSalesPercentageRate();
        
        $best_selling = Order::select(DB::raw('SUM(orders.qty) as total_qty'), DB::raw('SUM(orders.amount) as total_sales'), 'P.size', 'P.name','P.price', 'P.sku')
        ->leftJoin('products as P', 'P.sku', '=', 'orders.sku')
        ->groupBy('orders.sku', 'P.name','P.price', 'P.size', 'P.sku')
        ->orderBy('total_qty', 'DESC')
        ->whereMonth('orders.created_at', date('m'))
        ->limit(6)
        ->get();
      
        return view('admin.dashboard', compact('total_sales_today', 'users_count', 'orders_today_count', 'best_selling', 'total_sales_this_year', 'percentage_rate'));
    }

    public function getSalesPercentageRate() {
        $total_sales_this_month = Order::whereMonth('created_at', date('m'))->sum('amount');
        $total_sales_last_month = Order::whereMonth('created_at', date('m', strtotime("-1 month")))->sum('amount');

        if (($total_sales_last_month != 0) && ($total_sales_this_month  != 0)) {
            $percentChange = (1 - $total_sales_last_month / $total_sales_this_month ) * 100;
        }
        else {
            $percentChange = null;
        }
        return $percentChange;
    }

    public function phpInfo() {
        return phpinfo();
    }

    public function salesOverview() {

        $sales_overview = Order::select(DB::raw('SUM(orders.amount) as total_sales'), DB::raw('MONTH(created_at) month'))
        ->groupby('month')
        ->whereYear('created_at', date('Y'))
        ->get();

        $total_sales_arr = array();
        $months_arr = array();

        foreach ($sales_overview as $data) {
            array_push($total_sales_arr, $data->total_sales);
            array_push($months_arr, Utils::abbreviateMonthNumber($data->month));
        }

        $sales_overview_last_yr = Order::select(DB::raw('SUM(orders.amount) as total_sales'), DB::raw('MONTH(created_at) month'))
        ->groupby('month')
        ->whereYear('created_at', date('Y', strtotime("-1 year")))
        ->get();

        $total_sales_arr_last_yr = array();

        foreach ($sales_overview_last_yr as $data) {
            array_push($total_sales_arr_last_yr, $data->total_sales);
        }

        return json_encode(array("total_sales" => $total_sales_arr, "months" => $months_arr, 
                                "total_sales_last_yr" => $total_sales_arr_last_yr
                                ));
    }
}
