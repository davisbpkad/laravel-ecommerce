<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        try {
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

        } catch (\Exception $e) {
            // If tables don't exist yet (during deployment), use default values
            $totalUsers = 0;
            $totalProducts = 0;
            $activeProducts = 0;
            $totalOrders = 0;
            $totalRevenue = 0;
            $usersGrowth = 0;
            $ordersGrowth = 0;
            $revenueGrowth = 0;
            $recentOrders = collect();
            $lowStockProducts = collect();
        }

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

    /**
     * Generate monthly sales report
     */
    public function generateMonthlyReport(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        // Create date range for the selected month
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        
        // Get monthly sales data
        $monthlyData = $this->getMonthlyReportData($startDate, $endDate);
        
        return response()->json([
            'status' => 'success',
            'data' => $monthlyData,
            'period' => [
                'year' => $year,
                'month' => $month,
                'month_name' => $startDate->format('F'),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ]
        ]);
    }

    /**
     * Export monthly sales report
     */
    public function exportMonthlyReport(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $format = $request->get('format', 'csv'); // csv, json, pdf
        
        // Create date range for the selected month
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        
        // Get monthly sales data
        $monthlyData = $this->getMonthlyReportData($startDate, $endDate);
        
        $fileName = "sales_report_{$year}_{$month}." . $format;
        
        switch ($format) {
            case 'csv':
                return $this->exportToCSV($monthlyData, $fileName, $startDate);
            case 'json':
                return $this->exportToJSON($monthlyData, $fileName);
            default:
                return $this->exportToCSV($monthlyData, $fileName, $startDate);
        }
    }

    /**
     * Get monthly report data
     */
    private function getMonthlyReportData($startDate, $endDate)
    {
        // Total sales for the month
        $totalSales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        // Total orders for the month
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->count();

        // Average order value
        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // Total customers
        $totalCustomers = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->distinct('user_id')
            ->count();

        // Daily sales breakdown for the month
        $dailySales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(total_amount) as daily_sales')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Top products for the month
        $topProducts = Product::select(
                'products.id',
                'products.name',
                'products.category',
                'products.price',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->groupBy('products.id', 'products.name', 'products.category', 'products.price')
            ->orderBy('total_sold', 'desc')
            ->get();

        // Payment methods breakdown
        $paymentMethods = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total_amount'))
            ->groupBy('payment_method')
            ->get();

        // Order status breakdown
        $orderStatus = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return [
            'summary' => [
                'total_sales' => $totalSales,
                'total_orders' => $totalOrders,
                'average_order_value' => $averageOrderValue,
                'total_customers' => $totalCustomers,
            ],
            'daily_sales' => $dailySales,
            'top_products' => $topProducts,
            'payment_methods' => $paymentMethods,
            'order_status' => $orderStatus,
        ];
    }

    /**
     * Export data to CSV format
     */
    private function exportToCSV($data, $fileName, $startDate)
    {
        $output = fopen('php://temp', 'r+');
        
        // Add header with report information
        fputcsv($output, ['Sales Report - ' . $startDate->format('F Y')]);
        fputcsv($output, ['Generated on: ' . now()->format('Y-m-d H:i:s')]);
        fputcsv($output, []);
        
        // Summary section
        fputcsv($output, ['SUMMARY']);
        fputcsv($output, ['Total Sales', 'Rp ' . number_format($data['summary']['total_sales'], 0, ',', '.')]);
        fputcsv($output, ['Total Orders', $data['summary']['total_orders']]);
        fputcsv($output, ['Average Order Value', 'Rp ' . number_format($data['summary']['average_order_value'], 0, ',', '.')]);
        fputcsv($output, ['Total Customers', $data['summary']['total_customers']]);
        fputcsv($output, []);
        
        // Daily sales section
        fputcsv($output, ['DAILY SALES']);
        fputcsv($output, ['Date', 'Orders Count', 'Daily Sales']);
        foreach ($data['daily_sales'] as $daily) {
            fputcsv($output, [
                $daily->date,
                $daily->orders_count,
                'Rp ' . number_format($daily->daily_sales, 0, ',', '.')
            ]);
        }
        fputcsv($output, []);
        
        // Top products section
        fputcsv($output, ['TOP PRODUCTS']);
        fputcsv($output, ['Product Name', 'Category', 'Price', 'Total Sold', 'Total Revenue']);
        foreach ($data['top_products'] as $product) {
            fputcsv($output, [
                $product->name,
                $product->category,
                'Rp ' . number_format($product->price, 0, ',', '.'),
                $product->total_sold,
                'Rp ' . number_format($product->total_revenue, 0, ',', '.')
            ]);
        }
        fputcsv($output, []);
        
        // Payment methods section
        fputcsv($output, ['PAYMENT METHODS']);
        fputcsv($output, ['Payment Method', 'Orders Count', 'Total Amount']);
        foreach ($data['payment_methods'] as $method) {
            fputcsv($output, [
                ucfirst(str_replace('_', ' ', $method->payment_method)),
                $method->count,
                'Rp ' . number_format($method->total_amount, 0, ',', '.')
            ]);
        }
        
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        
        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Export data to JSON format
     */
    private function exportToJSON($data, $fileName)
    {
        $jsonData = [
            'report_generated' => now()->toISOString(),
            'data' => $data
        ];
        
        return Response::json($jsonData, 200, [
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
