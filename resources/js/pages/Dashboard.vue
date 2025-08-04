<template>
  <EcommerceLayout title="Dashboard">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <h1 class="text-3xl font-bold text-foreground mb-2">Welcome back, {{ $page.props.auth.user.name }}!</h1>
          <p class="text-muted-foreground">Here's what's happening with your account</p>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <!-- Browse Products -->
          <Link href="/products">
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 cursor-pointer">
              <div class="flex items-center">
                <div class="bg-primary text-primary-foreground p-3 rounded-[5px] mr-4">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
                </div>
                <div>
                  <h3 class="font-semibold text-card-foreground">Browse Products</h3>
                  <p class="text-muted-foreground text-sm">Discover new items</p>
                </div>
              </div>
            </div>
          </Link>

          <!-- View Cart -->
          <Link href="/cart">
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 cursor-pointer">
              <div class="flex items-center">
                <div class="bg-secondary text-secondary-foreground p-3 rounded-[5px] mr-4">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
                  </svg>
                </div>
                <div>
                  <h3 class="font-semibold text-card-foreground">My Cart</h3>
                  <p class="text-muted-foreground text-sm">{{ cartItemsCount }} items</p>
                </div>
              </div>
            </div>
          </Link>

          <!-- My Orders -->
          <Link href="/orders">
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all duration-200 cursor-pointer">
              <div class="flex items-center">
                <div class="bg-accent text-accent-foreground p-3 rounded-[5px] mr-4">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                </div>
                <div>
                  <h3 class="font-semibold text-card-foreground">My Orders</h3>
                  <p class="text-muted-foreground text-sm">Track your purchases</p>
                </div>
              </div>
            </div>
          </Link>
        </div>

        <!-- Recent Orders -->
        <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 mb-8">
          <h2 class="text-xl font-semibold text-card-foreground mb-4">Recent Orders</h2>
          
          <div v-if="recentOrders && recentOrders.length > 0" class="space-y-4">
            <div v-for="order in recentOrders" :key="order.id" class="border border-border rounded-[5px] p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="font-medium text-card-foreground">Order #{{ order.id }}</span>
                <span class="text-sm px-2 py-1 rounded-[3px] border" :class="getOrderStatusClass(order.status)">
                  {{ order.status }}
                </span>
              </div>
              <div class="text-sm text-muted-foreground mb-2">
                {{ formatDate(order.created_at) }}
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm text-muted-foreground">
                  {{ order.items_count }} item(s)
                </span>
                <span class="font-semibold text-foreground">
                  Rp {{ formatCurrency(order.total_amount) }}
                </span>
              </div>
            </div>
          </div>
          
          <div v-else class="text-center py-8">
            <svg class="w-12 h-12 mx-auto mb-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="text-lg font-medium text-card-foreground mb-2">No orders yet</h3>
            <p class="text-muted-foreground mb-4">Start shopping to see your orders here</p>
            <Link href="/products">
              <Button variant="default">Browse Products</Button>
            </Link>
          </div>
        </div>

        <!-- Account Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Total Orders -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-muted-foreground">Total Orders</p>
                <p class="text-2xl font-bold text-foreground">{{ stats.totalOrders }}</p>
              </div>
              <div class="bg-primary/10 p-3 rounded-[5px]">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Total Spent -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-muted-foreground">Total Spent</p>
                <p class="text-2xl font-bold text-foreground">Rp {{ formatCurrency(stats.totalSpent) }}</p>
              </div>
              <div class="bg-secondary/10 p-3 rounded-[5px]">
                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Member Since -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-muted-foreground">Member Since</p>
                <p class="text-2xl font-bold text-foreground">{{ memberSince }}</p>
              </div>
              <div class="bg-accent/10 p-3 rounded-[5px]">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Link, usePage } from '@inertiajs/vue3'

const $page = usePage()

// Define interfaces
interface Order {
  id: number
  status: string
  total_amount: number
  items_count: number
  created_at: string
}

interface DashboardStats {
  totalOrders: number
  totalSpent: number
}

interface Props {
  recentOrders?: Order[]
  stats: DashboardStats
  cartItemsCount: number
}

const props = withDefaults(defineProps<Props>(), {
  recentOrders: () => [],
  stats: () => ({ totalOrders: 0, totalSpent: 0 }),
  cartItemsCount: 0
})

// Computed properties
const memberSince = computed(() => {
  const joinDate = new Date($page.props.auth.user?.created_at || Date.now())
  return joinDate.getFullYear().toString()
})

// Methods
const formatCurrency = (amount: number): string => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

const formatDate = (dateString: string): string => {
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const getOrderStatusClass = (status: string): string => {
  switch (status.toLowerCase()) {
    case 'pending':
      return 'bg-yellow-100 text-yellow-800 border-yellow-300'
    case 'processing':
      return 'bg-blue-100 text-blue-800 border-blue-300'
    case 'shipped':
      return 'bg-purple-100 text-purple-800 border-purple-300'
    case 'delivered':
      return 'bg-green-100 text-green-800 border-green-300'
    case 'cancelled':
      return 'bg-red-100 text-red-800 border-red-300'
    default:
      return 'bg-gray-100 text-gray-800 border-gray-300'
  }
}
</script>
