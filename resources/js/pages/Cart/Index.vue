<template>
  <EcommerceLayout title="Shopping Cart">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-foreground">Shopping Cart</h1>
            <div class="text-muted-foreground">
              {{ cartItems.length }} {{ cartItems.length === 1 ? 'item' : 'items' }}
            </div>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <!-- Empty Cart State -->
        <div v-if="cartItems.length === 0" class="text-center py-16">
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-8 max-w-md mx-auto">
            <svg class="w-16 h-16 mx-auto mb-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
            </svg>
            <h2 class="text-xl font-semibold text-card-foreground mb-2">Your cart is empty</h2>
            <p class="text-muted-foreground mb-6">Add some products to get started!</p>
            <Link href="/products">
              <Button size="lg">Continue Shopping</Button>
            </Link>
          </div>
        </div>

        <!-- Cart Items -->
        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Cart Items List -->
          <div class="lg:col-span-2 space-y-4">
            <div 
              v-for="item in cartItems" 
              :key="item.id"
              class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden"
            >
              <div class="p-6">
                <div class="flex items-start space-x-4">
                  <!-- Product Image -->
                  <Link :href="`/products/${item.product.id}`" class="flex-shrink-0">
                    <img 
                      :src="item.product.image || '/api/placeholder/120/120'"
                      :alt="item.product.name"
                      class="w-20 h-20 object-cover rounded-[5px] border-2 border-border"
                    />
                  </Link>

                  <!-- Product Details -->
                  <div class="flex-1 min-w-0">
                    <Link :href="`/products/${item.product.id}`" class="block group">
                      <h3 class="font-semibold text-card-foreground group-hover:text-foreground transition-colors line-clamp-2">
                        {{ item.product.name }}
                      </h3>
                    </Link>
                    <p class="text-sm text-muted-foreground mt-1">
                      Stock: {{ item.product.stock }} available
                    </p>
                    <div class="flex items-center justify-between mt-4">
                      <!-- Quantity Controls -->
                      <div class="flex items-center space-x-2">
                        <Button 
                          variant="outline" 
                          size="sm" 
                          @click="updateQuantity(item.id, item.quantity - 1)"
                          :disabled="item.quantity <= 1 || isUpdating[item.id]"
                        >
                          -
                        </Button>
                        <span class="px-3 py-1 border-2 border-border rounded-[5px] bg-background text-center min-w-[50px]">
                          {{ item.quantity }}
                        </span>
                        <Button 
                          variant="outline" 
                          size="sm" 
                          @click="updateQuantity(item.id, item.quantity + 1)"
                          :disabled="item.quantity >= item.product.stock || isUpdating[item.id]"
                        >
                          +
                        </Button>
                      </div>

                      <!-- Price -->
                      <div class="text-right">
                        <div class="font-bold text-foreground">
                          Rp {{ formatCurrency(item.product.price * item.quantity) }}
                        </div>
                        <div class="text-sm text-muted-foreground">
                          Rp {{ formatCurrency(item.product.price) }} each
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Remove Button -->
                  <Button 
                    variant="destructive" 
                    size="sm" 
                    @click="removeItem(item.id)"
                    :disabled="isRemoving[item.id]"
                    class="flex-shrink-0"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </Button>
                </div>
              </div>
            </div>

            <!-- Clear Cart Button -->
            <div class="pt-4">
              <Button 
                variant="outline" 
                @click="clearCart"
                :disabled="isClearingCart"
                class="w-full sm:w-auto"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Clear Cart
              </Button>
            </div>
          </div>

          <!-- Order Summary -->
          <div class="lg:col-span-1">
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 sticky top-8">
              <h2 class="text-xl font-semibold text-card-foreground mb-6">Order Summary</h2>
              
              <div class="space-y-4">
                <!-- Subtotal -->
                <div class="flex justify-between">
                  <span class="text-muted-foreground">Subtotal ({{ totalItems }} items)</span>
                  <span class="font-medium text-card-foreground">Rp {{ formatCurrency(subtotal) }}</span>
                </div>

                <!-- Shipping -->
                <div class="flex justify-between">
                  <span class="text-muted-foreground">Shipping</span>
                  <span class="font-medium text-card-foreground">
                    {{ shipping === 0 ? 'Free' : `Rp ${formatCurrency(shipping)}` }}
                  </span>
                </div>

                <!-- Tax -->
                <div class="flex justify-between">
                  <span class="text-muted-foreground">Tax</span>
                  <span class="font-medium text-card-foreground">Rp {{ formatCurrency(tax) }}</span>
                </div>

                <hr class="border-border" />

                <!-- Total -->
                <div class="flex justify-between text-lg font-bold">
                  <span class="text-card-foreground">Total</span>
                  <span class="text-foreground">Rp {{ formatCurrency(total) }}</span>
                </div>
              </div>

              <!-- Checkout Button -->
              <div class="mt-6 space-y-3">
                <Link href="/checkout">
                  <Button size="lg" class="w-full">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Proceed to Checkout
                  </Button>
                </Link>
                
                <Link href="/products">
                  <Button variant="outline" class="w-full">
                    Continue Shopping
                  </Button>
                </Link>
              </div>

              <!-- Security Badge -->
              <div class="mt-6 pt-6 border-t border-border">
                <div class="flex items-center justify-center space-x-2 text-sm text-muted-foreground">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                  <span>Secure Checkout</span>
                </div>
              </div>
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

