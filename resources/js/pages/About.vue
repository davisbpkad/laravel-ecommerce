<template>
  <EcommerceLayout title="About Us">
    <div class="min-h-screen bg-background">
      <!-- Hero Section -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-16">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-foreground mb-4">About E-Shop</h1>
            <p class="text-xl text-muted-foreground max-w-2xl mx-auto">
              Your trusted online marketplace for quality products at amazing prices since 2020.
            </p>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
          <!-- Our Story -->
          <div class="mb-16">
            <h2 class="text-3xl font-bold text-foreground mb-6">Our Story</h2>
            <div class="prose prose-lg max-w-none">
              <p class="text-muted-foreground leading-relaxed mb-4">
                E-Shop was founded with a simple mission: to make quality products accessible to everyone, everywhere. 
                What started as a small family business has grown into one of Indonesia's most trusted online marketplaces.
              </p>
              <p class="text-muted-foreground leading-relaxed mb-4">
                We believe that shopping should be convenient, secure, and enjoyable. That's why we've built a platform 
                that not only offers great products at competitive prices but also provides exceptional customer service 
                and a seamless shopping experience.
              </p>
              <p class="text-muted-foreground leading-relaxed">
                Today, we serve thousands of customers across Indonesia, partnering with hundreds of trusted sellers 
                to bring you the best products from electronics to fashion, home goods to beauty products.
              </p>
            </div>
          </div>

          <!-- Our Values -->
          <div class="mb-16">
            <h2 class="text-3xl font-bold text-foreground mb-8">Our Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="text-4xl mb-4">🛡️</div>
                <h3 class="text-xl font-semibold text-card-foreground mb-3">Trust & Security</h3>
                <p class="text-muted-foreground">
                  We prioritize the security of your personal information and ensure all transactions are safe and secure.
                </p>
              </div>
              
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="text-4xl mb-4">⚡</div>
                <h3 class="text-xl font-semibold text-card-foreground mb-3">Fast & Reliable</h3>
                <p class="text-muted-foreground">
                  Quick delivery, reliable service, and prompt customer support whenever you need assistance.
                </p>
              </div>
              
              <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <div class="text-4xl mb-4">💎</div>
                <h3 class="text-xl font-semibold text-card-foreground mb-3">Quality Products</h3>
                <p class="text-muted-foreground">
                  We carefully curate our product selection to ensure you get the best quality at competitive prices.
                </p>
              </div>
            </div>
          </div>

          <!-- Team Section -->
          <div class="mb-16">
            <h2 class="text-3xl font-bold text-foreground mb-8">Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                  AS
                </div>
                <h3 class="text-xl font-semibold text-card-foreground mb-2">Ahmad Santoso</h3>
                <p class="text-muted-foreground mb-2">Founder & CEO</p>
                <p class="text-sm text-muted-foreground">
                  Leading the vision and strategy to make E-Shop the best online marketplace in Indonesia.
                </p>
              </div>
              
              <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-r from-green-500 to-teal-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                  SR
                </div>
                <h3 class="text-xl font-semibold text-card-foreground mb-2">Sari Rahayu</h3>
                <p class="text-muted-foreground mb-2">Head of Operations</p>
                <p class="text-sm text-muted-foreground">
                  Ensuring smooth operations and excellent customer experience across all touchpoints.
                </p>
              </div>
              
              <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-r from-orange-500 to-red-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                  BW
                </div>
                <h3 class="text-xl font-semibold text-card-foreground mb-2">Budi Wijaya</h3>
                <p class="text-muted-foreground mb-2">Head of Technology</p>
                <p class="text-sm text-muted-foreground">
                  Building and maintaining the technology that powers our platform and user experience.
                </p>
              </div>
            </div>
          </div>

          <!-- Statistics -->
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-8">
            <h2 class="text-3xl font-bold text-card-foreground mb-8 text-center">E-Shop by Numbers</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
              <div class="text-center">
                <div class="text-3xl font-bold text-primary mb-2">50K+</div>
                <p class="text-muted-foreground">Happy Customers</p>
              </div>
              <div class="text-center">
                <div class="text-3xl font-bold text-primary mb-2">10K+</div>
                <p class="text-muted-foreground">Products Available</p>
              </div>
              <div class="text-center">
                <div class="text-3xl font-bold text-primary mb-2">500+</div>
                <p class="text-muted-foreground">Trusted Sellers</p>
              </div>
              <div class="text-center">
                <div class="text-3xl font-bold text-primary mb-2">99.9%</div>
                <p class="text-muted-foreground">Uptime Guarantee</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
</script>
