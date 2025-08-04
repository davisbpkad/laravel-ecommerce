<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Cart;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Check if user is admin and redirect to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        // Get user's recent orders (last 5)
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'status' => $order->status,
                    'total_amount' => $order->total_amount,
                    'items_count' => $order->orderItems->count(),
                    'created_at' => $order->created_at->toISOString(),
                ];
            });

        // Get user statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        // Get cart items count
        $cartItemsCount = Cart::where('user_id', $user->id)->sum('quantity');

        $stats = [
            'totalOrders' => $totalOrders,
            'totalSpent' => $totalSpent,
        ];

        return Inertia::render('Dashboard', [
            'recentOrders' => $recentOrders,
            'stats' => $stats,
            'cartItemsCount' => $cartItemsCount,
        ]);
    }
}
