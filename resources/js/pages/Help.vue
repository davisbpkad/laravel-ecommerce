<template>
  <EcommerceLayout title="Help Center">
    <div class="min-h-screen bg-background">
      <!-- Hero Section -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-16">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-foreground mb-4">Help Center</h1>
            <p class="text-xl text-muted-foreground max-w-2xl mx-auto mb-8">
              Find answers to common questions and get the help you need.
            </p>
            
            <!-- Search -->
            <div class="max-w-md mx-auto">
              <div class="relative">
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search for help..."
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
        <div class="max-w-6xl mx-auto">
          <!-- Popular Topics -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8 text-center">Popular Topics</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 cursor-pointer">
                <div class="text-4xl mb-4">📦</div>
                <h3 class="text-xl font-semibold text-card-foreground mb-3">Order & Shipping</h3>
                <p class="text-muted-foreground mb-4">
                  Track your orders, understand shipping times, and learn about delivery options.
                </p>
                <Link href="/shipping" class="text-primary hover:underline font-medium">
                  Learn More →
                </Link>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 cursor-pointer">
                <div class="text-4xl mb-4">🔄</div>
                <h3 class="text-xl font-semibold text-card-foreground mb-3">Returns & Refunds</h3>
                <p class="text-muted-foreground mb-4">
                  Easy returns process, refund policies, and how to initiate a return.
                </p>
                <Link href="/returns" class="text-primary hover:underline font-medium">
                  Learn More →
                </Link>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 cursor-pointer">
                <div class="text-4xl mb-4">💳</div>
                <h3 class="text-xl font-semibold text-card-foreground mb-3">Payment Methods</h3>
                <p class="text-muted-foreground mb-4">
                  Accepted payment methods, security measures, and payment troubleshooting.
                </p>
                <button class="text-primary hover:underline font-medium">
                  Learn More →
                </button>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 cursor-pointer">
                <div class="text-4xl mb-4">👤</div>
                <h3 class="text-xl font-semibold text-card-foreground mb-3">Account Management</h3>
                <p class="text-muted-foreground mb-4">
                  Manage your profile, update information, and security settings.
                </p>
                <button class="text-primary hover:underline font-medium">
                  Learn More →
                </button>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 cursor-pointer">
                <div class="text-4xl mb-4">🛍️</div>
                <h3 class="text-xl font-semibold text-card-foreground mb-3">Shopping Guide</h3>
                <p class="text-muted-foreground mb-4">
                  How to find products, use filters, and make the most of your shopping experience.
                </p>
                <button class="text-primary hover:underline font-medium">
                  Learn More →
                </button>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 cursor-pointer">
                <div class="text-4xl mb-4">🔧</div>
                <h3 class="text-xl font-semibold text-card-foreground mb-3">Technical Support</h3>
                <p class="text-muted-foreground mb-4">
                  Website issues, app problems, and technical troubleshooting.
                </p>
                <button class="text-primary hover:underline font-medium">
                  Learn More →
                </button>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8 text-center">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
              <Link href="/orders">
                <button class="w-full bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 text-left">
                  <div class="text-2xl mb-2">📋</div>
                  <h3 class="font-semibold text-card-foreground mb-1">Track Order</h3>
                  <p class="text-sm text-muted-foreground">Check your order status</p>
                </button>
              </Link>

              <Link href="/contact">
                <button class="w-full bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 text-left">
                  <div class="text-2xl mb-2">💬</div>
                  <h3 class="font-semibold text-card-foreground mb-1">Contact Us</h3>
                  <p class="text-sm text-muted-foreground">Get in touch with support</p>
                </button>
              </Link>

              <button class="w-full bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 text-left">
                <div class="text-2xl mb-2">🔄</div>
                <h3 class="font-semibold text-card-foreground mb-1">Return Item</h3>
                <p class="text-sm text-muted-foreground">Start a return process</p>
              </button>

              <Link href="/faq">
                <button class="w-full bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 text-left">
                  <div class="text-2xl mb-2">❓</div>
                  <h3 class="font-semibold text-card-foreground mb-1">View FAQ</h3>
                  <p class="text-sm text-muted-foreground">Browse common questions</p>
                </button>
              </Link>
            </div>
          </div>

          <!-- Contact Options -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-8">
            <h2 class="text-3xl font-bold text-card-foreground mb-6 text-center">Still Need Help?</h2>
            <p class="text-center text-muted-foreground mb-8">
              Our support team is here to help you with any questions or concerns.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="text-center">
                <div class="text-4xl mb-4">📧</div>
                <h3 class="text-lg font-semibold text-card-foreground mb-2">Email Support</h3>
                <p class="text-muted-foreground mb-4">
                  Response within 24 hours
                </p>
                <a href="mailto:support@eshop.com" class="text-primary hover:underline font-medium">
                  support@eshop.com
                </a>
              </div>

              <div class="text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-lg font-semibold text-card-foreground mb-2">Phone Support</h3>
                <p class="text-muted-foreground mb-4">
                  Mon-Fri, 9AM-6PM WIB
                </p>
                <a href="tel:+6212345678901" class="text-primary hover:underline font-medium">
                  +62 123 456 7890
                </a>
              </div>

              <div class="text-center">
                <div class="text-4xl mb-4">💬</div>
                <h3 class="text-lg font-semibold text-card-foreground mb-2">Live Chat</h3>
                <p class="text-muted-foreground mb-4">
                  Available 24/7
                </p>
                <button class="text-primary hover:underline font-medium">
                  Start Chat
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'

const searchQuery = ref('')
</script>
