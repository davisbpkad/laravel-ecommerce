<template>
  <div class="relative" @mouseenter="fetchCartItems" @mouseleave="hideCart">
    <!-- Cart Link -->
    <Link href="/cart" class="text-card-foreground hover:text-primary transition-colors relative flex items-center">
      🛒 Cart
      <span v-if="cartCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
        {{ cartCount }}
      </span>
    </Link>

    <!-- Cart Dropdown -->
    <div 
      v-show="showCartDropdown && cartCount > 0" 
      class="absolute right-0 top-full mt-2 w-80 bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] z-50"
      @mouseenter="showCartDropdown = true"
      @mouseleave="hideCart"
    >
      <!-- Loading State -->
      <div v-if="loading" class="p-4 text-center text-muted-foreground">
        <svg class="w-6 h-6 animate-spin mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        Loading cart items...
      </div>

      <!-- Cart Items -->
      <div v-else-if="cartItems.length > 0" class="max-h-96 overflow-y-auto">
        <!-- Header -->
        <div class="p-4 border-b border-border">
          <h3 class="font-semibold text-card-foreground">Shopping Cart</h3>
          <p class="text-sm text-muted-foreground">{{ cartItems.length }} item(s)</p>
        </div>

        <!-- Items List -->
        <div class="p-2">
          <div 
            v-for="item in cartItems" 
            :key="item.id" 
            class="flex items-center space-x-3 p-2 hover:bg-background rounded-[3px] transition-colors"
          >
            <!-- Product Image -->
            <div class="flex-shrink-0">
              <div v-if="item.product.image" class="w-12 h-12 rounded-[3px] border border-border overflow-hidden">
                <img :src="item.product.image" :alt="item.product.name" class="w-full h-full object-cover" />
              </div>
              <div v-else class="w-12 h-12 rounded-[3px] border border-border bg-muted flex items-center justify-center">
                <svg class="w-6 h-6 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
              </div>
            </div>

            <!-- Product Info -->
            <div class="flex-1 min-w-0">
              <h4 class="text-sm font-medium text-card-foreground truncate">{{ item.product.name }}</h4>
              <div class="flex items-center justify-between mt-1">
                <span class="text-xs text-muted-foreground">Qty: {{ item.quantity }}</span>
                <span class="text-sm font-semibold text-primary">
                  Rp {{ formatCurrency(item.product.price * item.quantity) }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-border p-4">
          <div class="flex items-center justify-between mb-3">
            <span class="font-medium text-card-foreground">Total:</span>
            <span class="text-lg font-bold text-primary">
              Rp {{ formatCurrency(cartTotal) }}
            </span>
          </div>
          <div class="flex space-x-2">
            <Link href="/cart" class="flex-1">
              <Button variant="outline" size="sm" class="w-full">
                View Cart
              </Button>
            </Link>
            <Link href="/checkout" class="flex-1">
              <Button variant="default" size="sm" class="w-full">
                Checkout
              </Button>
            </Link>
          </div>
        </div>
      </div>

      <!-- Empty Cart -->
      <div v-else class="p-6 text-center">
        <svg class="w-12 h-12 mx-auto mb-3 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
        </svg>
        <h3 class="font-medium text-card-foreground mb-1">Your cart is empty</h3>
        <p class="text-sm text-muted-foreground mb-3">Add some products to get started</p>
        <Link href="/products">
          <Button variant="default" size="sm">
            Browse Products
          </Button>
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import Button from '@/components/ui/button/Button.vue'

interface Product {
  id: number
  name: string
  price: number
  image?: string
}

interface CartItem {
  id: number
  product: Product
  quantity: number
}

interface Props {
  cartCount: number
}

const props = defineProps<Props>()

const showCartDropdown = ref(false)
const loading = ref(false)
const cartItems = ref<CartItem[]>([])

// Computed properties
const cartTotal = computed(() => {
  return cartItems.value.reduce((total, item) => {
    return total + (item.product.price * item.quantity)
  }, 0)
})

// Methods
const formatCurrency = (amount: number): string => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

const fetchCartItems = async () => {
  if (props.cartCount === 0) return
  
  showCartDropdown.value = true
  
  // Don't fetch if already loaded
  if (cartItems.value.length > 0) return
  
  loading.value = true
  
  try {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    const response = await fetch('/api/cart/items', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token || '',
        'Accept': 'application/json'
      }
    })
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`)
    }
    
    const data = await response.json()
    cartItems.value = data.items || []
  } catch (error) {
    console.error('Error fetching cart items:', error)
    cartItems.value = []
  } finally {
    loading.value = false
  }
}

let hideTimeout: number | null = null

const hideCart = () => {
  if (hideTimeout) clearTimeout(hideTimeout)
  
  hideTimeout = setTimeout(() => {
    showCartDropdown.value = false
  }, 200) // Small delay to prevent flickering
}

// Clear timeout if component unmounts
import { onUnmounted } from 'vue'
onUnmounted(() => {
  if (hideTimeout) clearTimeout(hideTimeout)
})
</script>
