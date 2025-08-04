<template>
  <EcommerceLayout title="Track Order">
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
          <h1 class="text-3xl font-bold text-foreground">Track Order #{{ order.order_number }}</h1>
          <p class="text-muted-foreground mt-2">Follow your order journey</p>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
          <!-- Order Status Timeline -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 mb-8">
            <h2 class="text-xl font-semibold text-card-foreground mb-6">Order Status</h2>
            
            <div class="relative">
              <!-- Timeline -->
              <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-border"></div>
              
              <div class="space-y-8">
                <!-- Order Placed -->
                <div class="relative flex items-center">
                  <div class="relative z-10 flex items-center justify-center w-12 h-12 bg-green-500 border-4 border-background rounded-full">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <div class="ml-6">
                    <h3 class="text-lg font-medium text-card-foreground">Order Placed</h3>
                    <p class="text-sm text-muted-foreground">{{ formatDate(order.created_at) }}</p>
                    <p class="text-sm text-muted-foreground">Your order has been successfully placed.</p>
                  </div>
                </div>

                <!-- Processing -->
                <div class="relative flex items-center">
                  <div :class="getTimelineClass('processing')" class="relative z-10 flex items-center justify-center w-12 h-12 border-4 border-background rounded-full">
                    <svg v-if="isStatusCompleted('processing')" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <div v-else-if="order.status === 'processing'" class="w-3 h-3 bg-current rounded-full animate-pulse"></div>
                    <div v-else class="w-3 h-3 bg-current rounded-full"></div>
                  </div>
                  <div class="ml-6">
                    <h3 class="text-lg font-medium text-card-foreground">Processing</h3>
                    <p class="text-sm text-muted-foreground">
                      {{ isStatusCompleted('processing') ? 'Your order is being prepared.' : 'Waiting to be processed.' }}
                    </p>
                  </div>
                </div>

                <!-- Shipped -->
                <div class="relative flex items-center">
                  <div :class="getTimelineClass('shipped')" class="relative z-10 flex items-center justify-center w-12 h-12 border-4 border-background rounded-full">
                    <svg v-if="isStatusCompleted('shipped')" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <div v-else-if="order.status === 'shipped'" class="w-3 h-3 bg-current rounded-full animate-pulse"></div>
                    <div v-else class="w-3 h-3 bg-current rounded-full"></div>
                  </div>
                  <div class="ml-6">
                    <h3 class="text-lg font-medium text-card-foreground">Shipped</h3>
                    <p class="text-sm text-muted-foreground">
                      {{ isStatusCompleted('shipped') ? 'Your order is on the way.' : 'Waiting to be shipped.' }}
                    </p>
                  </div>
                </div>

                <!-- Delivered -->
                <div class="relative flex items-center">
                  <div :class="getTimelineClass('delivered')" class="relative z-10 flex items-center justify-center w-12 h-12 border-4 border-background rounded-full">
                    <svg v-if="isStatusCompleted('delivered')" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <div v-else-if="order.status === 'delivered'" class="w-3 h-3 bg-current rounded-full animate-pulse"></div>
                    <div v-else class="w-3 h-3 bg-current rounded-full"></div>
                  </div>
                  <div class="ml-6">
                    <h3 class="text-lg font-medium text-card-foreground">Delivered</h3>
                    <p class="text-sm text-muted-foreground">
                      {{ isStatusCompleted('delivered') ? 'Your order has been delivered.' : 'Waiting for delivery.' }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Order Details -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order Info -->
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
              <div class="p-6 border-b-2 border-border">
                <h2 class="text-xl font-semibold text-card-foreground">Order Information</h2>
              </div>
              
              <div class="p-6 space-y-4">
                <div>
                  <span class="text-sm text-muted-foreground">Order Number</span>
                  <div class="font-medium text-card-foreground">{{ order.order_number }}</div>
                </div>
                <div>
                  <span class="text-sm text-muted-foreground">Order Date</span>
                  <div class="font-medium text-card-foreground">{{ formatDate(order.created_at) }}</div>
                </div>
                <div>
                  <span class="text-sm text-muted-foreground">Total Amount</span>
                  <div class="font-medium text-card-foreground">Rp {{ formatCurrency(order.total_amount) }}</div>
                </div>
                <div>
                  <span class="text-sm text-muted-foreground">Payment Method</span>
                  <div class="font-medium text-card-foreground">{{ formatPaymentMethod(order.payment_method) }}</div>
                </div>
                <div>
                  <span class="text-sm text-muted-foreground">Current Status</span>
                  <div>
                    <span :class="getStatusClass(order.status)" class="px-2 py-1 text-xs font-medium rounded-[3px] border">
                      {{ getStatusText(order.status) }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Shipping Info -->
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
              <div class="p-6 border-b-2 border-border">
                <h2 class="text-xl font-semibold text-card-foreground">Shipping Information</h2>
              </div>
              
              <div class="p-6 space-y-4">
                <div>
                  <span class="text-sm text-muted-foreground">Recipient</span>
                  <div class="font-medium text-card-foreground">
                    {{ order.shipping_address.first_name }} {{ order.shipping_address.last_name }}
                  </div>
                </div>
                <div>
                  <span class="text-sm text-muted-foreground">Address</span>
                  <div class="font-medium text-card-foreground">
                    {{ order.shipping_address.address }}<br>
                    {{ order.shipping_address.city }}, {{ order.shipping_address.state }} {{ order.shipping_address.postal_code }}
                  </div>
                </div>
                <div>
                  <span class="text-sm text-muted-foreground">Phone</span>
                  <div class="font-medium text-card-foreground">{{ order.shipping_address.phone }}</div>
                </div>
                <div>
                  <span class="text-sm text-muted-foreground">Email</span>
                  <div class="font-medium text-card-foreground">{{ order.shipping_address.email }}</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Back to Orders -->
          <div class="mt-8 text-center">
            <Link href="/orders">
              <Button variant="outline" size="lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Orders
              </Button>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Link } from '@inertiajs/vue3'

// Define interfaces
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
}

interface PageProps {
  order: Order
  auth: {
    user: any
  }
}

// Define props
const props = defineProps<PageProps>()

// Status order for timeline
const statusOrder = ['pending', 'processing', 'shipped', 'delivered']

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

const isStatusCompleted = (status: string): boolean => {
  const currentIndex = statusOrder.indexOf(props.order.status)
  const targetIndex = statusOrder.indexOf(status)
  return currentIndex >= targetIndex
}

const getTimelineClass = (status: string): string => {
  if (isStatusCompleted(status)) {
    return 'bg-green-500 text-white'
  } else if (props.order.status === status) {
    return 'bg-blue-500 text-white'
  } else {
    return 'bg-gray-300 text-gray-600'
  }
}
</script>
