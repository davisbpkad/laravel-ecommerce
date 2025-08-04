<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of products for users
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        $products = Product::active()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'ilike', "%{$search}%")
                           ->orWhere('description', 'ilike', "%{$search}%");
            })
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->orderBy($sort, $direction)
            ->paginate(12);

        $categories = Product::active()
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return Inertia::render('Products/Index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'search' => $search,
                'category' => $category,
                'sort' => $sort,
                'direction' => $direction,
            ],
        ]);
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }

    /**
     * Display a listing of products for admin
     */
    public function adminIndex(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        $status = $request->get('status');

        $products = Product::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'ilike', "%{$search}%")
                           ->orWhere('description', 'ilike', "%{$search}%");
            })
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                if ($status === 'active') {
                    return $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    return $query->where('is_active', false);
                }
                return $query;
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $categories = Product::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'search' => $search,
                'category' => $category,
                'status' => $status,
            ],
        ]);
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('products', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image) {
                $oldImagePath = str_replace('/storage/', '', $product->image);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $image = $request->file('image');
            $imagePath = $image->store('products', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Bulk delete multiple products
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        try {
            $productIds = $validated['product_ids'];
            $products = Product::whereIn('id', $productIds)->get();
            
            if ($products->isEmpty()) {
                return redirect()->route('admin.products.index')
                    ->with('error', 'No products found to delete.');
            }

            $deletedCount = 0;
            
            foreach ($products as $product) {
                // Delete associated image if it exists
                if ($product->image) {
                    $imagePath = str_replace('/storage/', '', $product->image);
                    Storage::disk('public')->delete($imagePath);
                }
                
                $product->delete();
                $deletedCount++;
            }

            return redirect()->route('admin.products.index')
                ->with('success', "Successfully deleted {$deletedCount} product(s).");
                
        } catch (\Exception $e) {
            \Log::error('Bulk delete error: ' . $e->getMessage());
            
            return redirect()->route('admin.products.index')
                ->with('error', 'An error occurred while deleting products. Please try again.');
        }
    }

    /**
     * Bulk toggle status for multiple products
     */
    public function bulkToggleStatus(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        try {
            $productIds = $validated['product_ids'];
            $products = Product::whereIn('id', $productIds)->get();
            
            if ($products->isEmpty()) {
                return redirect()->route('admin.products.index')
                    ->with('error', 'No products found to update.');
            }

            $updatedCount = 0;
            
            foreach ($products as $product) {
                $product->update(['is_active' => !$product->is_active]);
                $updatedCount++;
            }

            return redirect()->route('admin.products.index')
                ->with('success', "Successfully updated {$updatedCount} product(s) status.");
                
        } catch (\Exception $e) {
            \Log::error('Bulk toggle status error: ' . $e->getMessage());
            
            return redirect()->route('admin.products.index')
                ->with('error', 'An error occurred while updating product status. Please try again.');
        }
    }
}
