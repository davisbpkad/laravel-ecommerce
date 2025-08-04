<template>
  <EcommerceLayout title="Shipping Information">
    <div class="min-h-screen bg-background">
      <!-- Hero Section -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-16">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-foreground mb-4">Shipping Information</h1>
            <p class="text-xl text-muted-foreground max-w-2xl mx-auto">
              Learn about our shipping options, delivery times, and policies.
            </p>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
          <!-- Shipping Options -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">Shipping Options</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="flex items-center mb-4">
                  <div class="text-3xl mr-4">🚚</div>
                  <div>
                    <h3 class="text-xl font-semibold text-card-foreground">Standard Shipping</h3>
                    <p class="text-primary font-medium">FREE on orders over Rp 100,000</p>
                  </div>
                </div>
                <ul class="space-y-2 text-muted-foreground">
                  <li>• Delivery: 3-5 business days</li>
                  <li>• Cost: Rp 15,000 (orders under Rp 100,000)</li>
                  <li>• Available nationwide</li>
                  <li>• Tracking included</li>
                </ul>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="flex items-center mb-4">
                  <div class="text-3xl mr-4">⚡</div>
                  <div>
                    <h3 class="text-xl font-semibold text-card-foreground">Express Shipping</h3>
                    <p class="text-primary font-medium">Rp 25,000</p>
                  </div>
                </div>
                <ul class="space-y-2 text-muted-foreground">
                  <li>• Delivery: 1-2 business days</li>
                  <li>• Available in major cities</li>
                  <li>• Priority handling</li>
                  <li>• Real-time tracking</li>
                </ul>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="flex items-center mb-4">
                  <div class="text-3xl mr-4">🏃</div>
                  <div>
                    <h3 class="text-xl font-semibold text-card-foreground">Same Day Delivery</h3>
                    <p class="text-primary font-medium">Rp 50,000</p>
                  </div>
                </div>
                <ul class="space-y-2 text-muted-foreground">
                  <li>• Delivery: Same day (order before 2 PM)</li>
                  <li>• Available in Jakarta, Surabaya, Bandung</li>
                  <li>• Monday - Saturday only</li>
                  <li>• Live GPS tracking</li>
                </ul>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="flex items-center mb-4">
                  <div class="text-3xl mr-4">📍</div>
                  <div>
                    <h3 class="text-xl font-semibold text-card-foreground">Pickup Points</h3>
                    <p class="text-primary font-medium">FREE</p>
                  </div>
                </div>
                <ul class="space-y-2 text-muted-foreground">
                  <li>• Pick up at partner locations</li>
                  <li>• Available nationwide</li>
                  <li>• Hold for 7 days</li>
                  <li>• SMS notification when ready</li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Delivery Areas -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">Delivery Areas</h2>
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                  <h3 class="text-lg font-semibold text-card-foreground mb-4">🌟 Metro Areas</h3>
                  <p class="text-sm text-muted-foreground mb-2">All shipping options available</p>
                  <ul class="text-sm text-muted-foreground space-y-1">
                    <li>• Jakarta & Greater Jakarta</li>
                    <li>• Surabaya & Sidoarjo</li>
                    <li>• Bandung & Cimahi</li>
                    <li>• Medan & Deli Serdang</li>
                  </ul>
                </div>

                <div>
                  <h3 class="text-lg font-semibold text-card-foreground mb-4">🏙️ Major Cities</h3>
                  <p class="text-sm text-muted-foreground mb-2">Standard & Express shipping</p>
                  <ul class="text-sm text-muted-foreground space-y-1">
                    <li>• Yogyakarta</li>
                    <li>• Semarang</li>
                    <li>• Malang</li>
                    <li>• Denpasar</li>
                    <li>• Makassar</li>
                  </ul>
                </div>

                <div>
                  <h3 class="text-lg font-semibold text-card-foreground mb-4">🌍 Other Areas</h3>
                  <p class="text-sm text-muted-foreground mb-2">Standard shipping only</p>
                  <ul class="text-sm text-muted-foreground space-y-1">
                    <li>• All other Indonesian cities</li>
                    <li>• Remote areas (additional 1-2 days)</li>
                    <li>• Pickup points available</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Processing Time -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">Order Processing</h2>
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                  <h3 class="text-lg font-semibold text-card-foreground mb-4">⏰ Processing Times</h3>
                  <ul class="space-y-3 text-muted-foreground">
                    <li class="flex items-center">
                      <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                      <span><strong>In-stock items:</strong> 1-2 business days</span>
                    </li>
                    <li class="flex items-center">
                      <span class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></span>
                      <span><strong>Pre-order items:</strong> 5-10 business days</span>
                    </li>
                    <li class="flex items-center">
                      <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                      <span><strong>Custom items:</strong> 10-15 business days</span>
                    </li>
                  </ul>
                </div>

                <div>
                  <h3 class="text-lg font-semibold text-card-foreground mb-4">📅 Cut-off Times</h3>
                  <ul class="space-y-3 text-muted-foreground">
                    <li>
                      <strong>Same Day Delivery:</strong> Order before 2:00 PM
                    </li>
                    <li>
                      <strong>Next Day Delivery:</strong> Order before 6:00 PM
                    </li>
                    <li>
                      <strong>Weekend Orders:</strong> Processed on Monday
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Tracking -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">Order Tracking</h2>
            <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                  <h3 class="text-lg font-semibold text-card-foreground mb-4">📱 How to Track</h3>
                  <ol class="space-y-2 text-muted-foreground">
                    <li>1. Go to "My Orders" in your account</li>
                    <li>2. Find your order and click "Track"</li>
                    <li>3. View real-time status updates</li>
                    <li>4. Get SMS/email notifications</li>
                  </ol>
                </div>

                <div>
                  <h3 class="text-lg font-semibold text-card-foreground mb-4">📊 Tracking Statuses</h3>
                  <ul class="space-y-2 text-muted-foreground">
                    <li><span class="font-medium">Order Confirmed:</span> Payment received</li>
                    <li><span class="font-medium">Processing:</span> Preparing your items</li>
                    <li><span class="font-medium">Shipped:</span> On the way to you</li>
                    <li><span class="font-medium">Delivered:</span> Successfully delivered</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Shipping Policy -->
          <div class="mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-8">Shipping Policy</h2>
            <div class="space-y-6">
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h3 class="text-lg font-semibold text-card-foreground mb-3">📦 Packaging</h3>
                <p class="text-muted-foreground">
                  All items are carefully packaged with protective materials to ensure they arrive in perfect condition. 
                  We use eco-friendly packaging whenever possible and include all necessary documentation.
                </p>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h3 class="text-lg font-semibold text-card-foreground mb-3">🛡️ Insurance</h3>
                <p class="text-muted-foreground">
                  All shipments are automatically insured up to Rp 1,000,000. For higher value items, 
                  additional insurance is included at no extra cost. Claims can be filed within 7 days of delivery.
                </p>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h3 class="text-lg font-semibold text-card-foreground mb-3">📍 Address Requirements</h3>
                <p class="text-muted-foreground">
                  Please ensure your shipping address is complete and accurate. Include apartment/unit numbers, 
                  building names, and local landmarks if helpful. We cannot deliver to PO Boxes for security reasons.
                </p>
              </div>

              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h3 class="text-lg font-semibold text-card-foreground mb-3">🔒 Delivery Confirmation</h3>
                <p class="text-muted-foreground">
                  Someone must be available to receive the package. If no one is available, we'll attempt delivery 
                  up to 3 times before returning to our facility. You can also redirect to a pickup point.
                </p>
              </div>
            </div>
          </div>

          <!-- FAQ Section -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-8">
            <h2 class="text-3xl font-bold text-card-foreground mb-6 text-center">Shipping FAQ</h2>
            <div class="space-y-4">
              <details class="border-b border-border pb-4">
                <summary class="font-semibold text-card-foreground cursor-pointer">
                  Can I change my shipping address after placing an order?
                </summary>
                <p class="text-muted-foreground mt-2">
                  You can change your shipping address within 1 hour of placing your order, provided it hasn't been processed yet. 
                  Contact our customer service immediately if you need to make changes.
                </p>
              </details>

              <details class="border-b border-border pb-4">
                <summary class="font-semibold text-card-foreground cursor-pointer">
                  What happens if I'm not home during delivery?
                </summary>
                <p class="text-muted-foreground mt-2">
                  Our delivery partner will attempt delivery up to 3 times. You'll receive notifications before each attempt. 
                  If unsuccessful, the package will be held at a nearby pickup point for 7 days.
                </p>
              </details>

              <details class="border-b border-border pb-4">
                <summary class="font-semibold text-card-foreground cursor-pointer">
                  Do you ship internationally?
                </summary>
                <p class="text-muted-foreground mt-2">
                  Currently, we only ship within Indonesia. We're working on expanding our shipping services to other countries in Southeast Asia.
                </p>
              </details>

              <details class="pb-4">
                <summary class="font-semibold text-card-foreground cursor-pointer">
                  How accurate are the delivery time estimates?
                </summary>
                <p class="text-muted-foreground mt-2">
                  Our delivery estimates are accurate 95% of the time. Delays may occur due to weather conditions, 
                  public holidays, or high order volumes during promotional periods.
                </p>
              </details>
            </div>

            <div class="text-center mt-8">
              <p class="text-muted-foreground mb-4">Still have questions about shipping?</p>
              <Link href="/contact">
                <button class="bg-primary text-primary-foreground font-medium py-3 px-6 rounded-[5px] border-2 border-border shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200">
                  Contact Support
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
import { Link } from '@inertiajs/vue3'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
</script>
