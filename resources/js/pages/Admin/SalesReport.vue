<template>
  <AdminLayout title="Sales Report">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-3xl font-bold text-foreground">Sales Report</h1>
              <p class="text-muted-foreground mt-2">Analyze your sales performance and trends</p>
            </div>
            <div class="flex items-center space-x-2">
              <Link href="/admin/orders">
                <Button variant="outline">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  Back to Orders
                </Button>
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <!-- Date Range Filter -->
        <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 mb-6">
          <form @submit.prevent="generateReport" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
            
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Report Type</label>
              <select 
                v-model="filters.type"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              >
                <option value="daily">Daily</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
              </select>
            </div>
            
            <div class="flex items-end">
              <Button type="submit" class="w-full">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2 2z" />
                </svg>
                Generate Report
              </Button>
            </div>
          </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <!-- Total Sales -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-muted-foreground">Total Sales</p>
                <p class="text-2xl font-bold text-foreground">Rp {{ formatCurrency(report.totalSales) }}</p>
                <p class="text-xs text-green-600 mt-1">+12% from last period</p>
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
                <p class="text-2xl font-bold text-foreground">{{ report.totalOrders }}</p>
                <p class="text-xs text-blue-600 mt-1">+8% from last period</p>
              </div>
              <div class="bg-blue-100 p-3 rounded-[5px]">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Average Order Value -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-muted-foreground">Avg Order Value</p>
                <p class="text-2xl font-bold text-foreground">Rp {{ formatCurrency(report.averageOrderValue) }}</p>
                <p class="text-xs text-purple-600 mt-1">+5% from last period</p>
              </div>
              <div class="bg-purple-100 p-3 rounded-[5px]">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Total Customers -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-muted-foreground">Total Customers</p>
                <p class="text-2xl font-bold text-foreground">{{ report.totalCustomers }}</p>
                <p class="text-xs text-orange-600 mt-1">+15% from last period</p>
              </div>
              <div class="bg-orange-100 p-3 rounded-[5px]">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Top Selling Products -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <h3 class="text-lg font-semibold text-card-foreground mb-4">Top Selling Products</h3>
            <div class="space-y-4">
              <div v-for="product in report.topProducts" :key="product.id" class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <img 
                    :src="product.image || '/api/placeholder/40/40'"
                    :alt="product.name"
                    class="w-10 h-10 rounded-[5px] border border-border object-cover"
                  />
                  <div>
                    <div class="font-medium text-card-foreground">{{ product.name }}</div>
                    <div class="text-sm text-muted-foreground">{{ product.sales_count }} sold</div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="font-medium text-card-foreground">Rp {{ formatCurrency(product.revenue) }}</div>
                  <div class="text-sm text-muted-foreground">Revenue</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment Methods -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <h3 class="text-lg font-semibold text-card-foreground mb-4">Payment Methods</h3>
            <div class="space-y-4">
              <div v-for="method in report.paymentMethods" :key="method.method" class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 bg-primary/10 rounded-[5px] flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                  </div>
                  <div>
                    <div class="font-medium text-card-foreground">{{ formatPaymentMethod(method.method) }}</div>
                    <div class="text-sm text-muted-foreground">{{ method.count }} orders</div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="font-medium text-card-foreground">{{ method.percentage }}%</div>
                  <div class="text-sm text-muted-foreground">of total</div>
                </div>
              </div>
            </div>
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
interface TopProduct {
  id: number
  name: string
  image: string | null
  sales_count: number
  revenue: number
}

interface PaymentMethod {
  method: string
  count: number
  percentage: number
}

interface SalesReport {
  totalSales: number
  totalOrders: number
  averageOrderValue: number
  totalCustomers: number
  topProducts: TopProduct[]
  paymentMethods: PaymentMethod[]
}

interface PageProps {
  report: SalesReport
  filters: {
    date_from: string
    date_to: string
    type: string
  }
  auth: {
    user: any
  }
}

// Define props
const props = defineProps<PageProps>()

// Reactive data
const filters = ref({
  date_from: props.filters.date_from || '',
  date_to: props.filters.date_to || '',
  type: props.filters.type || 'monthly'
})

// Methods
const formatCurrency = (amount: number): string => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

const formatPaymentMethod = (method: string): string => {
  const methods = {
    bank_transfer: 'Bank Transfer',
    cod: 'Cash on Delivery',
    e_wallet: 'E-Wallet'
  }
  return methods[method as keyof typeof methods] || method
}

const generateReport = () => {
  router.get('/admin/sales-report', filters.value, {
    preserveState: true,
    preserveScroll: true
  })
}

const exportReport = () => {
  const queryParams = new URLSearchParams(filters.value).toString()
  window.open(`/admin/sales-report/export?${queryParams}`, '_blank')
}
</script>
