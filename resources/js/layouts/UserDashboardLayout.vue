<template>
  <div class="min-h-screen bg-background">
    <!-- Navigation Header -->
    <nav class="bg-card border-b-2 border-border sticky top-0 z-50">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <!-- Logo and Brand -->
          <div class="flex items-center space-x-4">
            <Link href="/" class="flex items-center space-x-2">
              <div class="w-8 h-8 bg-primary rounded-[5px] flex items-center justify-center">
                <span class="text-primary-foreground font-bold text-sm">🛒</span>
              </div>
              <span class="font-bold text-lg text-foreground">E-Shop</span>
            </Link>
            
            <!-- Dashboard Title -->
            <div class="hidden md:block">
              <span class="text-muted-foreground mx-2">/</span>
              <span class="text-foreground font-medium">Dashboard</span>
            </div>
          </div>

          <!-- User Menu -->
          <div class="flex items-center space-x-4">
            <!-- Search -->
            <div class="hidden lg:block">
              <div class="relative">
                <input
                  type="text"
                  placeholder="Search products..."
                  class="pl-8 pr-4 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring w-64"
                />
                <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>

            <!-- Cart -->
            <Link href="/cart" class="relative">
              <Button variant="outline" size="sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
                </svg>
                Cart
                <span v-if="cartCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                  {{ cartCount }}
                </span>
              </Button>
            </Link>

            <!-- User Profile Dropdown -->
            <div class="relative">
              <button @click="showUserMenu = !showUserMenu" class="flex items-center space-x-2 text-card-foreground hover:text-primary transition-colors">
                <div v-if="$page.props.auth.user.avatar" class="w-8 h-8 rounded-full border-2 border-border overflow-hidden">
                  <img :src="$page.props.auth.user.avatar" :alt="$page.props.auth.user.name" class="w-full h-full object-cover" />
                </div>
                <div v-else class="w-8 h-8 rounded-full border-2 border-border bg-muted flex items-center justify-center">
                  <svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <span class="hidden sm:block">{{ $page.props.auth.user.name }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              
              <!-- Dropdown Menu -->
              <div v-show="showUserMenu" class="absolute right-0 mt-2 w-48 bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] z-50">
                <div class="py-2">
                  <Link href="/dashboard" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v0a2 2 0 012-2h10a2 2 0 012 2v0" />
                    </svg>
                    Dashboard
                  </Link>
                  <Link href="/orders" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    My Orders
                  </Link>
                  <Link href="/settings/profile" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                  </Link>
                  <hr class="my-2 border-border">
                  <Link href="/" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Back to Shop
                  </Link>
                  <Link href="/logout" method="post" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Sidebar for larger screens -->
    <div class="flex">
      <!-- Sidebar Navigation -->
      <aside class="hidden lg:block w-64 bg-card border-r-2 border-border h-[calc(100vh-4rem)] sticky top-16">
        <div class="p-6">
          <div class="space-y-2">
            <!-- Dashboard Overview -->
            <div class="mb-6">
              <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-3">Overview</h3>
              <Link href="/dashboard" :class="currentRoute === 'dashboard' ? 'bg-primary text-primary-foreground' : 'text-card-foreground hover:bg-background'" class="flex items-center space-x-3 px-3 py-2 rounded-[5px] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v0a2 2 0 012-2h10a2 2 0 012 2v0" />
                </svg>
                <span>Dashboard</span>
              </Link>
            </div>

            <!-- Shopping -->
            <div class="mb-6">
              <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-3">Shopping</h3>
              <div class="space-y-1">
                <Link href="/products" class="flex items-center space-x-3 px-3 py-2 rounded-[5px] text-card-foreground hover:bg-background transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
                  <span>Browse Products</span>
                </Link>
                <Link href="/cart" class="flex items-center space-x-3 px-3 py-2 rounded-[5px] text-card-foreground hover:bg-background transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
                  </svg>
                  <span>Shopping Cart</span>
                  <span v-if="cartCount > 0" class="bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center ml-auto">
                    {{ cartCount }}
                  </span>
                </Link>
              </div>
            </div>

            <!-- Orders -->
            <div class="mb-6">
              <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-3">Orders</h3>
              <div class="space-y-1">
                <Link href="/orders" :class="currentRoute === 'orders.index' ? 'bg-primary text-primary-foreground' : 'text-card-foreground hover:bg-background'" class="flex items-center space-x-3 px-3 py-2 rounded-[5px] transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  <span>My Orders</span>
                </Link>
                <Link href="/orders/track" class="flex items-center space-x-3 px-3 py-2 rounded-[5px] text-card-foreground hover:bg-background transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span>Track Orders</span>
                </Link>
              </div>
            </div>

            <!-- Account -->
            <div class="mb-6">
              <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider mb-3">Account</h3>
            <div class="space-y-1 flex flex-col">
                <Link href="/settings/profile" :class="currentRoute === '/settings/profile' ? 'bg-primary text-primary-foreground' : 'text-card-foreground hover:bg-background'" class="flex items-center justify-between px-3 py-2 rounded-[5px] transition-colors">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Profile Settings asd</span>
                    </div>
                </Link>
                <Link href="/settings/password" :class="currentRoute === '/settings/password' ? 'bg-primary text-primary-foreground' : 'text-card-foreground hover:bg-background'" class="flex items-center justify-between px-3 py-2 rounded-[5px] transition-colors">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Password</span>
                    </div>
                </Link>
            </div>
            </div>
          </div>
        </div>
      </aside>

      <!-- Main Content -->
      <main class="flex-1 min-h-[calc(100vh-4rem)]">
        <div class="container mx-auto px-4 py-6 lg:px-6">
          <slot />
        </div>
      </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-card border-t-2 border-border z-40">
      <div class="grid grid-cols-5 h-16">
        <Link href="/dashboard" :class="currentRoute === 'dashboard' ? 'text-primary' : 'text-muted-foreground'" class="flex flex-col items-center justify-center space-y-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v0a2 2 0 012-2h10a2 2 0 012 2v0" />
          </svg>
          <span class="text-xs">Dashboard</span>
        </Link>
        
        <Link href="/products" class="flex flex-col items-center justify-center space-y-1 text-muted-foreground">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
          <span class="text-xs">Products</span>
        </Link>
        
        <Link href="/cart" class="flex flex-col items-center justify-center space-y-1 text-muted-foreground relative">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
          </svg>
          <span class="text-xs">Cart</span>
          <span v-if="cartCount > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">
            {{ cartCount }}
          </span>
        </Link>
        
        <Link href="/orders" :class="currentRoute === 'orders.index' ? 'text-primary' : 'text-muted-foreground'" class="flex flex-col items-center justify-center space-y-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
          </svg>
          <span class="text-xs">Orders</span>
        </Link>
        
        <Link href="/settings/profile" :class="currentRoute === 'profile.edit' ? 'text-primary' : 'text-muted-foreground'" class="flex flex-col items-center justify-center space-y-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
          <span class="text-xs">Profile</span>
        </Link>
      </div>
    </nav>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import Button from '@/components/ui/button/Button.vue'

interface Props {
  title?: string
  cartCount?: number
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Dashboard',
  cartCount: 0
})

const showUserMenu = ref(false)
const page = usePage()

const currentRoute = computed(() => {
  if (page.props.ziggy?.location) {
    return new URL(page.props.ziggy.location).pathname
  }
  return page.url || ''
})

// Close user menu when clicking outside
const closeUserMenu = () => {
  showUserMenu.value = false
}

// Add click outside listener
if (typeof window !== 'undefined') {
  document.addEventListener('click', (e) => {
    const target = e.target as HTMLElement
    if (!target.closest('.relative')) {
      closeUserMenu()
    }
  })
}
</script>

<style scoped>
/* Add padding bottom for mobile navigation */
@media (max-width: 1023px) {
  main {
    padding-bottom: 4rem;
  }
}
</style>
