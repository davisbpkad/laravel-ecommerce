<template>
  <AdminLayout title="Admin Dashboard">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <div class="flex items-center justify-between">
            <div>
              <h1 class="text-3xl font-bold text-foreground">Admin Dashboard</h1>
              <p class="text-muted-foreground mt-2">Welcome back, {{ auth.user.name }}!</p>
            </div>
            <div class="text-right">
              <div class="text-sm text-muted-foreground">Last updated</div>
              <div class="font-medium text-foreground">{{ currentTime }}</div>
            </div>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <!-- Total Revenue -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-muted-foreground">Total Revenue</p>
                <p class="text-2xl font-bold text-foreground">Rp {{ formatCurrency(stats.totalRevenue) }}</p>
                <p class="text-xs text-green-600 mt-1">+{{ stats.revenueGrowth }}% from last month</p>
              </div>
              <div class="bg-green-100 p-3 rounded-[5px]">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Total Orders -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-muted-foreground">Total Orders</p>
                <p class="text-2xl font-bold text-foreground">{{ stats.totalOrders }}</p>
                <p class="text-xs text-blue-600 mt-1">+{{ stats.ordersGrowth }}% from last month</p>
              </div>
              <div class="bg-blue-100 p-3 rounded-[5px]">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Total Products -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-muted-foreground">Total Products</p>
                <p class="text-2xl font-bold text-foreground">{{ stats.totalProducts }}</p>
                <p class="text-xs text-purple-600 mt-1">{{ stats.activeProducts }} active</p>
              </div>
              <div class="bg-purple-100 p-3 rounded-[5px]">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Total Users -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-muted-foreground">Total Users</p>
                <p class="text-2xl font-bold text-foreground">{{ stats.totalUsers }}</p>
                <p class="text-xs text-orange-600 mt-1">+{{ stats.usersGrowth }}% from last month</p>
              </div>
              <div class="bg-orange-100 p-3 rounded-[5px]">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Recent Orders -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
            <div class="p-6 border-b-2 border-border">
              <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-card-foreground">Recent Orders</h2>
                <Link href="/admin/orders">
                  <Button variant="outline" size="sm">View All</Button>
                </Link>
              </div>
            </div>
            <div class="p-6">
              <div v-if="recentOrders.length === 0" class="text-center py-8 text-muted-foreground">
                No recent orders
              </div>
              <div v-else class="space-y-4">
                <div 
                  v-for="order in recentOrders" 
                  :key="order.id"
                  class="flex items-center justify-between p-4 bg-background border border-border rounded-[5px]"
                >
                  <div>
                    <div class="font-medium text-foreground">#{{ order.order_number }}</div>
                    <div class="text-sm text-muted-foreground">{{ order.user.name }}</div>
                    <div class="text-xs text-muted-foreground">{{ formatDate(order.created_at) }}</div>
                  </div>
                  <div class="text-right">
                    <div class="font-medium text-foreground">Rp {{ formatCurrency(order.total_amount) }}</div>
                    <span :class="getStatusClass(order.status)" class="text-xs px-2 py-1 rounded-[3px] border">
                      {{ getStatusText(order.status) }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Low Stock Products -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
            <div class="p-6 border-b-2 border-border">
              <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-card-foreground">Low Stock Products</h2>
                <Link href="/admin/products">
                  <Button variant="outline" size="sm">Manage</Button>
                </Link>
              </div>
            </div>
            <div class="p-6">
              <div v-if="lowStockProducts.length === 0" class="text-center py-8 text-muted-foreground">
                All products have sufficient stock
              </div>
              <div v-else class="space-y-4">
                <div 
                  v-for="product in lowStockProducts" 
                  :key="product.id"
                  class="flex items-center justify-between p-4 bg-background border border-border rounded-[5px]"
                >
                  <div class="flex items-center space-x-3">
                    <img 
                      :src="product.image || '/api/placeholder/50/50'"
                      :alt="product.name"
                      class="w-12 h-12 object-cover rounded-[5px] border border-border"
                    />
                    <div>
                      <div class="font-medium text-foreground line-clamp-1">{{ product.name }}</div>
                      <div class="text-sm text-muted-foreground">SKU: {{ product.sku || 'N/A' }}</div>
                    </div>
                  </div>
                  <div class="text-right">
                    <div :class="product.stock <= 5 ? 'text-red-600' : 'text-orange-600'" class="font-medium">
                      {{ product.stock }} left
                    </div>
                    <div class="text-sm text-muted-foreground">Rp {{ formatCurrency(product.price) }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8">
          <h2 class="text-xl font-semibold text-foreground mb-6">Quick Actions</h2>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <Link href="/admin/products/create">
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 text-center hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 cursor-pointer">
                <svg class="w-8 h-8 mx-auto mb-2 text-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <div class="font-medium text-card-foreground">Add Product</div>
              </div>
            </Link>

            <Link href="/admin/orders">
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 text-center hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 cursor-pointer">
                <svg class="w-8 h-8 mx-auto mb-2 text-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <div class="font-medium text-card-foreground">Manage Orders</div>
              </div>
            </Link>

            <Link href="/admin/products">
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 text-center hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 cursor-pointer">
                <svg class="w-8 h-8 mx-auto mb-2 text-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <div class="font-medium text-card-foreground">Manage Products</div>
              </div>
            </Link>

            <Link href="/admin/sales-report">
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 text-center hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 cursor-pointer">
                <svg class="w-8 h-8 mx-auto mb-2 text-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2 2z" />
                </svg>
                <div class="font-medium text-card-foreground">Sales Report</div>
              </div>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Link } from '@inertiajs/vue3'

// Define interfaces
interface Stats {
  totalRevenue: number
  revenueGrowth: number
  totalOrders: number
  ordersGrowth: number
  totalProducts: number
  activeProducts: number
  totalUsers: number
  usersGrowth: number
}

interface User {
  name: string
}

interface Order {
  id: number
  order_number: string
  total_amount: number
  status: string
  created_at: string
  user: User
}

interface Product {
  id: number
  name: string
  price: number
  stock: number
  image: string | null
  sku: string | null
}

interface PageProps {
  stats: Stats
  recentOrders: Order[]
  lowStockProducts: Product[]
  auth: {
    user: any
  }
}

// Define props
const props = defineProps<PageProps>()

// Reactive data
const currentTime = ref('')

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

const updateCurrentTime = () => {
  currentTime.value = new Date().toLocaleString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  })
}

onMounted(() => {
  updateCurrentTime()
  // Update time every second
  setInterval(updateCurrentTime, 1000)
})
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
