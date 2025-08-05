<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Get cart items for API
     */
    public function getItems(Request $request): JsonResponse
    {
        \Log::info('CartController@getItems called');
        
        $user = $request->user();
        
        if (!$user) {
            \Log::info('User not authenticated');
            return response()->json(['items' => []], 401);
        }

        \Log::info('User authenticated: ' . $user->id);

        try {
            // Check if Cart model exists
            if (class_exists(\App\Models\Cart::class)) {
                $cartItems = \App\Models\Cart::with('product')
                    ->where('user_id', $user->id)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product' => [
                                'id' => $item->product->id,
                                'name' => $item->product->name,
                                'price' => $item->product->price,
                                'image' => $item->product->image_url ?? null
                            ],
                            'quantity' => $item->quantity
                        ];
                    })->toArray();
            } else {
                // No Cart model, return empty cart
                \Log::info('Cart model not found, returning empty cart');
                $cartItems = [];
            }
            
            // Calculate total quantity (not just unique items count)
            $totalQuantity = collect($cartItems)->sum(fn($item) => $item['quantity']);
            
            \Log::info('Returning cart items count: ' . count($cartItems) . ', total quantity: ' . $totalQuantity);
            
            return response()->json([
                'items' => $cartItems,
                'count' => $totalQuantity, // Use total quantity instead of unique items count
                'total' => collect($cartItems)->sum(fn($item) => $item['product']['price'] * $item['quantity'])
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getItems: ' . $e->getMessage());
            // If there's any error, return empty cart
            return response()->json([
                'items' => [],
                'count' => 0,
                'total' => 0
            ]);
        }
    }

    /**
     * Get cart count
     */
    public function getCount(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['count' => 0], 401);
        }

        try {
            // Check if Cart model exists
            if (class_exists(\App\Models\Cart::class)) {
                $count = \App\Models\Cart::where('user_id', $user->id)->sum('quantity');
            } else {
                // No Cart model, return 0
                $count = 0;
            }
            
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            // If there's any error, return 0
            return response()->json(['count' => 0]);
        }
    }

    /**
     * Add item to cart
     */
    public function add(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            // Check if Cart model exists
            if (!class_exists(\App\Models\Cart::class)) {
                return response()->json(['error' => 'Cart functionality not available'], 503);
            }

            // Check if item already exists in cart
            $cartItem = \App\Models\Cart::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($cartItem) {
                // Update quantity
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                // Create new cart item
                \App\Models\Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity
                ]);
            }

            // Get updated count
            $count = \App\Models\Cart::where('user_id', $user->id)->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'count' => $count
            ]);

        } catch (\Exception $e) {
            \Log::error('Error adding to cart: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to add item to cart'], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            if (!class_exists(\App\Models\Cart::class)) {
                return response()->json(['error' => 'Cart functionality not available'], 503);
            }

            $cartItem = \App\Models\Cart::where('user_id', $user->id)
                ->where('id', $id)
                ->first();

            if (!$cartItem) {
                return response()->json(['error' => 'Cart item not found'], 404);
            }

            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            // Get updated count
            $count = \App\Models\Cart::where('user_id', $user->id)->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Cart item updated successfully',
                'count' => $count
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating cart item: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update cart item'], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            if (!class_exists(\App\Models\Cart::class)) {
                return response()->json(['error' => 'Cart functionality not available'], 503);
            }

            $cartItem = \App\Models\Cart::where('user_id', $user->id)
                ->where('id', $id)
                ->first();

            if (!$cartItem) {
                return response()->json(['error' => 'Cart item not found'], 404);
            }

            $cartItem->delete();

            // Get updated count
            $count = \App\Models\Cart::where('user_id', $user->id)->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully',
                'count' => $count
            ]);

        } catch (\Exception $e) {
            \Log::error('Error removing cart item: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to remove cart item'], 500);
        }
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            if (!class_exists(\App\Models\Cart::class)) {
                return response()->json(['error' => 'Cart functionality not available'], 503);
            }

            \App\Models\Cart::where('user_id', $user->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'count' => 0
            ]);

        } catch (\Exception $e) {
            \Log::error('Error clearing cart: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to clear cart'], 500);
        }
    }
}
