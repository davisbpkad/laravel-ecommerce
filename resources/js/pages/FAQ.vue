<template>
  <EcommerceLayout title="FAQ">
    <div class="min-h-screen bg-background">
      <!-- Hero Section -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-16">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-foreground mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-muted-foreground max-w-2xl mx-auto mb-8">
              Find quick answers to the most common questions about shopping with E-Shop.
            </p>
            
            <!-- Search FAQ -->
            <div class="max-w-md mx-auto">
              <div class="relative">
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search FAQ..."
                  class="w-full pl-12 pr-4 py-3 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                />
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
          <!-- FAQ Categories -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8 text-center">Browse by Category</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <button 
                v-for="category in categories" 
                :key="category.id"
                @click="selectedCategory = category.id"
                :class="[
                  'text-left p-4 border-2 border-border rounded-[5px] transition-all duration-200',
                  selectedCategory === category.id 
                    ? 'bg-primary text-primary-foreground shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]' 
                    : 'bg-card text-card-foreground shadow-[2px_2px_0px_0px_rgba(0,0,0,0.3)] hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]'
                ]"
              >
                <div class="text-2xl mb-2">{{ category.icon }}</div>
                <h3 class="font-semibold mb-1">{{ category.name }}</h3>
                <p class="text-sm opacity-80">{{ category.count }} questions</p>
              </button>
            </div>
          </div>

          <!-- FAQ List -->
          <div class="space-y-4">
            <template v-for="faq in filteredFAQs" :key="faq.id">
              <details class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
                <summary class="p-6 cursor-pointer font-semibold text-card-foreground hover:bg-background transition-colors">
                  <span class="text-sm text-primary font-medium mr-2">[{{ getCategoryName(faq.category) }}]</span>
                  {{ faq.question }}
                </summary>
                <div class="px-6 pb-6 text-muted-foreground border-t border-border pt-4">
                  <div v-html="faq.answer"></div>
                </div>
              </details>
            </template>
          </div>

          <!-- Still Need Help -->
          <div class="mt-16 bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-8 text-center">
            <h2 class="text-2xl font-bold text-card-foreground mb-4">Still Need Help?</h2>
            <p class="text-muted-foreground mb-6">
              Can't find what you're looking for? Our support team is here to help.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
              <Link href="/contact">
                <button class="bg-primary text-primary-foreground font-medium py-3 px-6 rounded-[5px] border-2 border-border shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200">
                  Contact Support
                </button>
              </Link>
              <Link href="/help">
                <button class="bg-background text-foreground font-medium py-3 px-6 rounded-[5px] border-2 border-border shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200">
                  Visit Help Center
                </button>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'

const searchQuery = ref('')
const selectedCategory = ref('all')

const categories = [
  { id: 'all', name: 'All Questions', icon: '📋', count: 25 },
  { id: 'orders', name: 'Orders & Shipping', icon: '📦', count: 8 },
  { id: 'returns', name: 'Returns & Refunds', icon: '🔄', count: 6 },
  { id: 'payment', name: 'Payment & Billing', icon: '💳', count: 5 },
  { id: 'account', name: 'Account & Profile', icon: '👤', count: 4 },
  { id: 'technical', name: 'Technical Issues', icon: '🔧', count: 2 }
]

