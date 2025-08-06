<template>
  <div 
    v-if="isOpen" 
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
    @click.self="closeModal"
  >
    <div class="bg-card border-2 border-border rounded-[5px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] max-w-4xl w-full max-h-[90vh] overflow-y-auto">
      <!-- Header -->
      <div class="bg-background border-b-2 border-border p-6 sticky top-0">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold text-foreground">Product Details</h2>
            <p class="text-muted-foreground mt-1">View product information</p>
            <div v-if="product?.deleted_at" class="mt-2">
              <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                DELETED PRODUCT
              </span>
            </div>
          </div>
          <Button 
            variant="outline" 
            size="sm"
            @click="closeModal"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </Button>
        </div>
      </div>

      <!-- Content -->
      <div v-if="product" class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Main Product Info -->
          <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-background border-2 border-border rounded-[5px] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] p-6">
              <h3 class="text-xl font-semibold text-foreground mb-6">Basic Information</h3>
              
              <div class="space-y-4">
                <!-- Product Name -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">Product Name</label>
                  <div class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-muted text-foreground">
                    {{ product.name }}
                  </div>
                </div>

                <!-- Description -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">Description</label>
                  <div class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-muted text-foreground min-h-[100px]">
                    {{ product.description || 'No description provided' }}
                  </div>
                </div>

                <!-- SKU -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">SKU</label>
                  <div class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-muted text-foreground">
                    {{ product.sku || 'N/A' }}
                  </div>
                </div>

                <!-- Category -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">Category</label>
                  <div class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-muted text-foreground">
                    {{ product.category || 'Uncategorized' }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Pricing & Inventory -->
            <div class="bg-background border-2 border-border rounded-[5px] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] p-6">
              <h3 class="text-xl font-semibold text-foreground mb-6">Pricing & Inventory</h3>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Price -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">Price</label>
                  <div class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-muted text-foreground font-semibold">
                    Rp {{ formatCurrency(product.price) }}
                  </div>
                </div>

                <!-- Stock -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-2">Stock Quantity</label>
                  <div class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-muted text-foreground">
                    <span :class="getStockClass(product.stock)" class="px-2 py-1 text-xs font-medium rounded-[3px] border">
                      {{ product.stock }}
                    </span>
                  </div>
                </div>

                <!-- Weight -->
                <div v-if="product.weight">
                  <label class="block text-sm font-medium text-foreground mb-2">Weight</label>
                  <div class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-muted text-foreground">
                    {{ product.weight }} grams
                  </div>
                </div>

                <!-- Dimensions -->
                <div v-if="product.dimensions">
                  <label class="block text-sm font-medium text-foreground mb-2">Dimensions</label>
                  <div class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-muted text-foreground">
                    {{ product.dimensions }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Product Image -->
            <div class="bg-background border-2 border-border rounded-[5px] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] p-6">
              <h3 class="text-xl font-semibold text-foreground mb-6">Product Image</h3>
              
              <div class="flex justify-center">
                <div class="w-64 h-64 border-2 border-border rounded-[5px] overflow-hidden bg-muted">
                  <img 
                    v-if="product.image" 
                    :src="product.image" 
                    :alt="product.name" 
                    class="w-full h-full object-cover"
                  />
                  <div 
                    v-else 
                    class="w-full h-full flex items-center justify-center text-muted-foreground"
                  >
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="lg:col-span-1 space-y-6">
            <!-- Product Status -->
            <div class="bg-background border-2 border-border rounded-[5px] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] p-6">
              <h3 class="text-xl font-semibold text-foreground mb-6">Product Status</h3>
              
              <div class="space-y-4">
                <!-- Active Status -->
                <div class="flex items-center space-x-3">
                  <div class="w-4 h-4 rounded border-2 border-border flex items-center justify-center"
                       :class="product.is_active ? 'bg-green-500' : 'bg-gray-300'">
                    <svg v-if="product.is_active" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                  <span class="text-sm font-medium text-foreground">
                    {{ product.is_active ? 'Active (Visible to customers)' : 'Inactive (Hidden from customers)' }}
                  </span>
                </div>
                
                <p class="text-xs text-muted-foreground">
                  {{ product.is_active 
                    ? 'This product is currently visible to customers in your store.' 
                    : 'This product is hidden from customers but remains in your catalog.'
                  }}
                </p>
              </div>
            </div>

            <!-- Product Stats -->
            <div class="bg-background border-2 border-border rounded-[5px] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] p-6">
              <h3 class="text-xl font-semibold text-foreground mb-6">Product Stats</h3>
              
              <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                  <span class="text-muted-foreground">Product ID:</span>
                  <span class="text-foreground font-medium">#{{ product.id }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-muted-foreground">Created:</span>
                  <span class="text-foreground">{{ formatDate(product.created_at) }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-muted-foreground">Updated:</span>
                  <span class="text-foreground">{{ formatDate(product.updated_at) }}</span>
                </div>
              </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-background border-2 border-border rounded-[5px] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] p-6">
              <h3 class="text-xl font-semibold text-foreground mb-6">Quick Actions</h3>
              
              <div class="space-y-3">
                
                <!-- Edit Product -->
                <Link 
                  v-if="!product.deleted_at" 
                  :href="`/admin/products/${product.id}/edit`" 
                  class="block"
                >
                  <Button class="w-full">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Product
                  </Button>
                </Link>
                
                <!-- Disabled Edit Product for deleted products -->
                <Button 
                  v-if="product.deleted_at" 
                  class="w-full" 
                  disabled
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Product (Unavailable)
                </Button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Button from '@/components/ui/button/Button.vue'
import { onMounted, onUnmounted, watch } from 'vue'

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
  weight?: number
  dimensions?: string
  created_at: string
  updated_at: string
  deleted_at?: string | null
}

interface Props {
  isOpen: boolean
  product: Product | null
}

const props = defineProps<Props>()

const emit = defineEmits<{
  close: []
}>()

const closeModal = () => {
  emit('close')
}

// Handle escape key
const handleEscape = (event: KeyboardEvent) => {
  if (event.key === 'Escape' && props.isOpen) {
    closeModal()
  }
}

// Add/remove event listeners when modal opens/closes
watch(() => props.isOpen, (isOpen) => {
  if (isOpen) {
    document.addEventListener('keydown', handleEscape)
    document.body.style.overflow = 'hidden'
  } else {
    document.removeEventListener('keydown', handleEscape)
    document.body.style.overflow = ''
  }
})

// Cleanup on unmount
onUnmounted(() => {
  document.removeEventListener('keydown', handleEscape)
  document.body.style.overflow = ''
})

const formatCurrency = (amount: number): string => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

const getStockClass = (stock: number): string => {
  if (stock <= 5) return 'bg-red-100 text-red-800 border-red-300'
  if (stock <= 10) return 'bg-yellow-100 text-yellow-800 border-yellow-300'
  return 'bg-green-100 text-green-800 border-green-300'
}

const formatDate = (dateString: string): string => {
  try {
    return new Date(dateString).toLocaleDateString('id-ID', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    })
  } catch (error) {
    return 'Invalid date'
  }
}
</script>

<style scoped>
/* Custom scrollbar for modal */
.max-h-\[90vh\]::-webkit-scrollbar {
  width: 8px;
}

.max-h-\[90vh\]::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

.max-h-\[90vh\]::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 4px;
}

.max-h-\[90vh\]::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
