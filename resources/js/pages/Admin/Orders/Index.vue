<template>
  <AdminLayout title="Manage Orders">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-3xl font-bold text-foreground">Manage Orders</h1>
              <p class="text-muted-foreground mt-2">Track and manage customer orders</p>
            </div>
            <div class="flex items-center space-x-2">
              <Link href="/admin/sales-report">
                <Button variant="outline">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2 2z" />
                  </svg>
                  Sales Report
                </Button>
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <!-- Filters -->
        <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 mb-6">
          <form @submit.prevent="search" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Search</label>
              <input 
                v-model="filters.search"
                type="text" 
                placeholder="Order #, customer name, email..."
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Status</label>
              <select 
                v-model="filters.status"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              >
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Date From</label>
              <input 
                v-model="filters.date_from"
                type="date"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Date To</label>
              <input 
                v-model="filters.date_to"
                type="date"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              />
            </div>
            
            <div class="flex items-end">
              <Button type="submit" class="w-full">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Search
              </Button>
            </div>
          </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-background border-b-2 border-border">
                <tr>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Order</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Customer</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Date</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Items</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Total</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Payment</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Status</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-foreground">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-border">
                <tr v-if="orders.data.length === 0">
                  <td colspan="8" class="px-6 py-8 text-center text-muted-foreground">
                    No orders found
                  </td>
                </tr>
                <tr v-else v-for="order in orders.data" :key="order.id" class="hover:bg-background/50">
                  <!-- Order Info -->
                  <td class="px-6 py-4">
                    <div>
                      <div class="font-medium text-card-foreground">#{{ order.order_number }}</div>
                      <div class="text-sm text-muted-foreground">ID: {{ order.id }}</div>
                    </div>
                  </td>
                  
                  <!-- Customer -->
                  <td class="px-6 py-4">
                    <div>
                      <div class="font-medium text-card-foreground">{{ order.user.name }}</div>
                      <div class="text-sm text-muted-foreground">{{ order.user.email }}</div>
                    </div>
                  </td>
                  
                  <!-- Date -->
                  <td class="px-6 py-4">
                    <div class="text-sm text-card-foreground">
                      {{ formatDate(order.created_at) }}
                    </div>
                  </td>
                  
                  <!-- Items -->
                  <td class="px-6 py-4">
                    <div class="text-sm text-card-foreground">
                      {{ order.order_items.length }} {{ order.order_items.length === 1 ? 'item' : 'items' }}
                    </div>
                    <div class="text-xs text-muted-foreground">
                      {{ getTotalQuantity(order.order_items) }} total qty
                    </div>
                  </td>
                  
                  <!-- Total -->
                  <td class="px-6 py-4">
                    <div class="font-medium text-card-foreground">
                      Rp {{ formatCurrency(order.total_amount) }}
                    </div>
                  </td>
                  
                  <!-- Payment Method -->
                  <td class="px-6 py-4">
                    <div class="text-sm text-card-foreground">
                      {{ formatPaymentMethod(order.payment_method) }}
                    </div>
                  </td>
                  
                  <!-- Status -->
                  <td class="px-6 py-4">
                    <select 
                      :value="order.status"
                      @change="updateOrderStatus(order.id, ($event.target as HTMLSelectElement).value)"
                      :class="getStatusClass(order.status)"
                      class="text-xs px-2 py-1 rounded-[3px] border font-medium"
                    >
                      <option value="pending">Pending</option>
                      <option value="processing">Processing</option>
                      <option value="shipped">Shipped</option>
                      <option value="delivered">Delivered</option>
                      <option value="cancelled">Cancelled</option>
                    </select>
                  </td>
                  
                  <!-- Actions -->
                  <td class="px-6 py-4">
                    <div class="flex items-center space-x-2">
                      <Link :href="`/admin/orders/${order.id}`">
                        <Button variant="outline" size="sm">
                          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg>
                        </Button>
                      </Link>
                      
                      <Button 
                        variant="outline" 
                        size="sm"
                        @click="printOrder(order.id)"
                      >
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                      </Button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="orders.last_page > 1" class="mt-6 flex justify-center">
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
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/layouts/AdminLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Link } from '@inertiajs/vue3'

// Define interfaces
interface User {
  name: string
  email: string
}

interface OrderItem {
  id: number
  quantity: number
  price: number
}

interface Order {
  id: number
  order_number: string
  total_amount: number
  status: string
  payment_method: string
  created_at: string
  user: User
  order_items: OrderItem[]
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
  filters: {
    search: string
    status: string
    date_from: string
    date_to: string
  }
  auth: {
    user: any
  }
}

// Define props
const props = defineProps<PageProps>()

// Reactive data
const filters = ref({
  search: props.filters.search || '',
  status: props.filters.status || '',
  date_from: props.filters.date_from || '',
  date_to: props.filters.date_to || ''
})

// Methods
const formatCurrency = (amount: number): string => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

const formatDate = (dateString: string): string => {
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'short',
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

const getTotalQuantity = (items: OrderItem[]): number => {
  return items.reduce((sum, item) => sum + item.quantity, 0)
}

const search = () => {
  router.get('/admin/orders', filters.value, {
    preserveState: true,
    preserveScroll: true
  })
}

const updateOrderStatus = async (orderId: number, newStatus: string) => {
  try {
    await router.put(`/admin/orders/${orderId}/status`, {
      status: newStatus
    }, {
      preserveState: true,
      onError: (errors) => {
        console.error('Error updating order status:', errors)
      }
    })
  } catch (error) {
    console.error('Error updating order status:', error)
  }
}

const printOrder = (orderId: number) => {
  window.open(`/admin/orders/${orderId}/print`, '_blank')
}

</script>
