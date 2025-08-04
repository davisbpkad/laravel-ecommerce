<template>
  <EcommerceLayout title="Returns & Refunds">
    <div class="min-h-screen bg-background">
      <!-- Hero Section -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-16">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-foreground mb-4">Returns & Refunds</h1>
            <p class="text-xl text-muted-foreground max-w-2xl mx-auto">
              Easy returns and hassle-free refunds. We want you to be completely satisfied with your purchase.
            </p>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
          <!-- Return Policy Overview -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">Return Policy Overview</h2>
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-8">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                  <div class="text-4xl mb-4">📅</div>
                  <h3 class="text-xl font-semibold text-card-foreground mb-2">30-Day Returns</h3>
                  <p class="text-muted-foreground">
                    Return most items within 30 days of delivery for a full refund.
                  </p>
                </div>

                <div class="text-center">
                  <div class="text-4xl mb-4">💸</div>
                  <h3 class="text-xl font-semibold text-card-foreground mb-2">Free Returns</h3>
                  <p class="text-muted-foreground">
                    No return shipping costs for defective or incorrect items.
                  </p>
                </div>

                <div class="text-center">
                  <div class="text-4xl mb-4">⚡</div>
                  <h3 class="text-xl font-semibold text-card-foreground mb-2">Quick Refunds</h3>
                  <p class="text-muted-foreground">
                    Get your money back within 3-5 business days after we receive your return.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- How to Return -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">How to Return an Item</h2>
            <div class="space-y-6">
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="flex items-start space-x-4">
                  <div class="bg-primary text-primary-foreground rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">1</div>
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-card-foreground mb-2">Start Your Return</h3>
                    <p class="text-muted-foreground mb-3">
                      Go to "My Orders" and select the item you want to return. Click "Return Item" and choose your reason.
                    </p>
                    <Link href="/orders" class="text-primary hover:underline font-medium">
                      Go to My Orders →
                    </Link>
                  </div>
                </div>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="flex items-start space-x-4">
                  <div class="bg-primary text-primary-foreground rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">2</div>
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-card-foreground mb-2">Print Return Label</h3>
                    <p class="text-muted-foreground">
                      We'll email you a prepaid return shipping label. Print it and attach it to your package. 
                      For defective or incorrect items, shipping is free!
                    </p>
                  </div>
                </div>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="flex items-start space-x-4">
                  <div class="bg-primary text-primary-foreground rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">3</div>
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-card-foreground mb-2">Package & Ship</h3>
                    <p class="text-muted-foreground">
                      Pack the item securely in its original packaging if possible. Drop it off at any post office 
                      or schedule a pickup from your home.
                    </p>
                  </div>
                </div>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="flex items-start space-x-4">
                  <div class="bg-primary text-primary-foreground rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">4</div>
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-card-foreground mb-2">Get Your Refund</h3>
                    <p class="text-muted-foreground">
                      Once we receive and process your return, your refund will be issued to your original payment method 
                      within 3-5 business days.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Return Conditions -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">Return Conditions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-green-50 border-2 border-green-200 rounded-[5px] shadow-[4px_4px_0px_0px_rgba(34,197,94,0.3)] p-6">
                <div class="flex items-center mb-4">
                  <div class="text-3xl mr-3">✅</div>
                  <h3 class="text-lg font-semibold text-green-800">Returnable Items</h3>
                </div>
                <ul class="space-y-2 text-green-700 text-sm">
                  <li>• Items in original, unopened packaging</li>
                  <li>• Clothing with tags still attached</li>
                  <li>• Electronics in working condition</li>
                  <li>• Books in sellable condition</li>
                  <li>• Home goods within 30 days</li>
                  <li>• Defective or damaged items</li>
                  <li>• Wrong items sent by mistake</li>
                </ul>
              </div>

              <div class="bg-red-50 border-2 border-red-200 rounded-[5px] shadow-[4px_4px_0px_0px_rgba(239,68,68,0.3)] p-6">
                <div class="flex items-center mb-4">
                  <div class="text-3xl mr-3">❌</div>
                  <h3 class="text-lg font-semibold text-red-800">Non-Returnable Items</h3>
                </div>
                <ul class="space-y-2 text-red-700 text-sm">
                  <li>• Personal care & hygiene products</li>
                  <li>• Perishable goods & food items</li>
                  <li>• Custom or personalized items</li>
                  <li>• Software & digital downloads</li>
                  <li>• Items damaged by misuse</li>
                  <li>• Items returned after 30 days</li>
                  <li>• Gift cards & vouchers</li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Refund Information -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">Refund Information</h2>
            <div class="space-y-6">
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h3 class="text-lg font-semibold text-card-foreground mb-4">💳 Refund Methods</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <h4 class="font-medium text-card-foreground mb-2">Original Payment Method</h4>
                    <ul class="text-muted-foreground text-sm space-y-1">
                      <li>• Credit/Debit Card: 3-5 business days</li>
                      <li>• Bank Transfer: 1-3 business days</li>
                      <li>• E-Wallet: 1-2 business days</li>
                    </ul>
                  </div>
                  <div>
                    <h4 class="font-medium text-card-foreground mb-2">Store Credit</h4>
                    <ul class="text-muted-foreground text-sm space-y-1">
                      <li>• Instant credit to your account</li>
                      <li>• Never expires</li>
                      <li>• Can be used for future purchases</li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h3 class="text-lg font-semibold text-card-foreground mb-4">💰 Refund Amounts</h3>
                <div class="space-y-3 text-muted-foreground">
                  <div class="flex justify-between items-center">
                    <span>Product price</span>
                    <span class="font-medium text-green-600">100% refunded</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span>Original shipping cost</span>
                    <span class="font-medium text-yellow-600">Non-refundable*</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span>Return shipping cost</span>
                    <span class="font-medium text-red-600">Deducted (unless our fault)</span>
                  </div>
                  <p class="text-xs text-muted-foreground mt-4">
                    *Except when the return is due to our error (wrong/defective item)
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Exchange Policy -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">Exchange Policy</h2>
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <h3 class="text-lg font-semibold text-card-foreground mb-4">🔄 Size Exchanges</h3>
                  <ul class="space-y-2 text-muted-foreground">
                    <li>• Free size exchanges for clothing</li>
                    <li>• Subject to availability</li>
                    <li>• Must be within 30 days</li>
                    <li>• Items must be unworn with tags</li>
                  </ul>
                </div>

                <div>
                  <h3 class="text-lg font-semibold text-card-foreground mb-4">🎨 Color/Style Exchanges</h3>
                  <ul class="space-y-2 text-muted-foreground">
                    <li>• Available for most products</li>
                    <li>• May require price adjustment</li>
                    <li>• Same return conditions apply</li>
                    <li>• Contact support for assistance</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- FAQ Section -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">Returns FAQ</h2>
            <div class="space-y-4">
              <details class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <summary class="font-semibold text-card-foreground cursor-pointer mb-3">
                  What if I received a defective item?
                </summary>
                <p class="text-muted-foreground">
                  If you received a defective item, we'll provide a full refund including all shipping costs. 
                  We'll also send you a prepaid return label at no charge. Contact us immediately with photos of the defect.
                </p>
              </details>

              <details class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <summary class="font-semibold text-card-foreground cursor-pointer mb-3">
                  Can I return sale items?
                </summary>
                <p class="text-muted-foreground">
                  Yes, sale items can be returned within 30 days under the same conditions as regular-priced items. 
                  However, final sale items marked "All Sales Final" cannot be returned unless defective.
                </p>
              </details>

              <details class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <summary class="font-semibold text-card-foreground cursor-pointer mb-3">
                  How long does the return process take?
                </summary>
                <p class="text-muted-foreground">
                  Once you ship your return, it typically takes 2-5 business days for us to receive it. 
                  We'll process your return within 1-2 business days, and your refund will be issued within 3-5 business days after that.
                </p>
              </details>

              <details class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <summary class="font-semibold text-card-foreground cursor-pointer mb-3">
                  What if I lost my receipt or order confirmation?
                </summary>
                <p class="text-muted-foreground">
                  No problem! You can find all your order information in your account under "My Orders". 
                  If you checked out as a guest, contact our support team with your email address and we'll help you locate your order.
                </p>
              </details>
            </div>
          </div>

          <!-- Contact Support -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-8 text-center">
            <h2 class="text-2xl font-bold text-card-foreground mb-4">Need Help with Your Return?</h2>
            <p class="text-muted-foreground mb-6">
              Our customer service team is here to help you with any questions about returns or refunds.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
              <Link href="/contact">
                <button class="bg-primary text-primary-foreground font-medium py-3 px-6 rounded-[5px] border-2 border-border shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200">
                  Contact Support
                </button>
              </Link>
              <a href="mailto:returns@eshop.com">
                <button class="bg-background text-foreground font-medium py-3 px-6 rounded-[5px] border-2 border-border shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200">
                  Email Returns Team
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
</script>
