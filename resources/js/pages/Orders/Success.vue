<template>
  <EcommerceLayout title="Order Successful">
    <div class="min-h-screen bg-background flex items-center justify-center p-4">
      <div class="max-w-md w-full">
        <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
          <!-- Success Header -->
          <div class="bg-green-100 border-b-2 border-border p-6 text-center">
            <div class="bg-green-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <h1 class="text-2xl font-bold text-green-800 mb-2">Order Successful!</h1>
            <p class="text-green-700">Thank you for your purchase</p>
          </div>

          <!-- Order Details -->
          <div class="p-6">
            <div class="text-center mb-6">
              <div class="text-sm text-muted-foreground mb-1">Order Number</div>
              <div class="text-lg font-bold text-foreground">#{{ order.order_number }}</div>
            </div>

            <div class="space-y-4 mb-6">
              <div class="flex justify-between">
                <span class="text-muted-foreground">Order Date:</span>
                <span class="text-card-foreground">{{ formatDate(order.created_at) }}</span>
              </div>
              
              <div class="flex justify-between">
                <span class="text-muted-foreground">Total Amount:</span>
                <span class="font-bold text-foreground">Rp {{ formatCurrency(order.total_amount) }}</span>
              </div>
              
              <div class="flex justify-between">
                <span class="text-muted-foreground">Payment Method:</span>
                <span class="text-card-foreground">{{ formatPaymentMethod(order.payment_method) }}</span>
              </div>
              
              <div class="flex justify-between">
                <span class="text-muted-foreground">Status:</span>
                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 border border-yellow-300 rounded-[3px] text-xs font-medium">
                  Pending
                </span>
              </div>
            </div>

            <!-- Order Items -->
            <div class="border-t border-border pt-4 mb-6">
              <h3 class="font-medium text-card-foreground mb-3">Order Items</h3>
              <div class="space-y-3">
                <div 
                  v-for="item in order.order_items" 
                  :key="item.id"
                  class="flex items-center justify-between"
                >
                  <div class="flex items-center space-x-3">
                    <img 
                      :src="item.product.image || '/api/placeholder/40/40'"
                      :alt="item.product.name"
                      class="w-10 h-10 object-cover rounded-[5px] border border-border"
                    />
                    <div>
                      <div class="text-sm font-medium text-card-foreground">{{ item.product.name }}</div>
                      <div class="text-xs text-muted-foreground">Qty: {{ item.quantity }}</div>
                    </div>
                  </div>
                  <div class="text-sm font-medium text-card-foreground">
                    Rp {{ formatCurrency(item.price * item.quantity) }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-background border border-border rounded-[5px] p-4 mb-6">
              <h3 class="font-medium text-foreground mb-2">What's Next?</h3>
              <ul class="text-sm text-muted-foreground space-y-1">
                <li v-if="order.payment_method === 'bank_transfer'">• You will receive payment instructions via email</li>
                <li v-if="order.payment_method === 'cod'">• Our team will contact you to confirm delivery</li>
                <li v-if="order.payment_method === 'e_wallet'">• Complete payment through your e-wallet app</li>
                <li>• We'll send you tracking information once shipped</li>
                <li>• Estimated delivery: 3-5 business days</li>
              </ul>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
              <Link href="/orders">
                <Button class="w-full" size="lg">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  View My Orders
                </Button>
              </Link>
              
              <Link href="/products">
                <Button variant="outline" class="w-full">
                  Continue Shopping
                </Button>
              </Link>
            </div>

            <!-- Contact Support -->
            <div class="text-center mt-6 pt-6 border-t border-border">
              <p class="text-xs text-muted-foreground">
                Need help? 
                <a href="mailto:support@example.com" class="text-foreground hover:underline">Contact Support</a>
              </p>
            </div>
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
interface Product {
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
  order_number: string
  total_amount: number
  payment_method: string
  created_at: string
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
</script>
