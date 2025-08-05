<template>
  <EcommerceLayout title="Product Detail">
    <div class="min-h-screen bg-background">
      <!-- Breadcrumb -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-4">
          <nav class="flex items-center space-x-2 text-sm">
            <Link href="/products" class="text-muted-foreground hover:text-foreground transition-colors">
              Products
            </Link>
            <span class="text-muted-foreground">/</span>
            <span class="text-foreground font-medium">{{ product.name }}</span>
          </nav>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Product Image -->
          <div class="space-y-4">
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
              <img 
                :src="product.image || '/api/placeholder/600/600'"
                :alt="product.name"
                class="w-full h-96 lg:h-[500px] object-cover"
              />
            </div>
            
            <!-- Thumbnail images if available -->
            <div v-if="product.gallery && product.gallery.length > 0" class="flex space-x-2 overflow-x-auto">
              <div 
                v-for="(image, index) in product.gallery" 
                :key="index"
                class="flex-shrink-0 w-20 h-20 bg-card border-2 border-border rounded-[5px] overflow-hidden cursor-pointer hover:border-foreground transition-colors"
              >
                <img :src="image" :alt="`${product.name} ${index + 1}`" class="w-full h-full object-cover" />
              </div>
            </div>
          </div>

          <!-- Product Details -->
          <div class="space-y-6">
            <div>
              <h1 class="text-3xl font-bold text-foreground mb-2">{{ product.name }}</h1>
              <div class="flex items-center space-x-4 mb-4">
                <span class="text-3xl font-bold text-foreground">
                  Rp {{ formatCurrency(product.price) }}
                </span>
                <span v-if="product.original_price && product.original_price > product.price" 
                      class="text-xl text-muted-foreground line-through">
                  Rp {{ formatCurrency(product.original_price) }}
                </span>
              </div>
              
              <!-- Stock Status -->
              <div class="flex items-center space-x-2 mb-4">
                <div class="flex items-center space-x-1">
                  <div :class="product.stock > 0 ? 'bg-green-500' : 'bg-red-500'" class="w-2 h-2 rounded-full"></div>
                  <span :class="product.stock > 0 ? 'text-green-600' : 'text-red-600'" class="text-sm font-medium">
                    {{ product.stock > 0 ? `In Stock (${product.stock})` : 'Out of Stock' }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Description -->
            <div v-if="product.description" class="space-y-2">
              <h2 class="text-lg font-semibold text-foreground">Description</h2>
              <div class="bg-card border-2 border-border rounded-[5px] p-4">
                <p class="text-card-foreground whitespace-pre-wrap">{{ product.description }}</p>
              </div>
            </div>

            <!-- Quantity Selector & Add to Cart -->
            <div class="space-y-4">
              <div class="flex items-center space-x-4">
                <label class="text-sm font-medium text-foreground">Quantity:</label>
                <div class="flex items-center space-x-2">
                  <Button 
                    variant="outline" 
                    size="sm" 
                    @click="decreaseQuantity"
                    :disabled="quantity <= 1"
                  >
                    -
                  </Button>
                  <span class="px-4 py-2 border-2 border-border rounded-[5px] bg-background text-center min-w-[60px]">
                    {{ quantity }}
                  </span>
                  <Button 
                    variant="outline" 
                    size="sm" 
                    @click="increaseQuantity"
                    :disabled="quantity >= product.stock"
                  >
                    +
                  </Button>
                </div>
              </div>

              <!-- Add to Cart Button -->
              <div class="flex space-x-3">
                <Button 
                  @click="addToCart"
                  :disabled="product.stock <= 0 || isAddingToCart"
                  class="flex-1"
                  size="lg"
                >
                  <svg v-if="isAddingToCart" class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 16c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z" />
                  </svg>
                  <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
                  </svg>
                  {{ isAddingToCart ? 'Adding...' : 'Add to Cart' }}
                </Button>
                
                <!-- Buy Now Button -->
                <Button 
                  variant="reverse" 
                  @click="buyNow"
                  :disabled="product.stock <= 0"
                  size="lg"
                  class="flex-1"
                >
                  Buy Now
                </Button>
              </div>
            </div>

            <!-- Product Meta -->
            <div class="bg-card border-2 border-border rounded-[5px] p-4 space-y-2">
              <h3 class="font-semibold text-card-foreground mb-3">Product Information</h3>
              <div class="grid grid-cols-2 gap-2 text-sm">
                <div class="text-muted-foreground">Category:</div>
                <div class="text-card-foreground">{{ product.category || 'Uncategorized' }}</div>
                
                <div class="text-muted-foreground">SKU:</div>
                <div class="text-card-foreground">{{ product.sku || 'N/A' }}</div>
                
                <div class="text-muted-foreground">Weight:</div>
                <div class="text-card-foreground">{{ product.weight ? `${product.weight}g` : 'N/A' }}</div>
                
                <div class="text-muted-foreground">Dimensions:</div>
                <div class="text-card-foreground">{{ product.dimensions || 'N/A' }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Related Products -->
        <div v-if="relatedProducts && relatedProducts.length > 0" class="mt-16">
          <h2 class="text-2xl font-bold text-foreground mb-6">Related Products</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div 
              v-for="relatedProduct in relatedProducts" 
              :key="relatedProduct.id"
              class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all duration-200"
            >
              <Link :href="`/products/${relatedProduct.id}`">
                <img 
                  :src="relatedProduct.image || '/api/placeholder/300/300'"
                  :alt="relatedProduct.name"
                  class="w-full h-48 object-cover"
                />
                <div class="p-4">
                  <h3 class="font-semibold text-card-foreground mb-2 line-clamp-2">{{ relatedProduct.name }}</h3>
                  <div class="flex items-center justify-between">
                    <span class="font-bold text-foreground">Rp {{ formatCurrency(relatedProduct.price) }}</span>
                    <span class="text-xs text-muted-foreground">{{ relatedProduct.stock }} left</span>
                  </div>
                </div>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Link } from '@inertiajs/vue3'

// Define props interface
interface Product {
  id: number
  name: string
  description: string | null
  price: number
  original_price?: number
  stock: number
  image: string | null
  gallery?: string[]
  category?: string
  sku?: string
  weight?: number
  dimensions?: string
}

interface PageProps {
  product: Product
  relatedProducts?: Product[]
  auth: {
    user: any
  }
}

// Define props
const props = defineProps<PageProps>()

// Reactive data
const quantity = ref(1)
const isAddingToCart = ref(false)

// Methods
const formatCurrency = (amount: number): string => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

const increaseQuantity = () => {
  if (quantity.value < props.product.stock) {
    quantity.value++
  }
}

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--
  }
}

const addToCart = async () => {
  if (!props.auth.user) {
    router.visit('/login')
    return
  }

  isAddingToCart.value = true
  
  try {
    await router.post('/cart/add', {
      product_id: props.product.id,
      quantity: quantity.value
    }, {
      onSuccess: () => {
        // Show success message or update cart count
        console.log('Product added to cart successfully')
        // Reset quantity after adding
        quantity.value = 1
      },
      onError: (errors) => {
        console.error('Error adding to cart:', errors)
      }
    })
  } catch (error) {
    console.error('Error adding to cart:', error)
  } finally {
    isAddingToCart.value = false
  }
}

const buyNow = async () => {
  if (!props.auth.user) {
    router.visit('/login')
    return
  }
  
  // Add to cart first, then redirect to checkout
  try {
    await router.post('/cart/add', {
      product_id: props.product.id,
      quantity: quantity.value
    }, {
      onSuccess: () => {
        // Redirect to checkout
        router.visit('/checkout')
      },
      onError: (errors) => {
        console.error('Error adding to cart for buy now:', errors)
      }
    })
  } catch (error) {
    console.error('Error in buy now:', error)
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
