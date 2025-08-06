<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
        $showDeleted = $request->get('show_deleted', false);

        $query = Product::with('category');
        
        // Include or exclude soft deleted products
        if ($showDeleted) {
            $query = $query->onlyTrashed();
        }

        $products = $query
            ->when($search, function ($query, $search) {
                return $query->where('name', 'ilike', "%{$search}%")
                           ->orWhere('description', 'ilike', "%{$search}%");
            })
            ->when($category, function ($query, $category) {
                return $query->where('category_id', $category);
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

        $categories = \App\Models\Category::orderBy('name')->get();

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'search' => $search,
                'category' => $category,
                'status' => $status,
                'show_deleted' => $showDeleted,
            ],
        ]);
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        
        return Inertia::render('Admin/Products/Create', [
            'categories' => $categories,
        ]);
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
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        try {
            // Handle image upload - Store as base64 for Railway
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Convert to base64 for Railway persistence
                $imageData = base64_encode(file_get_contents($image->getRealPath()));
                $mimeType = $image->getMimeType();
                
                // Store as data URL
                $validated['image'] = "data:{$mimeType};base64,{$imageData}";
            }

            $product = Product::create($validated);

            return redirect()->route('admin.admin.products.index')
                ->with('success', "Product '{$validated['name']}' has been created successfully.");
        } catch (\Exception $e) {
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create product. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product->load('category'),
            'categories' => $categories,
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
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        try {
            // Handle image upload - Store as base64 for Railway
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Convert to base64 for Railway persistence
                $imageData = base64_encode(file_get_contents($image->getRealPath()));
                $mimeType = $image->getMimeType();
                
                // Store as data URL
                $validated['image'] = "data:{$mimeType};base64,{$imageData}";
            }

            $product->update($validated);

            return redirect()->route('admin.admin.products.index')
                ->with('success', "Product '{$validated['name']}' has been updated successfully.");
        } catch (\Exception $e) {
            \Log::error('Product update error: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update product. Please try again.');
        }
    }

    /**
     * Remove the specified product (soft delete)
     */
    public function destroy(Product $product)
    {
        try {
            $productName = $product->name;
            $product->delete(); // This will soft delete

            return redirect()->route('admin.admin.products.index')
                ->with('success', "Product '{$productName}' has been moved to trash successfully.");
        } catch (\Exception $e) {
            \Log::error('Product soft deletion error: ' . $e->getMessage());
            
            return redirect()->route('admin.admin.products.index')
                ->with('error', 'Failed to delete product. Please try again.');
        }
    }

    /**
     * Restore a soft deleted product
     */
    public function restore($id)
    {
        try {
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->restore();

            return redirect()->route('admin.admin.products.index')
                ->with('success', "Product '{$product->name}' has been restored successfully.");
        } catch (\Exception $e) {
            \Log::error('Product restoration error: ' . $e->getMessage());
            
            return redirect()->route('admin.admin.products.index')
                ->with('error', 'Failed to restore product. Please try again.');
        }
    }

    /**
     * Permanently delete a product
     */
    public function forceDestroy($id)
    {
        try {
            $product = Product::onlyTrashed()->findOrFail($id);
            $productName = $product->name;
            
            // Delete associated image if it exists
            if ($product->image) {
                $imagePath = str_replace('/storage/', '', $product->image);
                Storage::disk('public')->delete($imagePath);
            }
            
            $product->forceDelete(); // Permanently delete

            return redirect()->route('admin.admin.products.index', ['show_deleted' => true])
                ->with('success', "Product '{$productName}' has been permanently deleted.");
        } catch (\Exception $e) {
            \Log::error('Product permanent deletion error: ' . $e->getMessage());
            
            return redirect()->route('admin.admin.products.index', ['show_deleted' => true])
                ->with('error', 'Failed to permanently delete product. Please try again.');
        }
    }

    /**
     * Bulk delete multiple products (soft delete)
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
                return redirect()->route('admin.admin.products.index')
                    ->with('error', 'No products found to delete.');
            }

            $deletedCount = 0;
            
            foreach ($products as $product) {
                $product->delete(); // Soft delete
                $deletedCount++;
            }

            return redirect()->route('admin.admin.products.index')
                ->with('success', "Successfully moved {$deletedCount} product(s) to trash.");
                
        } catch (\Exception $e) {
            \Log::error('Bulk soft delete error: ' . $e->getMessage());
            
            return redirect()->route('admin.admin.products.index')
                ->with('error', 'An error occurred while deleting products. Please try again.');
        }
    }

    /**
     * Bulk restore multiple soft deleted products
     */
    public function bulkRestore(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer',
        ]);

        try {
            $productIds = $validated['product_ids'];
            $products = Product::onlyTrashed()->whereIn('id', $productIds)->get();
            
            if ($products->isEmpty()) {
                return redirect()->route('admin.admin.products.index', ['show_deleted' => true])
                    ->with('error', 'No deleted products found to restore.');
            }

            $restoredCount = 0;
            
            foreach ($products as $product) {
                $product->restore();
                $restoredCount++;
            }

            return redirect()->route('admin.admin.products.index')
                ->with('success', "Successfully restored {$restoredCount} product(s).");
                
        } catch (\Exception $e) {
            \Log::error('Bulk restore error: ' . $e->getMessage());
            
            return redirect()->route('admin.admin.products.index', ['show_deleted' => true])
                ->with('error', 'An error occurred while restoring products. Please try again.');
        }
    }

    /**
     * Bulk permanently delete multiple products
     */
    public function bulkForceDelete(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer',
        ]);

        try {
            $productIds = $validated['product_ids'];
            $products = Product::onlyTrashed()->whereIn('id', $productIds)->get();
            
            if ($products->isEmpty()) {
                return redirect()->route('admin.admin.products.index', ['show_deleted' => true])
                    ->with('error', 'No deleted products found to permanently delete.');
            }

            $deletedCount = 0;
            
            foreach ($products as $product) {
                // Delete associated image if it exists
                if ($product->image) {
                    $imagePath = str_replace('/storage/', '', $product->image);
                    Storage::disk('public')->delete($imagePath);
                }
                
                $product->forceDelete(); // Permanently delete
                $deletedCount++;
            }

            return redirect()->route('admin.admin.products.index', ['show_deleted' => true])
                ->with('success', "Successfully permanently deleted {$deletedCount} product(s).");
                
        } catch (\Exception $e) {
            \Log::error('Bulk permanent delete error: ' . $e->getMessage());
            
            return redirect()->route('admin.admin.products.index', ['show_deleted' => true])
                ->with('error', 'An error occurred while permanently deleting products. Please try again.');
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
                return redirect()->route('admin.admin.products.index')
                    ->with('error', 'No products found to update.');
            }

            $updatedCount = 0;
            
            foreach ($products as $product) {
                $product->update(['is_active' => !$product->is_active]);
                $updatedCount++;
            }

            return redirect()->route('admin.admin.products.index')
                ->with('success', "Successfully updated {$updatedCount} product(s) status.");
                
        } catch (\Exception $e) {
            \Log::error('Bulk toggle status error: ' . $e->getMessage());
            
            return redirect()->route('admin.admin.products.index')
                ->with('error', 'An error occurred while updating product status. Please try again.');
        }
    }

    /**
     * Optimize image for database storage
     */
    private function optimizeImage($file)
    {
        $path = $file->getRealPath();
        $mimeType = $file->getMimeType();
        
        // Load image based on type
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($path);
                break;
            case 'image/png':
                $image = imagecreatefrompng($path);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($path);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($path);
                break;
            default:
                // If not supported, return original
                return file_get_contents($path);
        }

        if (!$image) {
            return file_get_contents($path);
        }

        // Get original dimensions
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        // Calculate new dimensions (max 800px width)
        $maxWidth = 800;
        $ratio = $originalWidth / $originalHeight;
        
        if ($originalWidth > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = $maxWidth / $ratio;
        } else {
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;
        }

        // Create resized image
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG
        if ($mimeType === 'image/png') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Resize image
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        // Convert to JPEG for smaller size
        ob_start();
        imagejpeg($resizedImage, null, 85); // 85% quality
        $optimizedData = ob_get_contents();
        ob_end_clean();

        // Clean up
        imagedestroy($image);
        imagedestroy($resizedImage);

        return $optimizedData;
    }
}
