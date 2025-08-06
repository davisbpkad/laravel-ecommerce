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
        
        <!-- Monthly Report Generator -->
        <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 mb-6">
          <h3 class="text-lg font-semibold text-card-foreground mb-4">Generate Monthly Sales Report</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Month</label>
              <select 
                v-model="monthlyFilters.month"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              >
                <option v-for="month in months" :key="month.value" :value="month.value">
                  {{ month.label }}
                </option>
              </select>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Year</label>
              <select 
                v-model="monthlyFilters.year"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              >
                <option v-for="year in availableYears" :key="year" :value="year">
                  {{ year }}
                </option>
              </select>
            </div>
            
            <div class="flex items-end space-x-2">
              <Button 
                @click="generateMonthlyReport" 
                :disabled="loadingReport"
                class="flex-1"
              >
                <svg v-if="loadingReport" class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ loadingReport ? 'Generating...' : 'Generate' }}
              </Button>
              
            </div>
          </div>
        </div>

        <!-- Generated Monthly Report -->
        <div v-if="monthlyReportData" class="mt-8">
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-xl font-semibold text-card-foreground">
                Monthly Report: {{ monthlyReportPeriod?.month_name }} {{ monthlyReportPeriod?.year }}
              </h3>
              <div class="text-sm text-muted-foreground">
                {{ monthlyReportPeriod?.start_date }} to {{ monthlyReportPeriod?.end_date }}
              </div>
            </div>

            <!-- Monthly Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
              <div class="bg-green-50 border border-green-200 rounded-[5px] p-4">
                <div class="text-sm text-green-600 font-medium">Total Sales</div>
                <div class="text-2xl font-bold text-green-700">Rp {{ formatCurrency(monthlyReportData.summary.total_sales) }}</div>
              </div>
              <div class="bg-blue-50 border border-blue-200 rounded-[5px] p-4">
                <div class="text-sm text-blue-600 font-medium">Total Orders</div>
                <div class="text-2xl font-bold text-blue-700">{{ monthlyReportData.summary.total_orders }}</div>
              </div>
              <div class="bg-purple-50 border border-purple-200 rounded-[5px] p-4">
                <div class="text-sm text-purple-600 font-medium">Avg Order Value</div>
                <div class="text-2xl font-bold text-purple-700">Rp {{ formatCurrency(monthlyReportData.summary.average_order_value) }}</div>
              </div>
              <div class="bg-orange-50 border border-orange-200 rounded-[5px] p-4">
                <div class="text-sm text-orange-600 font-medium">Total Customers</div>
                <div class="text-2xl font-bold text-orange-700">{{ monthlyReportData.summary.total_customers }}</div>
              </div>
            </div>

            <!-- Daily Sales Chart -->
            <div class="mb-8">
              <h4 class="text-lg font-semibold text-card-foreground mb-4">Daily Sales Overview</h4>
              <div class="bg-background border border-border rounded-[5px] p-4 max-h-64 overflow-y-auto">
                <div class="space-y-2">
                  <div v-for="daily in monthlyReportData.daily_sales" :key="daily.date" class="flex justify-between items-center py-2 border-b border-border last:border-b-0">
                    <div class="text-sm font-medium">{{ formatDate(daily.date) }}</div>
                    <div class="flex space-x-4">
                      <div class="text-sm text-muted-foreground">{{ daily.orders_count }} orders</div>
                      <div class="text-sm font-medium">Rp {{ formatCurrency(daily.daily_sales) }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Top Products for Month -->
            <div class="mb-8">
              <h4 class="text-lg font-semibold text-card-foreground mb-4">Top Products This Month</h4>
              <div class="bg-background border border-border rounded-[5px] overflow-hidden">
                <table class="w-full">
                  <thead class="bg-muted">
                    <tr>
                      <th class="text-left p-3 text-sm font-medium">Product</th>
                      <th class="text-left p-3 text-sm font-medium">Category</th>
                      <th class="text-right p-3 text-sm font-medium">Sold</th>
                      <th class="text-right p-3 text-sm font-medium">Revenue</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="product in monthlyReportData.top_products" :key="product.id" class="border-t border-border">
                      <td class="p-3">
                        <div class="font-medium">{{ product.name }}</div>
                        <div class="text-sm text-muted-foreground">Rp {{ formatCurrency(product.price) }}</div>
                      </td>
                      <td class="p-3 text-sm">{{ product.category }}</td>
                      <td class="p-3 text-right font-medium">{{ product.total_sold }}</td>
                      <td class="p-3 text-right font-medium">Rp {{ formatCurrency(product.total_revenue) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Payment Methods & Order Status -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <div>
                <h4 class="text-lg font-semibold text-card-foreground mb-4">Payment Methods</h4>
                <div class="space-y-3">
                  <div v-for="method in monthlyReportData.payment_methods" :key="method.payment_method" class="flex justify-between items-center p-3 bg-background border border-border rounded-[5px]">
                    <div>
                      <div class="font-medium">{{ formatPaymentMethod(method.payment_method) }}</div>
                      <div class="text-sm text-muted-foreground">{{ method.count }} orders</div>
                    </div>
                    <div class="text-right">
                      <div class="font-medium">Rp {{ formatCurrency(method.total_amount) }}</div>
                    </div>
                  </div>
                </div>
              </div>

              <div>
                <h4 class="text-lg font-semibold text-card-foreground mb-4">Order Status</h4>
                <div class="space-y-3">
                  <div v-for="status in monthlyReportData.order_status" :key="status.status" class="flex justify-between items-center p-3 bg-background border border-border rounded-[5px]">
                    <div>
                      <div class="font-medium capitalize">{{ status.status }}</div>
                    </div>
                    <div class="text-right">
                      <div class="font-medium">{{ status.count }} orders</div>
                    </div>
                  </div>
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
import { ref, onMounted, onUnmounted } from 'vue'
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

// Monthly report filters
const monthlyFilters = ref({
  month: new Date().getMonth() + 1,
  year: new Date().getFullYear()
})

// Monthly report interfaces
interface MonthlyReportSummary {
  total_sales: number
  total_orders: number
  average_order_value: number
  total_customers: number
}

interface MonthlyReportDailySales {
  date: string
  orders_count: number
  daily_sales: number
}

interface MonthlyReportTopProduct {
  id: number
  name: string
  price: number
  category: string
  total_sold: number
  total_revenue: number
}

interface MonthlyReportPaymentMethod {
  payment_method: string
  count: number
  total_amount: number
}

interface MonthlyReportOrderStatus {
  status: string
  count: number
}

interface MonthlyReportData {
  summary: MonthlyReportSummary
  daily_sales: MonthlyReportDailySales[]
  top_products: MonthlyReportTopProduct[]
  payment_methods: MonthlyReportPaymentMethod[]
  order_status: MonthlyReportOrderStatus[]
}

interface MonthlyReportPeriod {
  month_name: string
  year: number
  start_date: string
  end_date: string
}

// Monthly report data
const monthlyReportData = ref<MonthlyReportData | null>(null)
const monthlyReportPeriod = ref<MonthlyReportPeriod | null>(null)
const loadingReport = ref(false)
const showExportDropdown = ref(false)

// Available months
const months = [
  { value: 1, label: 'January' },
  { value: 2, label: 'February' },
  { value: 3, label: 'March' },
  { value: 4, label: 'April' },
  { value: 5, label: 'May' },
  { value: 6, label: 'June' },
  { value: 7, label: 'July' },
  { value: 8, label: 'August' },
  { value: 9, label: 'September' },
  { value: 10, label: 'October' },
  { value: 11, label: 'November' },
  { value: 12, label: 'December' }
]

// Available years (last 5 years)
const currentYear = new Date().getFullYear()
const availableYears = Array.from({ length: 5 }, (_, i) => currentYear - i)

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

const generateMonthlyReport = async () => {
  loadingReport.value = true
  showExportDropdown.value = false
  
  try {
    const response = await fetch(`/admin/sales-report/generate-monthly?month=${monthlyFilters.value.month}&year=${monthlyFilters.value.year}`)
    const result = await response.json()
    
    if (result.status === 'success') {
      monthlyReportData.value = result.data
      monthlyReportPeriod.value = result.period
    } else {
      console.error('Failed to generate monthly report')
    }
  } catch (error) {
    console.error('Error generating monthly report:', error)
  } finally {
    loadingReport.value = false
  }
}

const exportMonthlyReport = (format: string) => {
  const queryParams = new URLSearchParams({
    month: monthlyFilters.value.month.toString(),
    year: monthlyFilters.value.year.toString(),
    format: format
  }).toString()
  
  window.open(`/admin/sales-report/export-monthly?${queryParams}`, '_blank')
  showExportDropdown.value = false
}

const toggleExportDropdown = () => {
  showExportDropdown.value = !showExportDropdown.value
}

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  })
}

const exportReport = () => {
  const queryParams = new URLSearchParams(filters.value).toString()
  window.open(`/admin/sales-report/export?${queryParams}`, '_blank')
}

// Close dropdown when clicking outside
const handleClickOutside = (event: Event) => {
  const target = event.target as HTMLElement
  if (!target.closest('.export-dropdown')) {
    showExportDropdown.value = false
  }
}

// Add event listener on mount
onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
