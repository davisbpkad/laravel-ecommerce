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
            
            \Log::info('Returning cart items count: ' . count($cartItems));
            
            return response()->json([
                'items' => $cartItems,
                'count' => count($cartItems),
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
}
