<template>
  <AdminLayout title="Edit Product">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-3xl font-bold text-foreground">Edit Product</h1>
              <p class="text-muted-foreground mt-2">Update product information</p>
            </div>
            <div class="flex items-center space-x-2">
              <Link :href="`/products/${product.id}`" target="_blank">
                <Button variant="outline">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  Preview
                </Button>
              </Link>
              <Link href="/admin/products">
                <Button variant="outline">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                  </svg>
                  Back to Products
                </Button>
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <form @submit.prevent="submitForm" class="max-w-4xl mx-auto">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Product Info -->
            <div class="lg:col-span-2 space-y-6">
              <!-- Basic Information -->
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h2 class="text-xl font-semibold text-card-foreground mb-6">Basic Information</h2>
                
                <div class="space-y-4">
                  <!-- Product Name -->
                  <div>
                    <label class="block text-sm font-medium text-card-foreground mb-2">Product Name *</label>
                    <input 
                      v-model="form.name"
                      type="text" 
                      required
                      class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                      placeholder="Enter product name"
                    />
                    <span v-if="errors.name" class="text-sm text-red-600">{{ errors.name }}</span>
                  </div>

                  <!-- Description -->
                  <div>
                    <label class="block text-sm font-medium text-card-foreground mb-2">Description</label>
                    <textarea 
                      v-model="form.description"
                      rows="4"
                      class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                      placeholder="Enter product description"
                    ></textarea>
                    <span v-if="errors.description" class="text-sm text-red-600">{{ errors.description }}</span>
                  </div>

                  <!-- SKU -->
                  <div>
                    <label class="block text-sm font-medium text-card-foreground mb-2">SKU</label>
                    <input 
                      v-model="form.sku"
                      type="text"
                      class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                      placeholder="Enter SKU (optional)"
                    />
                    <span v-if="errors.sku" class="text-sm text-red-600">{{ errors.sku }}</span>
                  </div>

                  <!-- Category -->
                  <div>
                    <label class="block text-sm font-medium text-card-foreground mb-2">Category</label>
                    <select 
                      v-model="form.category"
                      class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    >
                      <option value="">Select Category</option>
                      <option value="electronics">Electronics</option>
                      <option value="clothing">Clothing</option>
                      <option value="books">Books</option>
                      <option value="home">Home & Garden</option>
                      <option value="sports">Sports</option>
                      <option value="toys">Toys</option>
                    </select>
                    <span v-if="errors.category" class="text-sm text-red-600">{{ errors.category }}</span>
                  </div>
                </div>
              </div>

              <!-- Pricing & Inventory -->
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h2 class="text-xl font-semibold text-card-foreground mb-6">Pricing & Inventory</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <!-- Price -->
                  <div>
                    <label class="block text-sm font-medium text-card-foreground mb-2">Price (Rp) *</label>
                    <input 
                      v-model="form.price"
                      type="number"
                      min="0"
                      step="100"
                      required
                      class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                      placeholder="0"
                    />
                    <span v-if="errors.price" class="text-sm text-red-600">{{ errors.price }}</span>
                  </div>

                  <!-- Stock -->
                  <div>
                    <label class="block text-sm font-medium text-card-foreground mb-2">Stock Quantity *</label>
                    <input 
                      v-model="form.stock"
                      type="number"
                      min="0"
                      required
                      class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                      placeholder="0"
                    />
                    <span v-if="errors.stock" class="text-sm text-red-600">{{ errors.stock }}</span>
                  </div>

                  <!-- Weight -->
                  <div>
                    <label class="block text-sm font-medium text-card-foreground mb-2">Weight (grams)</label>
                    <input 
                      v-model="form.weight"
                      type="number"
                      min="0"
                      class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                      placeholder="0"
                    />
                    <span v-if="errors.weight" class="text-sm text-red-600">{{ errors.weight }}</span>
                  </div>

                  <!-- Dimensions -->
                  <div>
                    <label class="block text-sm font-medium text-card-foreground mb-2">Dimensions</label>
                    <input 
                      v-model="form.dimensions"
                      type="text"
                      class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                      placeholder="L x W x H (cm)"
                    />
                    <span v-if="errors.dimensions" class="text-sm text-red-600">{{ errors.dimensions }}</span>
                  </div>
                </div>
              </div>

              <!-- Product Image -->
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h2 class="text-xl font-semibold text-card-foreground mb-6">Product Image</h2>
                
                <div class="space-y-4">
                  <!-- Current Image -->
                  <div v-if="product.image && !imagePreview">
                    <label class="block text-sm font-medium text-card-foreground mb-2">Current Image</label>
                    <div class="w-32 h-32 border-2 border-border rounded-[5px] overflow-hidden">
                      <img :src="product.image" :alt="product.name" class="w-full h-full object-cover" />
                    </div>
                  </div>

                  <!-- Image Upload -->
                  <div>
                    <label class="block text-sm font-medium text-card-foreground mb-2">
                      {{ product.image ? 'Replace Image' : 'Product Image' }}
                    </label>
                    <input 
                      @change="handleImageUpload"
                      type="file"
                      accept="image/*"
                      class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    />
                    <p class="text-xs text-muted-foreground mt-1">Supported formats: JPG, PNG, WebP. Max size: 2MB</p>
                    <span v-if="errors.image" class="text-sm text-red-600">{{ errors.image }}</span>
                  </div>

                  <!-- New Image Preview -->
                  <div v-if="imagePreview" class="mt-4">
                    <label class="block text-sm font-medium text-card-foreground mb-2">New Preview</label>
                    <div class="w-32 h-32 border-2 border-border rounded-[5px] overflow-hidden">
                      <img :src="imagePreview" alt="Preview" class="w-full h-full object-cover" />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
              <!-- Product Status -->
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h2 class="text-xl font-semibold text-card-foreground mb-6">Product Status</h2>
                
                <div class="space-y-4">
                  <!-- Active Status -->
                  <div class="flex items-center space-x-3">
                    <input 
                      v-model="form.is_active"
                      type="checkbox"
                      id="is_active"
                      class="w-4 h-4 text-foreground bg-background border-2 border-border rounded focus:ring-ring"
                    />
                    <label for="is_active" class="text-sm font-medium text-card-foreground">
                      Active (Visible to customers)
                    </label>
                  </div>
                  
                  <p class="text-xs text-muted-foreground">
                    Inactive products won't be visible to customers but will remain in your catalog.
                  </p>
                </div>
              </div>

              <!-- Product Stats -->
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h2 class="text-xl font-semibold text-card-foreground mb-6">Product Stats</h2>
                
                <div class="space-y-3 text-sm">
                  <div class="flex justify-between">
                    <span class="text-muted-foreground">Created:</span>
                    <span class="text-card-foreground">{{ formatDate(product.created_at) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-muted-foreground">Updated:</span>
                    <span class="text-card-foreground">{{ formatDate(product.updated_at) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-muted-foreground">Product ID:</span>
                    <span class="text-card-foreground">#{{ product.id }}</span>
                  </div>
                </div>
              </div>

              <!-- Quick Actions -->
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h2 class="text-xl font-semibold text-card-foreground mb-6">Actions</h2>
                
                <div class="space-y-3">
                  <!-- Update Product -->
                  <Button 
                    type="submit" 
                    class="w-full"
                    :disabled="isSubmitting"
                  >
                    <svg v-if="isSubmitting" class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 16c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z" />
                    </svg>
                    <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ isSubmitting ? 'Updating...' : 'Update Product' }}
                  </Button>

                  <!-- Delete Product -->
                  <Button 
                    type="button"
                    variant="destructive" 
                    class="w-full"
                    @click="deleteProduct"
                    :disabled="isSubmitting"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Product
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/layouts/AdminLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Link } from '@inertiajs/vue3'

interface Product {
  id: number
  name: string
  description: string | null
  sku: string | null
  category: string | null
  price: number
  stock: number
  weight: number | null
  dimensions: string | null
  image: string | null
  is_active: boolean
  created_at: string
  updated_at: string
}

interface PageProps {
  product: Product
  auth: {
    user: any
  }
  errors: Record<string, any>
}

// Define props
const props = defineProps<PageProps>()

// Reactive data
const isSubmitting = ref(false)
const imagePreview = ref<string | null>(null)

const form = ref({
  name: props.product.name,
  description: props.product.description || '',
  sku: props.product.sku || '',
  category: props.product.category || '',
  price: props.product.price.toString(),
  stock: props.product.stock.toString(),
  weight: props.product.weight?.toString() || '',
  dimensions: props.product.dimensions || '',
  image: null as File | null,
  is_active: props.product.is_active
})

// Methods
const formatDate = (dateString: string): string => {
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const handleImageUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  
  if (file) {
    form.value.image = file
    
    // Create preview
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target?.result as string
    }
    reader.readAsDataURL(file)
  }
}