// Define interfaces
interface Product {
  id: number
  name: string
  price: number
  stock: number
  image: string | null
}

interface CartItem {
  id: number
  product_id: number
  quantity: number
  product: Product
}

interface PageProps {
  cartItems: CartItem[]
  auth: {
    user: any
  }
}

// Define props
const props = defineProps<PageProps>()

// Reactive data
const isUpdating = ref<Record<number, boolean>>({})
const isRemoving = ref<Record<number, boolean>>({})
const isClearingCart = ref(false)

// Constants for calculations
const TAX_RATE = 0.1 // 10% tax
const FREE_SHIPPING_THRESHOLD = 500000 // Free shipping over 500k
const SHIPPING_COST = 25000 // 25k shipping cost

// Computed properties
const subtotal = computed(() => {
  return props.cartItems.reduce((sum, item) => sum + (item.product.price * item.quantity), 0)
})

const totalItems = computed(() => {
  return props.cartItems.reduce((sum, item) => sum + item.quantity, 0)
})

const shipping = computed(() => {
  return subtotal.value >= FREE_SHIPPING_THRESHOLD ? 0 : SHIPPING_COST
})

const tax = computed(() => {
  return Math.round(subtotal.value * TAX_RATE)
})

const total = computed(() => {
  return subtotal.value + shipping.value + tax.value
})

// Methods
const formatCurrency = (amount: number): string => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

const updateQuantity = async (cartItemId: number, newQuantity: number) => {
  if (newQuantity < 1) return
  
  isUpdating.value[cartItemId] = true
  
  try {
    await router.put(`/cart/${cartItemId}`, {
      quantity: newQuantity
    }, {
      onError: (errors) => {
        console.error('Error updating quantity:', errors)
      }
    })
  } catch (error) {
    console.error('Error updating quantity:', error)
  } finally {
    isUpdating.value[cartItemId] = false
  }
}

const removeItem = async (cartItemId: number) => {
  if (!confirm('Are you sure you want to remove this item from your cart?')) {
    return
  }
  
  isRemoving.value[cartItemId] = true
  
  try {
    await router.delete(`/cart/${cartItemId}`, {
      onError: (errors) => {
        console.error('Error removing item:', errors)
      }
    })
  } catch (error) {
    console.error('Error removing item:', error)
  } finally {
    isRemoving.value[cartItemId] = false
  }
}

const clearCart = async () => {
  if (!confirm('Are you sure you want to clear your entire cart?')) {
    return
  }
  
  isClearingCart.value = true
  
  try {
    await router.delete('/cart/clear', {
      onError: (errors) => {
        console.error('Error clearing cart:', errors)
      }
    })
  } catch (error) {
    console.error('Error clearing cart:', error)
  } finally {
    isClearingCart.value = false
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
