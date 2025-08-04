<template>
  <EcommerceLayout title="My Orders">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <h1 class="text-3xl font-bold text-foreground">My Orders</h1>
          <p class="text-muted-foreground mt-2">Track and manage your orders</p>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <!-- Empty State -->
        <div v-if="orders.data.length === 0" class="text-center py-16">
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-8 max-w-md mx-auto">
            <svg class="w-16 h-16 mx-auto mb-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h2 class="text-xl font-semibold text-card-foreground mb-2">No orders yet</h2>
            <p class="text-muted-foreground mb-6">Start shopping to see your orders here!</p>
            <Link href="/products">
              <Button size="lg">Start Shopping</Button>
            </Link>
          </div>
        </div>

        <!-- Orders List -->
        <div v-else class="space-y-6">
          <div 
            v-for="order in orders.data" 
            :key="order.id"
            class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden"
          >
            <!-- Order Header -->
            <div class="p-6 border-b-2 border-border">
              <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                  <div class="flex items-center space-x-4">
                    <h2 class="text-lg font-semibold text-card-foreground">
                      Order #{{ order.order_number }}
                    </h2>
                    <span :class="getStatusClass(order.status)" class="px-2 py-1 text-xs font-medium rounded-[3px] border">
                      {{ getStatusText(order.status) }}
                    </span>
                  </div>
                  <div class="flex items-center space-x-4 mt-2 text-sm text-muted-foreground">
                    <span>Placed on {{ formatDate(order.created_at) }}</span>
                    <span>•</span>
                    <span>{{ order.items.length }} {{ order.items.length === 1 ? 'item' : 'items' }}</span>
                  </div>
                </div>
                
                <div class="text-right">
                  <div class="text-lg font-bold text-foreground">
                    Rp {{ formatCurrency(order.total_amount) }}
                  </div>
                  <div class="text-sm text-muted-foreground">
                    {{ order.payment_method.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Order Items -->
            <div class="p-6">
              <div class="space-y-4">
                <div 
                  v-for="item in order.items" 
                  :key="item.id"
                  class="flex items-center space-x-4"
                >
                  <Link :href="`/products/${item.product.id}`" class="flex-shrink-0">
                    <img 
                      :src="item.product.image || '/api/placeholder/80/80'"
                      :alt="item.product.name"
                      class="w-16 h-16 object-cover rounded-[5px] border-2 border-border"
                    />
                  </Link>
                  
                  <div class="flex-1 min-w-0">
                    <Link :href="`/products/${item.product.id}`" class="block group">
                      <h3 class="font-medium text-card-foreground group-hover:text-foreground transition-colors line-clamp-2">
                        {{ item.product.name }}
                      </h3>
                    </Link>
                    <div class="flex items-center space-x-4 mt-1 text-sm text-muted-foreground">
                      <span>Qty: {{ item.quantity }}</span>
                      <span>•</span>
                      <span>Rp {{ formatCurrency(item.price) }} each</span>
                    </div>
                  </div>
                  
                  <div class="text-right">
                    <div class="font-medium text-card-foreground">
                      Rp {{ formatCurrency(item.price * item.quantity) }}
                    </div>
                  </div>
                </div>
              </div>

              <!-- Order Actions -->
              <div class="flex flex-col sm:flex-row gap-3 mt-6 pt-6 border-t border-border">
                <Button 
                  v-if="order.status === 'pending'"
                  variant="destructive" 
                  size="sm"
                  @click="cancelOrder(order.id)"
                >
                  Cancel Order
                </Button>
                
                <Button 
                  v-if="order.status === 'delivered'"
                  variant="outline" 
                  size="sm"
                  @click="reorderItems(order.id)"
                >
                  Order Again
                </Button>
                
                <Button 
                  variant="outline" 
                  size="sm"
                  @click="viewOrderDetails(order.id)"
                >
                  View Details
                </Button>
                
                <Button 
                  v-if="['shipped', 'delivered'].includes(order.status)"
                  variant="outline" 
                  size="sm"
                  @click="trackOrder(order.id)"
                >
                  Track Order
                </Button>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="orders.last_page > 1" class="mt-8 flex justify-center">
          <div class="flex items-center space-x-2">
            <Link 
              v-if="orders.prev_page_url" 
              :href="orders.prev_page_url"
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
              Page {{ orders.current_page }} of {{ orders.last_page }}
            </span>
            
            <Link 
              v-if="orders.next_page_url" 
              :href="orders.next_page_url"
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
  </EcommerceLayout>
</template>

<script setup lang="ts">
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

interface Order {
  id: number
  order_number: string
  status: string
  total_amount: number
  payment_method: string
  created_at: string
  items: OrderItem[]
}

interface PaginatedOrders {
  data: Order[]
  current_page: number
  last_page: number
  prev_page_url: string | null
  next_page_url: string | null
}

interface PageProps {
  orders: PaginatedOrders
  auth: {
    user: any
  }
}

// Define props
const props = defineProps<PageProps>()

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

const cancelOrder = async (orderId: number) => {
  if (!confirm('Are you sure you want to cancel this order?')) {
    return
  }
  
  try {
    await router.put(`/orders/${orderId}/cancel`, {}, {
      onError: (errors) => {
        console.error('Error cancelling order:', errors)
      }
    })
  } catch (error) {
    console.error('Error cancelling order:', error)
  }
}

const reorderItems = async (orderId: number) => {
  try {
    await router.post(`/orders/${orderId}/reorder`, {}, {
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

const viewOrderDetails = (orderId: number) => {
  router.visit(`/orders/${orderId}`)
}

const trackOrder = (orderId: number) => {
  router.visit(`/orders/${orderId}/track`)
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
