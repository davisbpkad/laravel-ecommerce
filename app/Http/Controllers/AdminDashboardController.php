<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Basic statistics
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');

        // Growth calculations (compared to last month)
        $lastMonthUsers = User::where('role', 'user')
            ->where('created_at', '<', now()->subMonth())
            ->count();
        $lastMonthOrders = Order::where('created_at', '<', now()->subMonth())->count();
        $lastMonthRevenue = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '<', now()->subMonth())
            ->sum('total_amount');

        $usersGrowth = $lastMonthUsers > 0 ? round((($totalUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1) : 0;
        $ordersGrowth = $lastMonthOrders > 0 ? round((($totalOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1) : 0;
        $revenueGrowth = $lastMonthRevenue > 0 ? round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 0;

        // Recent orders
        $recentOrders = Order::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock', '<=', 10)
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'totalRevenue' => $totalRevenue,
                'revenueGrowth' => $revenueGrowth,
                'totalOrders' => $totalOrders,
                'ordersGrowth' => $ordersGrowth,
                'totalProducts' => $totalProducts,
                'activeProducts' => $activeProducts,
                'totalUsers' => $totalUsers,
                'usersGrowth' => $usersGrowth,
            ],
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }

    /**
     * Sales report
     */
    public function salesReport(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));
        $type = $request->get('type', 'monthly');

        // Sales summary
        $totalSales = Order::whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $totalOrders = Order::whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('status', '!=', 'cancelled')
            ->count();

        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        $totalCustomers = Order::whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('status', '!=', 'cancelled')
            ->distinct('user_id')
            ->count();

        // Top products in period
        $topProducts = Product::select(
                'products.id',
                'products.name',
                'products.image',
                DB::raw('SUM(order_items.quantity) as sales_count'),
                DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
            )
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->where('orders.status', '!=', 'cancelled')
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        // Payment methods distribution
        $paymentMethods = Order::whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('status', '!=', 'cancelled')
            ->select('payment_method', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get()
            ->map(function ($item) use ($totalOrders) {
                return [
                    'method' => $item->payment_method,
                    'count' => $item->count,
                    'percentage' => $totalOrders > 0 ? round(($item->count / $totalOrders) * 100, 1) : 0
                ];
            });

        return Inertia::render('Admin/SalesReport', [
            'report' => [
                'totalSales' => $totalSales,
                'totalOrders' => $totalOrders,
                'averageOrderValue' => $averageOrderValue,
                'totalCustomers' => $totalCustomers,
                'topProducts' => $topProducts,
                'paymentMethods' => $paymentMethods,
            ],
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'type' => $type,
            ],
        ]);
    }
}
