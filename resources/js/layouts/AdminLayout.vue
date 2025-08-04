<template>
  <div class="min-h-screen bg-background">
    <!-- Admin Navigation Header -->
    <nav class="bg-card border-b-2 border-border sticky top-0 z-50">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <!-- Logo & Title -->
          <div class="flex items-center space-x-4">
            <Link href="/admin" class="text-xl font-bold text-foreground hover:text-primary transition-colors">
              🔧 Admin Panel
            </Link>
            <span class="text-sm text-muted-foreground hidden sm:block">E-Commerce Management</span>
          </div>

          <!-- Quick Actions -->
          <div class="hidden md:flex items-center space-x-4">
            <Link href="/admin/products/create">
              <Button variant="default" size="sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
              </Button>
            </Link>
            <Link href="/" target="_blank">
              <Button variant="outline" size="sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                View Store
              </Button>
            </Link>
          </div>

          <!-- User Menu -->
          <div class="flex items-center space-x-4">
            <div class="relative">
              <button @click="showUserMenu = !showUserMenu" class="flex items-center space-x-2 text-card-foreground hover:text-primary transition-colors">
                <span class="hidden sm:block">{{ $page.props.auth.user.name }}</span>
                <span class="text-xs bg-primary text-primary-foreground px-2 py-1 rounded-[3px]">Admin</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              
              <!-- Dropdown Menu -->
              <div v-show="showUserMenu" class="absolute right-0 mt-2 w-48 bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] z-50">
                <div class="py-2">
                  <Link href="/admin" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    Admin Dashboard
                  </Link>
                  <Link href="/admin/profile" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    Profile Settings
                  </Link>
                  <hr class="my-2 border-border">
                  <Link href="/" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    View Store
                  </Link>
                  <Link href="/logout" method="post" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    Logout
                  </Link>
                </div>
              </div>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="showMobileMenu = !showMobileMenu" class="md:hidden text-card-foreground">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <div class="flex">
      <!-- Sidebar -->
      <aside class="w-64 bg-card border-r-2 border-border min-h-screen sticky top-16 hidden lg:block">
        <div class="p-4">
          <!-- Dashboard -->
          <div class="mb-6">
            <h3 class="text-sm font-medium text-muted-foreground mb-2 uppercase tracking-wide">Dashboard</h3>
            <nav class="space-y-1">
              <Link href="/admin" class="flex items-center px-3 py-2 text-card-foreground hover:bg-background rounded-[5px] transition-colors" 
                    :class="{ 'bg-background border border-border': $page.url === '/admin' }">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5h8" />
                </svg>
                Overview
              </Link>
              <Link href="/admin/sales-report" class="flex items-center px-3 py-2 text-card-foreground hover:bg-background rounded-[5px] transition-colors"
                    :class="{ 'bg-background border border-border': $page.url.includes('/admin/sales-report') }">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Sales Report
              </Link>
            </nav>
          </div>

          <!-- Products -->
          <div class="mb-6">
            <h3 class="text-sm font-medium text-muted-foreground mb-2 uppercase tracking-wide">Products</h3>
            <nav class="space-y-1">
              <Link href="/admin/products" class="flex items-center px-3 py-2 text-card-foreground hover:bg-background rounded-[5px] transition-colors"
                    :class="{ 'bg-background border border-border': $page.url.includes('/admin/products') }">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                All Products
              </Link>
              <Link href="/admin/products/create" class="flex items-center px-3 py-2 text-card-foreground hover:bg-background rounded-[5px] transition-colors"
                    :class="{ 'bg-background border border-border': $page.url.includes('/admin/products/create') }">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
              </Link>
            </nav>
          </div>

          <!-- Orders -->
          <div class="mb-6">
            <h3 class="text-sm font-medium text-muted-foreground mb-2 uppercase tracking-wide">Orders</h3>
            <nav class="space-y-1">
              <Link href="/admin/orders" class="flex items-center px-3 py-2 text-card-foreground hover:bg-background rounded-[5px] transition-colors"
                    :class="{ 'bg-background border border-border': $page.url.includes('/admin/orders') }">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                All Orders
              </Link>
            </nav>
          </div>

          <!-- Settings -->
          <div>
            <h3 class="text-sm font-medium text-muted-foreground mb-2 uppercase tracking-wide">Settings</h3>
            <nav class="space-y-1">
              <Link href="/admin/settings" class="flex items-center px-3 py-2 text-card-foreground hover:bg-background rounded-[5px] transition-colors">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Store Settings
              </Link>
            </nav>
          </div>
        </div>
      </aside>

      <!-- Main Content -->
      <main class="flex-1 p-6">
        <!-- Mobile Navigation -->
        <div v-show="showMobileMenu" class="lg:hidden mb-6 bg-card border-2 border-border rounded-[5px] p-4">
          <nav class="space-y-2">
            <Link href="/admin" class="block py-2 text-card-foreground hover:text-primary transition-colors">
              Dashboard Overview
            </Link>
            <Link href="/admin/products" class="block py-2 text-card-foreground hover:text-primary transition-colors">
              Products
            </Link>
            <Link href="/admin/orders" class="block py-2 text-card-foreground hover:text-primary transition-colors">
              Orders
            </Link>
            <Link href="/admin/sales-report" class="block py-2 text-card-foreground hover:text-primary transition-colors">
              Sales Report
            </Link>
          </nav>
        </div>

        <slot />
      </main>
    </div>

    <!-- Notification Container -->
    <NotificationContainer />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import Button from '@/components/ui/button/Button.vue'
import NotificationContainer from '@/components/ui/notification/NotificationContainer.vue'
import { useNotifications } from '@/composables/useNotifications'

interface Props {
  title?: string
}

defineProps<Props>()

const showUserMenu = ref(false)
const showMobileMenu = ref(false)
const { success, error, warning, info } = useNotifications()
const page = usePage()

// Handle Laravel flash messages
watch(() => page.props.flash, (flash) => {
  if (flash && typeof flash === 'object') {
    if ('success' in flash && flash.success) {
      success(flash.success as string, 'Success')
    }
    if ('error' in flash && flash.error) {
      error(flash.error as string, 'Error')
    }
    if ('warning' in flash && flash.warning) {
      warning(flash.warning as string, 'Warning')
    }
    if ('info' in flash && flash.info) {
      info(flash.info as string, 'Info')
    }
  }
}, { immediate: true, deep: true })

// Close menus when clicking outside
onMounted(() => {
  document.addEventListener('click', (e: Event) => {
    if (!(e.target as Element)?.closest('.relative')) {
      showUserMenu.value = false
    }
  })
})
</script>
