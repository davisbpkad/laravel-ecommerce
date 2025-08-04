<template>
  <EcommerceLayout title="Checkout">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <h1 class="text-3xl font-bold text-foreground">Checkout</h1>
          <div class="flex items-center space-x-2 mt-2 text-sm text-muted-foreground">
            <Link href="/cart" class="hover:text-foreground transition-colors">Cart</Link>
            <span>/</span>
            <span class="text-foreground">Checkout</span>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <!-- Redirect if cart is empty -->
        <div v-if="cartItems.length === 0" class="text-center py-16">
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-8 max-w-md mx-auto">
            <svg class="w-16 h-16 mx-auto mb-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
            </svg>
            <h2 class="text-xl font-semibold text-card-foreground mb-2">Your cart is empty</h2>
            <p class="text-muted-foreground mb-6">Add some products before checkout!</p>
            <Link href="/products">
              <Button size="lg">Continue Shopping</Button>
            </Link>
          </div>
        </div>

        <!-- Checkout Form -->
        <form v-else @submit.prevent="submitOrder" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Checkout Form -->
          <div class="lg:col-span-2 space-y-6">
            <!-- Shipping Information -->
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
              <h2 class="text-xl font-semibold text-card-foreground mb-6">Shipping Information</h2>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                  <label class="text-sm font-medium text-card-foreground">First Name *</label>
                  <input 
                    v-model="form.shipping_address.first_name"
                    type="text" 
                    required
                    class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter first name"
                  />
                  <span v-if="errors.shipping_address?.first_name" class="text-sm text-red-600">{{ errors.shipping_address.first_name }}</span>
                </div>
                
                <div class="space-y-2">
                  <label class="text-sm font-medium text-card-foreground">Last Name *</label>
                  <input 
                    v-model="form.shipping_address.last_name"
                    type="text" 
                    required
                    class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter last name"
                  />
                  <span v-if="errors.shipping_address?.last_name" class="text-sm text-red-600">{{ errors.shipping_address.last_name }}</span>
                </div>
                
                <div class="md:col-span-2 space-y-2">
                  <label class="text-sm font-medium text-card-foreground">Email *</label>
                  <input 
                    v-model="form.shipping_address.email"
                    type="email" 
                    required
                    class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter email address"
                  />
                  <span v-if="errors.shipping_address?.email" class="text-sm text-red-600">{{ errors.shipping_address.email }}</span>
                </div>
                
                <div class="md:col-span-2 space-y-2">
                  <label class="text-sm font-medium text-card-foreground">Phone Number *</label>
                  <input 
                    v-model="form.shipping_address.phone"
                    type="tel" 
                    required
                    class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter phone number"
                  />
                  <span v-if="errors.shipping_address?.phone" class="text-sm text-red-600">{{ errors.shipping_address.phone }}</span>
                </div>
                
                <div class="md:col-span-2 space-y-2">
                  <label class="text-sm font-medium text-card-foreground">Address *</label>
                  <textarea 
                    v-model="form.shipping_address.address"
                    required
                    rows="3"
                    class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter full address"
                  ></textarea>
                  <span v-if="errors.shipping_address?.address" class="text-sm text-red-600">{{ errors.shipping_address.address }}</span>
                </div>
                
                <div class="space-y-2">
                  <label class="text-sm font-medium text-card-foreground">City *</label>
                  <input 
                    v-model="form.shipping_address.city"
                    type="text" 
                    required
                    class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter city"
                  />
                  <span v-if="errors.shipping_address?.city" class="text-sm text-red-600">{{ errors.shipping_address.city }}</span>
                </div>
                
                <div class="space-y-2">
                  <label class="text-sm font-medium text-card-foreground">Postal Code *</label>
                  <input 
                    v-model="form.shipping_address.postal_code"
                    type="text" 
                    required
                    class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter postal code"
                  />
                  <span v-if="errors.shipping_address?.postal_code" class="text-sm text-red-600">{{ errors.shipping_address.postal_code }}</span>
                </div>
                
                <div class="md:col-span-2 space-y-2">
                  <label class="text-sm font-medium text-card-foreground">State/Province *</label>
                  <input 
                    v-model="form.shipping_address.state"
                    type="text" 
                    required
                    class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter state or province"
                  />
                  <span v-if="errors.shipping_address?.state" class="text-sm text-red-600">{{ errors.shipping_address.state }}</span>
                </div>
              </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
              <h2 class="text-xl font-semibold text-card-foreground mb-6">Payment Method</h2>
              
              <div class="space-y-4">
                <label class="flex items-center space-x-3 cursor-pointer">
                  <input 
                    v-model="form.payment_method" 
                    type="radio" 
                    value="bank_transfer" 
                    class="w-4 h-4 text-foreground bg-background border-2 border-border focus:ring-ring"
                  />
                  <div class="flex-1">
                    <div class="font-medium text-card-foreground">Bank Transfer</div>
                    <div class="text-sm text-muted-foreground">Transfer to our bank account</div>
                  </div>
                </label>
                
                <label class="flex items-center space-x-3 cursor-pointer">
                  <input 
                    v-model="form.payment_method" 
                    type="radio" 
                    value="cod" 
                    class="w-4 h-4 text-foreground bg-background border-2 border-border focus:ring-ring"
                  />
                  <div class="flex-1">
                    <div class="font-medium text-card-foreground">Cash on Delivery (COD)</div>
                    <div class="text-sm text-muted-foreground">Pay when you receive the order</div>
                  </div>
                </label>
                
                <label class="flex items-center space-x-3 cursor-pointer">
                  <input 
                    v-model="form.payment_method" 
                    type="radio" 
                    value="e_wallet" 
                    class="w-4 h-4 text-foreground bg-background border-2 border-border focus:ring-ring"
                  />
                  <div class="flex-1">
                    <div class="font-medium text-card-foreground">E-Wallet</div>
                    <div class="text-sm text-muted-foreground">OVO, GoPay, Dana, etc.</div>
                  </div>
                </label>
              </div>
              <span v-if="errors.payment_method" class="text-sm text-red-600">{{ errors.payment_method }}</span>
            </div>

            <!-- Order Notes -->
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
              <h2 class="text-xl font-semibold text-card-foreground mb-6">Order Notes (Optional)</h2>
              <textarea 
                v-model="form.notes"
                rows="4"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="Any special instructions for your order..."
              ></textarea>
            </div>
          </div>

          <!-- Order Summary -->
          <div class="lg:col-span-1">
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 sticky top-8">
              <h2 class="text-xl font-semibold text-card-foreground mb-6">Order Summary</h2>
              
              <!-- Order Items -->
              <div class="space-y-3 mb-6">
                <div 
                  v-for="item in cartItems" 
                  :key="item.id"
                  class="flex items-center space-x-3"
                >
                  <img 
                    :src="item.product.image || '/api/placeholder/60/60'"
                    :alt="item.product.name"
                    class="w-12 h-12 object-cover rounded-[5px] border border-border"
                  />
                  <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-card-foreground truncate">
                      {{ item.product.name }}
                    </div>
                    <div class="text-xs text-muted-foreground">
                      Qty: {{ item.quantity }} × Rp {{ formatCurrency(item.product.price) }}
                    </div>
                  </div>
                  <div class="text-sm font-medium text-card-foreground">
                    Rp {{ formatCurrency(item.product.price * item.quantity) }}
                  </div>
                </div>
              </div>

              <hr class="border-border mb-4" />
              
              <!-- Totals -->
              <div class="space-y-3">
                <div class="flex justify-between text-sm">
                  <span class="text-muted-foreground">Subtotal ({{ totalItems }} items)</span>
                  <span class="text-card-foreground">Rp {{ formatCurrency(subtotal) }}</span>
                </div>
                
                <div class="flex justify-between text-sm">
                  <span class="text-muted-foreground">Shipping</span>
                  <span class="text-card-foreground">
                    {{ shipping === 0 ? 'Free' : `Rp ${formatCurrency(shipping)}` }}
                  </span>
                </div>
                
                <div class="flex justify-between text-sm">
                  <span class="text-muted-foreground">Tax</span>
                  <span class="text-card-foreground">Rp {{ formatCurrency(tax) }}</span>
                </div>
                
                <hr class="border-border" />
                
                <div class="flex justify-between text-lg font-bold">
                  <span class="text-card-foreground">Total</span>
                  <span class="text-foreground">Rp {{ formatCurrency(total) }}</span>
                </div>
              </div>

              <!-- Place Order Button -->
              <div class="mt-6">
                <Button 
                  type="submit" 
                  size="lg" 
                  class="w-full"
                  :disabled="isSubmitting"
                >
                  <svg v-if="isSubmitting" class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 16c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z" />
                  </svg>
                  <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  {{ isSubmitting ? 'Processing...' : 'Place Order' }}
                </Button>
              </div>

              <!-- Security Info -->
              <div class="mt-4 pt-4 border-t border-border">
                <div class="flex items-center justify-center space-x-2 text-xs text-muted-foreground">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                  <span>Your order is secured with SSL encryption</span>
                </div>
              </div>
            </div>
          </div>
        </form>
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
  errors: Record<string, any>
}

// Define props
const props = defineProps<PageProps>()

// Reactive data
const isSubmitting = ref(false)

const form = ref({
  shipping_address: {
    first_name: '',
    last_name: '',
    email: props.auth.user?.email || '',
    phone: '',
    address: '',
    city: '',
    state: '',
    postal_code: ''
  },
  payment_method: 'bank_transfer',
  notes: ''
})

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

const submitOrder = async () => {
  isSubmitting.value = true
  
  try {
    await router.post('/checkout', form.value, {
      onSuccess: () => {
        // Will redirect to order success page
      },
      onError: (errors) => {
        console.error('Checkout errors:', errors)
      }
    })
  } catch (error) {
    console.error('Error submitting order:', error)
  } finally {
    isSubmitting.value = false
  }
}
</script>