const submitForm = async () => {
  isSubmitting.value = true
  
  try {
    const formData = new FormData()
    
    // Append all form fields
    Object.keys(form.value).forEach(key => {
      const value = form.value[key as keyof typeof form.value]
      if (value !== null && value !== '') {
        if (key === 'is_active') {
          formData.append(key, value ? '1' : '0')
        } else if (key === 'image' && value instanceof File) {
          formData.append(key, value)
        } else if (key !== 'image') {
          formData.append(key, value.toString())
        }
      }
    })
    
    // Add method override for PUT request
    formData.append('_method', 'PUT')
    
    await router.post(`/admin/products/${props.product.id}`, formData, {
      forceFormData: true,
      onSuccess: () => {
        // Will redirect to products list or show success message
      },
      onError: (errors) => {
        console.error('Form errors:', errors)
      }
    })
  } catch (error) {
    console.error('Error updating product:', error)
  } finally {
    isSubmitting.value = false
  }
}

const deleteProduct = async () => {
  if (!confirm(`Are you sure you want to delete "${props.product.name}"? This action cannot be undone.`)) {
    return
  }
  
  try {
    await router.delete(`/admin/products/${props.product.id}`, {
      onSuccess: () => {
        // Will redirect to products list
      },
      onError: (errors) => {
        console.error('Delete errors:', errors)
      }
    })
  } catch (error) {
    console.error('Error deleting product:', error)
  }
}
</script>