const faqs = [
  // Orders & Shipping
  {
    id: 1,
    category: 'orders',
    question: 'How can I track my order?',
    answer: `You can track your order by logging into your account and going to "My Orders". Click on the order you want to track and you'll see real-time updates. You'll also receive email and SMS notifications with tracking information.`
  },
  {
    id: 2,
    category: 'orders',
    question: 'What are your shipping options and costs?',
    answer: `We offer several shipping options:
    <ul class="list-disc list-inside mt-2 space-y-1">
      <li><strong>Standard Shipping:</strong> FREE on orders over Rp 100,000 (3-5 business days)</li>
      <li><strong>Express Shipping:</strong> Rp 25,000 (1-2 business days)</li>
      <li><strong>Same Day Delivery:</strong> Rp 50,000 (available in major cities)</li>
    </ul>`
  },
  {
    id: 3,
    category: 'orders',
    question: 'Can I change or cancel my order?',
    answer: `You can cancel or modify your order within 1 hour of placing it, provided it hasn't been processed yet. Go to "My Orders" and click "Cancel Order" or contact our customer service immediately.`
  },
  {
    id: 4,
    category: 'orders',
    question: 'Do you ship internationally?',
    answer: `Currently, we only ship within Indonesia. We're working on expanding our shipping services to other countries in Southeast Asia. Stay tuned for updates!`
  },
  {
    id: 5,
    category: 'orders',
    question: 'What happens if no one is home for delivery?',
    answer: `Our delivery partner will attempt delivery up to 3 times. If unsuccessful, the package will be held at a nearby pickup point for 7 days. You'll receive notifications before each delivery attempt.`
  },
  {
    id: 6,
    category: 'orders',
    question: 'How accurate are your delivery estimates?',
    answer: `Our delivery estimates are accurate 95% of the time. Delays may occur due to weather conditions, public holidays, or high order volumes during promotional periods.`
  },
  {
    id: 7,
    category: 'orders',
    question: 'Can I specify a delivery time?',
    answer: `For Same Day Delivery in major cities, you can choose morning (9 AM - 12 PM) or afternoon (1 PM - 6 PM) delivery windows. Standard and Express shipping don't offer specific time slots.`
  },
  {
    id: 8,
    category: 'orders',
    question: 'What if my order arrives damaged?',
    answer: `If your order arrives damaged, contact us immediately with photos of the damage. We'll provide a full refund or replacement at no cost to you, including return shipping.`
  },

  // Returns & Refunds
  {
    id: 9,
    category: 'returns',
    question: 'What is your return policy?',
    answer: `We offer 30-day returns on most items. Items must be in original condition with tags attached. Some items like personal care products and custom items cannot be returned. <a href="/returns" class="text-primary hover:underline">View full return policy</a>`
  },
  {
    id: 10,
    category: 'returns',
    question: 'How do I return an item?',
    answer: `Go to "My Orders", select the item to return, choose your reason, and we'll email you a prepaid return label. Pack the item securely and drop it off at any post office.`
  },
  {
    id: 11,
    category: 'returns',
    question: 'How long does it take to get my refund?',
    answer: `Once we receive your return, we'll process it within 1-2 business days. Refunds are issued to your original payment method within 3-5 business days after processing.`
  },
  {
    id: 12,
    category: 'returns',
    question: 'Can I return sale items?',
    answer: `Yes, sale items can be returned within 30 days under the same conditions as regular-priced items, unless marked as "Final Sale".`
  },
  {
    id: 13,
    category: 'returns',
    question: 'Do you offer exchanges?',
    answer: `Yes! We offer free size exchanges for clothing items within 30 days. For other exchanges, you may need to return the item and place a new order.`
  },
  {
    id: 14,
    category: 'returns',
    question: 'What if I received the wrong item?',
    answer: `If you received the wrong item, contact us immediately. We'll provide a prepaid return label and send you the correct item at no additional cost.`
  },

  // Payment & Billing
  {
    id: 15,
    category: 'payment',
    question: 'What payment methods do you accept?',
    answer: `We accept:
    <ul class="list-disc list-inside mt-2 space-y-1">
      <li>Credit/Debit Cards (Visa, Mastercard, JCB)</li>
      <li>Bank Transfer (BCA, Mandiri, BNI, BRI)</li>
      <li>E-Wallets (OVO, GoPay, DANA)</li>
      <li>Cash on Delivery (selected areas)</li>
    </ul>`
  },
  {
    id: 16,
    category: 'payment',
    question: 'Is my payment information secure?',
    answer: `Yes, we use industry-standard SSL encryption and work with trusted payment processors. We never store your complete credit card information on our servers.`
  },
  {
    id: 17,
    category: 'payment',
    question: 'Why was my payment declined?',
    answer: `Payment can be declined for several reasons: insufficient funds, incorrect card details, bank security measures, or card restrictions. Contact your bank or try a different payment method.`
  },
  {
    id: 18,
    category: 'payment',
    question: 'Can I pay in installments?',
    answer: `Yes, we offer installment payments through selected credit cards and e-wallet services for purchases over Rp 500,000. Options will be shown at checkout.`
  },
  {
    id: 19,
    category: 'payment',
    question: 'When will I be charged for my order?',
    answer: `Your payment is processed immediately when you place your order. For Cash on Delivery, you'll pay when your order is delivered.`
  },

  // Account & Profile
  {
    id: 20,
    category: 'account',
    question: 'How do I create an account?',
    answer: `Click "Register" at the top of any page, enter your email, create a password, and verify your email address. You can also create an account during checkout.`
  },
  {
    id: 21,
    category: 'account',
    question: 'I forgot my password. How do I reset it?',
    answer: `Click "Forgot Password" on the login page, enter your email address, and we'll send you a password reset link. Follow the instructions in the email to create a new password.`
  },
  {
    id: 22,
    category: 'account',
    question: 'Can I change my email address?',
    answer: `Yes, go to "My Account" > "Profile Settings" to update your email address. You'll need to verify the new email address before the change takes effect.`
  },
  {
    id: 23,
    category: 'account',
    question: 'How do I delete my account?',
    answer: `To delete your account, contact our customer service team. Note that this action is permanent and cannot be undone. Your order history will be preserved for legal requirements.`
  },

  // Technical Issues
  {
    id: 24,
    category: 'technical',
    question: 'The website is not working properly. What should I do?',
    answer: `Try clearing your browser cache and cookies, or try a different browser. If the problem persists, contact our technical support team with details about the issue and your browser/device information.`
  },
  {
    id: 25,
    category: 'technical',
    question: 'Can I shop on mobile devices?',
    answer: `Yes! Our website is fully optimized for mobile devices. You can also download our mobile app from the App Store or Google Play Store for the best mobile shopping experience.`
  }
]

const filteredFAQs = computed(() => {
  let filtered = faqs

  // Filter by category
  if (selectedCategory.value !== 'all') {
    filtered = filtered.filter(faq => faq.category === selectedCategory.value)
  }

  // Filter by search query
  if (searchQuery.value.trim()) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(faq => 
      faq.question.toLowerCase().includes(query) || 
      faq.answer.toLowerCase().includes(query)
    )
  }

  return filtered
})

const getCategoryName = (categoryId: string) => {
  const category = categories.find(cat => cat.id === categoryId)
  return category ? category.name : 'General'
}
</script>
