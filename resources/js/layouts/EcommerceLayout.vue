<template>
  <div class="min-h-screen bg-background">
    <!-- Navigation Header -->
    <nav class="bg-card border-b-2 border-border sticky top-0 z-50">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <!-- Logo -->
          <div class="flex items-center">
            <Link href="/" class="text-xl font-bold text-foreground hover:text-primary transition-colors">
              🛒 E-Shop
            </Link>
          </div>

          <!-- Main Navigation -->
          <div class="hidden md:flex items-center space-x-6">
            <Link href="/" class="text-card-foreground hover:text-primary transition-colors">
              Home
            </Link>
            <Link href="/products" class="text-card-foreground hover:text-primary transition-colors">
              Products
            </Link>
            <div v-if="$page.props.auth.user">
              <Link href="/cart" class="text-card-foreground hover:text-primary transition-colors relative">
                🛒 Cart
                <span v-if="cartCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                  {{ cartCount }}
                </span>
              </Link>
            </div>
          </div>

          <!-- User Menu -->
          <div class="flex items-center space-x-4">
            <!-- Search (Mobile Hidden) -->
            <div class="hidden lg:block">
              <form @submit.prevent="searchProducts" class="relative">
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search products..."
                  class="pl-8 pr-4 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring w-64"
                />
                <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </form>
            </div>

            <!-- Auth Menu -->
            <div v-if="$page.props.auth.user" class="relative">
              <button @click="showUserMenu = !showUserMenu" class="flex items-center space-x-2 text-card-foreground hover:text-primary transition-colors">
                <span class="hidden sm:block">{{ $page.props.auth.user.name }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              
              <!-- Dropdown Menu -->
              <div v-show="showUserMenu" class="absolute right-0 mt-2 w-48 bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] z-50">
                <div class="py-2">
                  <Link href="/dashboard" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    Dashboard
                  </Link>
                  <Link href="/orders" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    My Orders
                  </Link>
                  <Link href="/cart" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors md:hidden">
                    Cart ({{ cartCount }})
                  </Link>
                  <hr class="my-2 border-border">
                  <Link href="/logout" method="post" class="block px-4 py-2 text-card-foreground hover:bg-background transition-colors">
                    Logout
                  </Link>
                </div>
              </div>
            </div>

            <!-- Guest Menu -->
            <div v-else class="flex items-center space-x-2">
              <Link href="/login">
                <Button variant="outline" size="sm">Login</Button>
              </Link>
              <Link href="/register">
                <Button variant="default" size="sm">Register</Button>
              </Link>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="showMobileMenu = !showMobileMenu" class="md:hidden text-card-foreground">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile Menu -->
        <div v-show="showMobileMenu" class="md:hidden border-t border-border py-4">
          <div class="space-y-2">
            <Link href="/" class="block py-2 text-card-foreground hover:text-primary transition-colors">
              Home
            </Link>
            <Link href="/products" class="block py-2 text-card-foreground hover:text-primary transition-colors">
              Products
            </Link>
            
            <!-- Mobile Search -->
            <form @submit.prevent="searchProducts" class="pt-2">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search products..."
                class="w-full pl-8 pr-4 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              />
            </form>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main>
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-card border-t-2 border-border mt-16">
      <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <!-- Company Info -->
          <div>
            <h3 class="text-lg font-semibold text-card-foreground mb-4">🛒 E-Shop</h3>
            <p class="text-muted-foreground text-sm">
              Your trusted online marketplace for quality products at amazing prices.
            </p>
          </div>

          <!-- Quick Links -->
          <div>
            <h4 class="font-medium text-card-foreground mb-4">Quick Links</h4>
            <ul class="space-y-2 text-sm">
              <li><Link href="/" class="text-muted-foreground hover:text-primary transition-colors">Home</Link></li>
              <li><Link href="/products" class="text-muted-foreground hover:text-primary transition-colors">Products</Link></li>
              <li><Link href="/about" class="text-muted-foreground hover:text-primary transition-colors">About Us</Link></li>
              <li><Link href="/contact" class="text-muted-foreground hover:text-primary transition-colors">Contact</Link></li>
            </ul>
          </div>

          <!-- Customer Service -->
          <div>
            <h4 class="font-medium text-card-foreground mb-4">Customer Service</h4>
            <ul class="space-y-2 text-sm">
              <li><Link href="/help" class="text-muted-foreground hover:text-primary transition-colors">Help Center</Link></li>
              <li><Link href="/shipping" class="text-muted-foreground hover:text-primary transition-colors">Shipping Info</Link></li>
              <li><Link href="/returns" class="text-muted-foreground hover:text-primary transition-colors">Returns</Link></li>
              <li><Link href="/faq" class="text-muted-foreground hover:text-primary transition-colors">FAQ</Link></li>
            </ul>
          </div>

          <!-- Contact -->
          <div>
            <h4 class="font-medium text-card-foreground mb-4">Contact Us</h4>
            <div class="space-y-2 text-sm text-muted-foreground">
              <p>📧 support@eshop.com</p>
              <p>📞 +62 123 456 7890</p>
              <p>📍 Jakarta, Indonesia</p>
            </div>
          </div>
        </div>

        <div class="mt-8 pt-4 border-t border-border text-center text-sm text-muted-foreground">
          <p>&copy; 2025 E-Shop. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import Button from '@/components/ui/button/Button.vue'

const $page = usePage()

interface Props {
  title?: string
}

defineProps<Props>()

const showUserMenu = ref(false)
const showMobileMenu = ref(false)
const searchQuery = ref('')
const cartCount = ref(0)

const searchProducts = () => {
  if (searchQuery.value.trim()) {
    router.get('/products', { search: searchQuery.value })
  }
}

// Get cart count on mount
onMounted(async () => {
  if ($page.props.auth.user) {
    try {
      const response = await fetch('/cart/count')
      const data = await response.json()
      cartCount.value = data.count || 0
    } catch (error) {
      console.error('Failed to fetch cart count:', error)
    }
  }
})

// Close menus when clicking outside
onMounted(() => {
  document.addEventListener('click', (e: Event) => {
    if (!(e.target as Element)?.closest('.relative')) {
      showUserMenu.value = false
    }
  })
})
</script>
