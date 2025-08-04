<template>
  <AdminLayout :title="showDeleted ? 'Deleted Products' : 'Manage Products'">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-3xl font-bold text-foreground">Manage Products</h1>
              <p class="text-muted-foreground mt-2">Add, edit, and manage your product catalog</p>
            </div>
            <Link href="/admin/products/create">
              <Button size="lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Product
              </Button>
            </Link>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <!-- Filters -->
        <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 mb-6">
          <form @submit.prevent="search" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Search</label>
              <input 
                v-model="filters.search"
                type="text" 
                placeholder="Search products..."
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Category</label>
              <select 
                v-model="filters.category"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              >
                <option value="">All Categories</option>
                <option v-for="category in categories" :key="category" :value="category">
                  {{ category }}
                </option>
              </select>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Status</label>
              <select 
                v-model="filters.status"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              >
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>

            <!-- Show Deleted Toggle -->
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">View</label>
              <label class="flex items-center space-x-2 cursor-pointer px-3 py-2 border-2 border-border rounded-[5px] bg-background">
                <input
                  v-model="showDeleted"
                  @change="toggleDeletedView"
                  type="checkbox"
                  class="rounded border-border text-primary focus:ring-primary"
                />
                <span class="text-sm text-foreground">Show Deleted</span>
              </label>
            </div>
            
            <div class="flex items-end gap-2">
              <Button type="submit" class="flex-1">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Search
              </Button>
              <Button 
                type="button" 
                variant="outline" 
                class="flex-1"
                @click="clearFilters"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Clear
              </Button>
            </div>
          </form>
        </div>

        <!-- Bulk Actions -->
        <div v-if="selectedProducts.length > 0" class="bg-primary/10 border-2 border-primary rounded-[5px] p-4 mb-6">
          <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-primary">
              {{ selectedProducts.length }} product(s) selected
            </span>
            <div class="flex items-center gap-2">
              <!-- Actions for non-deleted products -->
              <template v-if="!showDeleted">
                <Button 
                  variant="outline" 
                  size="sm"
                  @click="bulkToggleStatus"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                  </svg>
                  Toggle Status
                </Button>
                <Button 
                  variant="destructive" 
                  size="sm"
                  @click="confirmBulkDelete"
                  :disabled="isDeleting"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  {{ isDeleting ? 'Moving to Trash...' : `Move to Trash (${selectedProducts.length})` }}
                </Button>
              </template>
              
              <!-- Actions for deleted products -->
              <template v-else>
                <Button 
                  variant="outline" 
                  size="sm"
                  @click="bulkRestoreProducts"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                  </svg>
                  Restore ({{ selectedProducts.length }})
                </Button>
                <Button 
                  variant="destructive" 
                  size="sm"
                  @click="confirmBulkDelete"
                  :disabled="isDeleting"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  {{ isDeleting ? 'Permanently Deleting...' : `Permanently Delete (${selectedProducts.length})` }}
                </Button>
              </template>
            </div>
          </div>
        </div>

        <!-- Products Table -->
        <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-background border-b-2 border-border">
                <tr>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">
                    <input 
                      type="checkbox"
                      :checked="isAllSelected"
                      @change="toggleSelectAll"
                      class="rounded border-border text-primary focus:ring-primary"
                    />
                  </th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Product</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">SKU</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Category</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Price</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Stock</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Status</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-border">
                <tr v-if="products.data.length === 0">
                  <td colspan="8" class="px-6 py-8 text-center text-muted-foreground">
                    No products found
                  </td>
                </tr>
                <tr 
                  v-else 
                  v-for="product in products.data" 
                  :key="product.id" 
                  :class="[
                    'hover:bg-background/50',
                    showDeleted ? 'bg-red-50 text-gray-500' : ''
                  ]"
                >
                  <!-- Checkbox -->
                  <td class="px-6 py-4">
                    <input 
                      type="checkbox"
                      :value="product.id"
                      v-model="selectedProducts"
                      class="rounded border-border text-primary focus:ring-primary"
                    />
                  </td>
                  
                  <!-- Product Info -->
                  <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                      <img 
                        :src="product.image || '/api/placeholder/60/60'"
                        :alt="product.name"
                        class="w-12 h-12 object-cover rounded-[5px] border border-border"
                      />
                      <div>
                        <div class="font-medium text-card-foreground line-clamp-1 flex items-center gap-2">
                          {{ product.name }}
                          <span v-if="showDeleted" class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                            DELETED
                          </span>
                        </div>
                        <div class="text-sm text-muted-foreground line-clamp-1">{{ product.description }}</div>
                      </div>
                    </div>
                  </td>
                  
                  <!-- SKU -->
                  <td class="px-6 py-4">
                    <span class="text-sm text-card-foreground">{{ product.sku || 'N/A' }}</span>
                  </td>
                  
                  <!-- Category -->
                  <td class="px-6 py-4">
                    <span class="text-sm text-card-foreground">{{ product.category || 'Uncategorized' }}</span>
                  </td>
                  
                  <!-- Price -->
                  <td class="px-6 py-4">
                    <span class="font-medium text-card-foreground">Rp {{ formatCurrency(product.price) }}</span>
                  </td>
                  
                  <!-- Stock -->
                  <td class="px-6 py-4">
                    <span :class="getStockClass(product.stock)" class="px-2 py-1 text-xs font-medium rounded-[3px] border">
                      {{ product.stock }}
                    </span>
                  </td>
                  
                  <!-- Status -->
                  <td class="px-6 py-4">
                    <span :class="product.is_active ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300'" class="px-2 py-1 text-xs font-medium rounded-[3px] border">
                      {{ product.is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  
                  <!-- Actions -->
                  <td class="px-6 py-4">
                    <div class="flex items-center space-x-2">
                      <!-- Actions for non-deleted products -->
                      <template v-if="!showDeleted">
                        <Link :href="`/products/${product.id}`" target="_blank">
                          <Button variant="outline" size="sm">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                          </Button>
                        </Link>
                        
                        <Link :href="`/admin/products/${product.id}/edit`">
                          <Button variant="outline" size="sm">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                          </Button>
                        </Link>
                        
                        <Button 
                          variant="destructive" 
                          size="sm"
                          @click="deleteProduct(product.id, product.name)"
                        >
                          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </Button>
                      </template>
                      
                      <!-- Actions for deleted products -->
                      <template v-else>
                        <Button 
                          variant="outline" 
                          size="sm"
                          @click="restoreProduct(product.id, product.name)"
                        >
                          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                          </svg>
                          Restore
                        </Button>
                        
                        <Button 
                          variant="destructive" 
                          size="sm"
                          @click="permanentDeleteProduct(product.id, product.name)"
                        >
                          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                          Permanent Delete
                        </Button>
                      </template>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="products.last_page > 1" class="mt-6 flex justify-center">
          <div class="flex items-center space-x-2">
            <Link 
              v-if="products.prev_page_url" 
              :href="products.prev_page_url"
              preserve-scroll
            >
              <Button variant="outline" size="sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Previous
              </Button>
            </Link>
            
            <span class="px-4 py-2 text-sm text-muted-foreground">
              Page {{ products.current_page }} of {{ products.last_page }}
            </span>
            
            <Link 
              v-if="products.next_page_url" 
              :href="products.next_page_url"
              preserve-scroll
            >
              <Button variant="outline" size="sm">
                Next
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </Button>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/layouts/AdminLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Link } from '@inertiajs/vue3'
import { useNotifications } from '@/composables/useNotifications'

// Define interfaces
interface Product {
  id: number
  name: string
  description: string | null
  price: number
  stock: number
  image: string | null
  sku: string | null
  category: string | null
  is_active: boolean
}

interface PaginatedProducts {
  data: Product[]
  current_page: number
  last_page: number
  prev_page_url: string | null
  next_page_url: string | null
}

interface PageProps {
  products: PaginatedProducts
  categories: string[]
  filters: {
    search: string
    category: string
    status: string
    show_deleted?: boolean
  }
  auth: {
    user: any
  }
}

// Define props
const props = defineProps<PageProps>()

// Reactive data
const filters = ref({
  search: props.filters.search || '',
  category: props.filters.category || '',
  status: props.filters.status || ''
})

// Multiple selection state
const selectedProducts = ref<number[]>([])
const isDeleting = ref(false)
const showDeleted = ref(props.filters.show_deleted || false)
const { success, error } = useNotifications()

// Computed properties
const isAllSelected = computed(() => {
  return props.products.data.length > 0 && selectedProducts.value.length === props.products.data.length
})

// Methods
const formatCurrency = (amount: number): string => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

const getStockClass = (stock: number): string => {
  if (stock <= 5) return 'bg-red-100 text-red-800 border-red-300'
  if (stock <= 10) return 'bg-yellow-100 text-yellow-800 border-yellow-300'
  return 'bg-green-100 text-green-800 border-green-300'
}

const search = () => {
  selectedProducts.value = []
  router.get('/admin/products', filters.value, {
    preserveState: true,
    preserveScroll: false,
    replace: true
  })
}

const clearFilters = () => {
  filters.value = {
    search: '',
    category: '',
    status: ''
  }
  selectedProducts.value = []
  showDeleted.value = false
  
  // Redirect to admin products without any filters
  router.get('/admin/products', {}, {
    preserveState: true,
    preserveScroll: false,
    replace: true
  })
}

const toggleDeletedView = () => {
  selectedProducts.value = []
  const params = showDeleted.value 
    ? { ...filters.value, show_deleted: true }
    : filters.value
    
  router.get('/admin/products', params, {
    preserveState: true,
    preserveScroll: false,
    replace: true
  })
}

const toggleSelectAll = () => {
  if (isAllSelected.value) {
    selectedProducts.value = []
  } else {
    selectedProducts.value = props.products.data.map(product => product.id)
  }
}

const confirmBulkDelete = () => {
  if (selectedProducts.value.length === 0) return
  
  if (showDeleted.value) {
    // If viewing deleted products, show permanent delete confirmation
    const confirmMessage = `Are you sure you want to permanently delete ${selectedProducts.value.length} product(s)? This action cannot be undone!`
    
    if (confirm(confirmMessage)) {
      bulkPermanentDeleteProducts()
    }
  } else {
    // Normal soft delete
    const confirmMessage = `Are you sure you want to delete ${selectedProducts.value.length} product(s)? They will be moved to trash.`
    
    if (confirm(confirmMessage)) {
      bulkDeleteProducts()
    }
  }
}

const bulkRestoreProducts = async () => {
  if (selectedProducts.value.length === 0) return
  
  const selectedCount = selectedProducts.value.length
  
  try {
    await router.post('/admin/products/bulk-restore', {
      product_ids: selectedProducts.value
    }, {
      onSuccess: () => {
        selectedProducts.value = []
        success(`Successfully restored ${selectedCount} product(s)`, 'Bulk Restore')
      },
      onError: (errors) => {
        console.error('Error restoring products:', errors)
        error('Failed to restore some products. Please try again.', 'Bulk Restore Error')
      }
    })
  } catch (err) {
    console.error('Error restoring products:', err)
    error('An unexpected error occurred. Please try again.', 'Bulk Restore Error')
  }
}

const bulkPermanentDeleteProducts = async () => {
  if (selectedProducts.value.length === 0) return
  
  isDeleting.value = true
  const selectedCount = selectedProducts.value.length
  
  try {
    await router.post('/admin/products/bulk-force-delete', {
      product_ids: selectedProducts.value
    }, {
      onSuccess: () => {
        selectedProducts.value = []
        success(`Successfully permanently deleted ${selectedCount} product(s)`, 'Bulk Permanent Delete')
      },
      onError: (errors) => {
        console.error('Error permanently deleting products:', errors)
        error('Failed to permanently delete some products. Please try again.', 'Bulk Permanent Delete Error')
      }
    })
  } catch (err) {
    console.error('Error permanently deleting products:', err)
    error('An unexpected error occurred. Please try again.', 'Bulk Permanent Delete Error')
  } finally {
    isDeleting.value = false
  }
}

const bulkDeleteProducts = async () => {
  if (selectedProducts.value.length === 0) return
  
  isDeleting.value = true
  
  try {
    await router.post('/admin/products/bulk-delete', {
      product_ids: selectedProducts.value
    }, {
      onSuccess: () => {
        selectedProducts.value = []
        success(`Successfully deleted ${selectedProducts.value.length} product(s)`, 'Bulk Delete')
      },
      onError: (errors) => {
        console.error('Error deleting products:', errors)
        error('Failed to delete some products. Please try again.', 'Bulk Delete Error')
      }
    })
  } catch (err) {
    console.error('Error deleting products:', err)
    error('An unexpected error occurred. Please try again.', 'Bulk Delete Error')
  } finally {
    isDeleting.value = false
  }
}

const bulkToggleStatus = async () => {
  if (selectedProducts.value.length === 0) return
  
  const selectedCount = selectedProducts.value.length
  
  try {
    await router.post('/admin/products/bulk-toggle-status', {
      product_ids: selectedProducts.value
    }, {
      onSuccess: () => {
        selectedProducts.value = []
        success(`Successfully updated status for ${selectedCount} product(s)`, 'Bulk Status Update')
      },
      onError: (errors) => {
        console.error('Error toggling product status:', errors)
        error('Failed to update product status. Please try again.', 'Bulk Status Error')
      }
    })
  } catch (err) {
    console.error('Error toggling product status:', err)
    error('An unexpected error occurred. Please try again.', 'Bulk Status Error')
  }
}

const deleteProduct = async (productId: number, productName: string) => {
  if (!confirm(`Are you sure you want to delete "${productName}"? This action will move the product to trash.`)) {
    return
  }
  
  try {
    await router.delete(`/admin/products/${productId}`, {
      onSuccess: () => {
        success(`Product "${productName}" has been moved to trash successfully`, 'Product Deleted')
      },
      onError: (errors) => {
        console.error('Error deleting product:', errors)
        error(`Failed to delete product "${productName}". Please try again.`, 'Delete Error')
      }
    })
  } catch (err) {
    console.error('Error deleting product:', err)
    error('An unexpected error occurred. Please try again.', 'Delete Error')
  }
}

const restoreProduct = async (productId: number, productName: string) => {
  try {
    await router.post(`/admin/products/${productId}/restore`, {}, {
      onSuccess: () => {
        success(`Product "${productName}" has been restored successfully`, 'Product Restored')
      },
      onError: (errors) => {
        console.error('Error restoring product:', errors)
        error(`Failed to restore product "${productName}". Please try again.`, 'Restore Error')
      }
    })
  } catch (err) {
    console.error('Error restoring product:', err)
    error('An unexpected error occurred. Please try again.', 'Restore Error')
  }
}

const permanentDeleteProduct = async (productId: number, productName: string) => {
  if (!confirm(`Are you sure you want to permanently delete "${productName}"? This action cannot be undone!`)) {
    return
  }
  
  try {
    await router.delete(`/admin/products/${productId}/force-delete`, {
      onSuccess: () => {
        success(`Product "${productName}" has been permanently deleted`, 'Product Permanently Deleted')
      },
      onError: (errors) => {
        console.error('Error permanently deleting product:', errors)
        error(`Failed to permanently delete product "${productName}". Please try again.`, 'Permanent Delete Error')
      }
    })
  } catch (err) {
    console.error('Error permanently deleting product:', err)
    error('An unexpected error occurred. Please try again.', 'Permanent Delete Error')
  }
}
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
