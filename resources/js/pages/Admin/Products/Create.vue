<template>
  <AdminLayout title="Add New Product">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-3xl font-bold text-foreground">Add New Product</h1>
              <p class="text-muted-foreground mt-2">Create a new product for your catalog</p>
            </div>
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
                  <!-- Image Upload -->
                  <div>
                    <label class="block text-sm font-medium text-card-foreground mb-2">Product Image</label>
                    <input 
                      @change="handleImageUpload"
                      type="file"
                      accept="image/*"
                      class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    />
                    <p class="text-xs text-muted-foreground mt-1">Supported formats: JPG, PNG, WebP. Max size: 2MB</p>
                    <span v-if="errors.image" class="text-sm text-red-600">{{ errors.image }}</span>
                  </div>

                  <!-- Image Preview -->
                  <div v-if="imagePreview" class="mt-4">
                    <label class="block text-sm font-medium text-card-foreground mb-2">Preview</label>
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

              <!-- Quick Actions -->
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h2 class="text-xl font-semibold text-card-foreground mb-6">Actions</h2>
                
                <div class="space-y-3">
                  <!-- Save as Draft -->
                  <Button 
                    type="button"
                    variant="outline" 
                    class="w-full"
                    @click="saveAsDraft"
                    :disabled="isSubmitting"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Save as Draft
                  </Button>

                  <!-- Save & Continue -->
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
                    {{ isSubmitting ? 'Creating...' : 'Create Product' }}
                  </Button>
                </div>
              </div>

              <!-- Help -->
              <div class="bg-background border-2 border-border rounded-[5px] p-4">
                <h3 class="font-medium text-foreground mb-2">Need Help?</h3>
                <p class="text-xs text-muted-foreground mb-3">
                  Tips for creating great product listings:
                </p>
                <ul class="text-xs text-muted-foreground space-y-1">
                  <li>• Use clear, descriptive product names</li>
                  <li>• Add detailed descriptions</li>
                  <li>• Include high-quality images</li>
                  <li>• Set accurate stock levels</li>
                  <li>• Choose appropriate categories</li>
                </ul>
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

interface PageProps {
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
  name: '',
  description: '',
  sku: '',
  category: '',
  price: '',
  stock: '',
  weight: '',
  dimensions: '',
  image: null as File | null,
  is_active: true
})

// Methods
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
        } else {
          formData.append(key, value.toString())
        }
      }
    })
    
    await router.post('/admin/products', formData, {
      forceFormData: true,
      onSuccess: () => {
        // Will redirect to products list
      },
      onError: (errors) => {
        console.error('Form errors:', errors)
      }
    })
  } catch (error) {
    console.error('Error creating product:', error)
  } finally {
    isSubmitting.value = false
  }
}

const saveAsDraft = async () => {
  form.value.is_active = false
  await submitForm()
}
</script>
