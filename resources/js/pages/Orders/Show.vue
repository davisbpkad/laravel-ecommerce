<template>
  <EcommerceLayout title="Order Details">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <div class="flex items-center space-x-2 mb-4">
            <Link href="/orders" class="text-muted-foreground hover:text-foreground transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </Link>
            <span class="text-muted-foreground">Back to Orders</span>
          </div>
          <h1 class="text-3xl font-bold text-foreground">Order #{{ order.order_number }}</h1>
          <div class="flex items-center space-x-4 mt-2">
            <span :class="getStatusClass(order.status)" class="px-3 py-1 text-sm font-medium rounded-[5px] border">
              {{ getStatusText(order.status) }}
            </span>
            <span class="text-muted-foreground">Placed on {{ formatDate(order.created_at) }}</span>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Order Items -->
          <div class="lg:col-span-2">
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
              <div class="p-6 border-b-2 border-border">
                <h2 class="text-xl font-semibold text-card-foreground">Order Items</h2>
              </div>
              
              <div class="p-6">
                <div class="space-y-6">
                  <div 
                    v-for="item in order.order_items" 
                    :key="item.id"
                    class="flex items-center space-x-4 pb-6 border-b border-border last:border-b-0 last:pb-0"
                  >
                    <Link :href="`/products/${item.product.id}`" class="flex-shrink-0">
                      <img 
                        :src="item.product.image || '/api/placeholder/100/100'"
                        :alt="item.product.name"
                        class="w-20 h-20 object-cover rounded-[5px] border-2 border-border"
                      />
                    </Link>
                    
                    <div class="flex-1 min-w-0">
                      <Link :href="`/products/${item.product.id}`" class="block group">
                        <h3 class="text-lg font-medium text-card-foreground group-hover:text-foreground transition-colors line-clamp-2">
                          {{ item.product.name }}
                        </h3>
                      </Link>
                      <div class="flex items-center space-x-4 mt-2 text-sm text-muted-foreground">
                        <span>Quantity: {{ item.quantity }}</span>
                        <span>•</span>
                        <span>Price: Rp {{ formatCurrency(item.price) }} each</span>
                      </div>
                    </div>
                    
                    <div class="text-right">
                      <div class="text-lg font-semibold text-card-foreground">
                        Rp {{ formatCurrency(item.price * item.quantity) }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Order Summary & Details -->
          <div class="space-y-6">
            <!-- Order Summary -->
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
              <div class="p-6 border-b-2 border-border">
                <h2 class="text-xl font-semibold text-card-foreground">Order Summary</h2>
              </div>
              
              <div class="p-6 space-y-4">
                <div class="flex justify-between text-card-foreground">
                  <span>Subtotal</span>
                  <span>Rp {{ formatCurrency(subtotal) }}</span>
                </div>
                <div class="flex justify-between text-card-foreground">
                  <span>Shipping</span>
                  <span>Rp {{ formatCurrency(shipping) }}</span>
                </div>
                <div class="flex justify-between text-card-foreground">
                  <span>Tax</span>
                  <span>Rp {{ formatCurrency(tax) }}</span>
                </div>
                <div class="border-t border-border pt-4">
                  <div class="flex justify-between text-lg font-bold text-foreground">
                    <span>Total</span>
                    <span>Rp {{ formatCurrency(order.total_amount) }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
              <div class="p-6 border-b-2 border-border">
                <h2 class="text-xl font-semibold text-card-foreground">Payment Information</h2>
              </div>
              
              <div class="p-6">
                <div class="space-y-3">
                  <div>
                    <span class="text-sm text-muted-foreground">Payment Method</span>
                    <div class="font-medium text-card-foreground">
                      {{ formatPaymentMethod(order.payment_method) }}
                    </div>
                  </div>
                  <div>
                    <span class="text-sm text-muted-foreground">Order Status</span>
                    <div>
                      <span :class="getStatusClass(order.status)" class="px-2 py-1 text-xs font-medium rounded-[3px] border">
                        {{ getStatusText(order.status) }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
              <div class="p-6 border-b-2 border-border">
                <h2 class="text-xl font-semibold text-card-foreground">Shipping Address</h2>
              </div>
              
              <div class="p-6">
                <div class="space-y-2 text-card-foreground">
                  <div class="font-medium">
                    {{ order.shipping_address.first_name }} {{ order.shipping_address.last_name }}
                  </div>
                  <div>{{ order.shipping_address.address }}</div>
                  <div>{{ order.shipping_address.city }}, {{ order.shipping_address.state }} {{ order.shipping_address.postal_code }}</div>
                  <div>{{ order.shipping_address.phone }}</div>
                  <div>{{ order.shipping_address.email }}</div>
                </div>
              </div>
            </div>

            <!-- Order Actions -->
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
              <div class="p-6">
                <div class="space-y-3">
                  <Button 
                    v-if="order.status === 'pending'"
                    variant="destructive" 
                    class="w-full"
                    @click="cancelOrder"
                  >
                    Cancel Order
                  </Button>
                  
                  <Button 
                    v-if="order.status === 'delivered'"
                    variant="outline" 
                    class="w-full"
                    @click="reorderItems"
                  >
                    Order Again
                  </Button>
                  
                  <Button 
                    v-if="['shipped', 'delivered'].includes(order.status)"
                    variant="outline" 
                    class="w-full"
                    @click="trackOrder"
                  >
                    Track Order
                  </Button>

                  <Button 
                    variant="outline" 
                    class="w-full"
                    @click="printOrder"
                  >
                    Print Order
                  </Button>
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
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Link } from '@inertiajs/vue3'

// Define interfaces
interface Product {
  id: number
  name: string
  image: string | null
}

interface OrderItem {
  id: number
  quantity: number
  price: number
  product: Product
}

interface ShippingAddress {
  first_name: string
  last_name: string
  email: string
  phone: string
  address: string
  city: string
  state: string
  postal_code: string
}

interface Order {
  id: number
  order_number: string
  status: string
  total_amount: number
  payment_method: string
  created_at: string
  shipping_address: ShippingAddress
  notes?: string
  order_items: OrderItem[]
}

interface PageProps {
  order: Order
  auth: {
    user: any
  }
}

// Define props
const props = defineProps<PageProps>()

// Computed properties
const subtotal = computed(() => {
  return props.order.order_items.reduce((sum, item) => sum + (item.price * item.quantity), 0)
})

const shipping = computed(() => {
  // Simple shipping calculation - free for orders over 500k
  return subtotal.value >= 500000 ? 0 : 25000
})

const tax = computed(() => {
  // 10% tax
  return Math.round(subtotal.value * 0.1)
})

// Methods
const formatCurrency = (amount: number): string => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

const formatDate = (dateString: string): string => {
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const formatPaymentMethod = (method: string): string => {
  const methods = {
    bank_transfer: 'Bank Transfer',
    cod: 'Cash on Delivery',
    e_wallet: 'E-Wallet'
  }
  return methods[method as keyof typeof methods] || method
}

const getStatusClass = (status: string): string => {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800 border-yellow-300',
    processing: 'bg-blue-100 text-blue-800 border-blue-300',
    shipped: 'bg-purple-100 text-purple-800 border-purple-300',
    delivered: 'bg-green-100 text-green-800 border-green-300',
    cancelled: 'bg-red-100 text-red-800 border-red-300'
  }
  return classes[status as keyof typeof classes] || 'bg-gray-100 text-gray-800 border-gray-300'
}

const getStatusText = (status: string): string => {
  const texts = {
    pending: 'Pending',
    processing: 'Processing',
    shipped: 'Shipped',
    delivered: 'Delivered',
    cancelled: 'Cancelled'
  }
  return texts[status as keyof typeof texts] || status
}

const cancelOrder = async () => {
  if (!confirm('Are you sure you want to cancel this order?')) {
    return
  }
  
  try {
    await router.put(`/orders/${props.order.id}/cancel`, {}, {
      onSuccess: () => {
        router.visit('/orders')
      },
      onError: (errors) => {
        console.error('Error cancelling order:', errors)
      }
    })
  } catch (error) {
    console.error('Error cancelling order:', error)
  }
}

const reorderItems = async () => {
  try {
    await router.post(`/orders/${props.order.id}/reorder`, {}, {
      onSuccess: () => {
        router.visit('/cart')
      },
      onError: (errors) => {
        console.error('Error reordering:', errors)
      }
    })
  } catch (error) {
    console.error('Error reordering:', error)
  }
}

const trackOrder = () => {
  router.visit(`/orders/${props.order.id}/track`)
}

const printOrder = () => {
  window.print()
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

@media print {
  .no-print {
    display: none !important;
  }
}
</style>
