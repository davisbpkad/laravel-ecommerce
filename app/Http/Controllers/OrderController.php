<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the checkout form
     */
    public function create()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->withErrors(['error' => 'Your cart is empty.']);
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->withErrors(['error' => "Insufficient stock for {$item->product->name}."]);
            }
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return Inertia::render('Checkout/Index', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    /**
     * Process checkout and create order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|array',
            'shipping_address.first_name' => 'required|string|max:255',
            'shipping_address.last_name' => 'required|string|max:255',
            'shipping_address.email' => 'required|email|max:255',
            'shipping_address.phone' => 'required|string|max:20',
            'shipping_address.address' => 'required|string',
            'shipping_address.city' => 'required|string|max:255',
            'shipping_address.state' => 'required|string|max:255',
            'shipping_address.postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:bank_transfer,cod,e_wallet',
            'notes' => 'nullable|string|max:500',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['error' => 'Your cart is empty.']);
        }

        // Check stock availability before processing
        foreach ($cartItems as $cartItem) {
            if ($cartItem->product->stock < $cartItem->quantity) {
                return back()->withErrors(['error' => "Insufficient stock for {$cartItem->product->name}."]);
            }
        }

        $order = null;

        try {
            DB::transaction(function () use ($validated, $cartItems, &$order) {
                // Calculate total
                $total = $cartItems->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                });

                // Create order
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => Order::generateOrderNumber(),
                    'total_amount' => $total,
                    'status' => 'pending',
                    'payment_method' => $validated['payment_method'],
                    'shipping_address' => $validated['shipping_address'],
                    'notes' => $validated['notes'] ?? null,
                ]);

                // Create order items and update stock
                foreach ($cartItems as $cartItem) {
                    // Double check stock inside transaction
                    if ($cartItem->product->stock < $cartItem->quantity) {
                        throw new \Exception("Insufficient stock for {$cartItem->product->name}.");
                    }

                    // Create order item
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->product->price,
                    ]);

                    // Update product stock
                    $cartItem->product->decrement('stock', $cartItem->quantity);
                }

                // Clear cart
                Cart::where('user_id', auth()->id())->delete();
            });

            return redirect()->route('orders.success', ['order' => $order->id])
                ->with('success', 'Order placed successfully!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to process order: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['orderItems.product']);

        return Inertia::render('Orders/Show', [
            'order' => $order,
        ]);
    }

    /**
     * Show order success page
     */
    public function success(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['orderItems.product']);

        return Inertia::render('Orders/Success', [
            'order' => $order,
        ]);
    }

    /**
     * Admin: Display all orders
     */
    public function adminIndex(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $orders = Order::with(['user', 'orderItems'])
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query, $search) {
                return $query->where('order_number', 'like', "%{$search}%")
                           ->orWhereHas('user', function ($q) use ($search) {
                               $q->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                           });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders,
            'filters' => [
                'status' => $status,
                'search' => $search,
            ],
        ]);
    }

    /**
     * Admin: Show order details
     */
    public function adminShow(Order $order)
    {
        $order->load(['user', 'orderItems.product']);

        return Inertia::render('Admin/Orders/Show', [
            'order' => $order,
        ]);
    }

    /**
     * Admin: Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Cancel an order (only if pending)
     */
    public function cancel(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending orders can be cancelled.']);
        }

        DB::transaction(function () use ($order) {
            // Restore product stock
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            // Update order status
            $order->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Order cancelled successfully.');
    }

    /**
     * Reorder items from a previous order
     */
    public function reorder(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        DB::transaction(function () use ($order) {
            foreach ($order->orderItems as $item) {
                // Check if product is still available and in stock
                if ($item->product->is_active && $item->product->stock >= $item->quantity) {
                    // Check if item already exists in cart
                    $cartItem = Cart::where('user_id', auth()->id())
                        ->where('product_id', $item->product_id)
                        ->first();

                    if ($cartItem) {
                        // Update quantity if there's enough stock
                        $newQuantity = $cartItem->quantity + $item->quantity;
                        if ($item->product->stock >= $newQuantity) {
                            $cartItem->update(['quantity' => $newQuantity]);
                        }
                    } else {
                        // Create new cart item
                        Cart::create([
                            'user_id' => auth()->id(),
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('cart.index')
            ->with('success', 'Items added to cart successfully.');
    }

    /**
     * Track order (placeholder for tracking page)
     */
    public function track(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['orderItems.product']);

        return Inertia::render('Orders/Track', [
            'order' => $order,
        ]);
    }
}
