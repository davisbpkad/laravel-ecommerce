<template>
  <EcommerceLayout title="Products">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <h1 class="text-3xl font-bold text-foreground mb-2">Our Products</h1>
          <p class="text-muted-foreground">Discover amazing products at great prices</p>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <!-- Filters Section -->
        <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 mb-8">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Search</label>
              <input
                v-model="searchForm.search"
                type="text"
                placeholder="Search products..."
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              />
            </div>

            <!-- Category Filter -->
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Category</label>
              <select
                v-model="searchForm.category"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              >
                <option value="">All Categories</option>
                <option v-for="category in categories" :key="category" :value="category">
                  {{ category }}
                </option>
              </select>
            </div>

            <!-- Sort -->
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Sort By</label>
              <select
                v-model="searchForm.sort"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              >
                <option value="name">Name</option>
                <option value="price">Price</option>
                <option value="created_at">Newest</option>
              </select>
            </div>

            <!-- Direction -->
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">Order</label>
              <select
                v-model="searchForm.direction"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
              >
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
              </select>
            </div>
          </div>

          <div class="mt-4 flex gap-2">
            <Button @click="search" variant="default">
              Apply Filters
            </Button>
            <Button @click="resetFilters" variant="outline">
              Reset
            </Button>
          </div>
        </div>

        <!-- Products Grid -->
        <div v-if="products.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
          <div
            v-for="product in products.data"
            :key="product.id"
            class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-all duration-200"
          >
            <!-- Product Image -->
            <div class="aspect-square bg-background border-b-2 border-border flex items-center justify-center">
              <img
                v-if="product.image"
                :src="product.image || '/api/placeholder/300/300'"
                :alt="product.name"
                class="w-full h-full object-cover"
              />
              <div v-else class="text-muted-foreground text-4xl">
                📦
              </div>
            </div>

            <!-- Product Info -->
            <div class="p-4">
              <h3 class="font-semibold text-card-foreground mb-2 line-clamp-2">
                {{ product.name }}
              </h3>
              <p class="text-muted-foreground text-sm mb-3 line-clamp-2">
                {{ product.description }}
              </p>
              
              <!-- Price and Stock -->
              <div class="flex items-center justify-between mb-3">
                <span class="text-xl font-bold text-foreground">
                  Rp {{ formatPrice(product.price) }}
                </span>
                <span :class="getStockClass(product.stock)" class="text-xs px-2 py-1 rounded-[3px] border font-medium">
                  {{ product.stock }} left
                </span>
              </div>

              <!-- Category Badge -->
              <div class="mb-4">
                <span class="inline-block bg-card border border-border text-card-foreground text-xs px-2 py-1 rounded-[3px] font-medium">
                  {{ product.category }}
                </span>
              </div>

              <!-- Actions -->
              <div class="space-y-2">
                <Link :href="`/products/${product.id}`" class="block w-full">
                  <Button variant="outline" class="w-full">
                    View Details
                  </Button>
                </Link>
                
                <Button
                  v-if="$page.props.auth.user && product.stock > 0"
                  @click="addToCart(product.id)"
                  variant="default"
                  class="w-full"
                  :disabled="addingToCart === product.id"
                >
                  <svg v-if="addingToCart === product.id" class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 16c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z" />
                  </svg>
                  <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
                  </svg>
                  {{ addingToCart === product.id ? 'Adding...' : 'Add to Cart' }}
                </Button>
                
                <div v-else-if="product.stock === 0" class="w-full">
                  <Button variant="ghost" class="w-full" disabled>
                    Out of Stock
                  </Button>
                </div>
                
                <div v-else class="w-full">
                  <Link href="/login" class="block w-full">
                    <Button variant="neutral" class="w-full">
                      Login to Buy
                    </Button>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- No Products -->
        <div v-else class="text-center py-12">
          <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-8 max-w-md mx-auto">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-xl font-semibold text-card-foreground mb-2">No products found</h3>
            <p class="text-muted-foreground">Try adjusting your filters or search terms.</p>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="products.data.length > 0" class="flex justify-center">
          <nav class="flex items-center space-x-2">
            <!-- Previous -->
            <Link
              v-if="products.prev_page_url"
              :href="products.prev_page_url"
            >
              <Button variant="outline" size="sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Previous
              </Button>
            </Link>

            <!-- Page Numbers -->
            <span class="px-4 py-2 text-sm text-muted-foreground">
              Page {{ products.current_page }} of {{ products.last_page }}
            </span>

            <!-- Next -->
            <Link
              v-if="products.next_page_url"
              :href="products.next_page_url"
            >
              <Button variant="outline" size="sm">
                Next
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </Button>
            </Link>
          </nav>
        </div>
      </div>
    </div>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import { ref, reactive } from 'vue'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { Link } from '@inertiajs/vue3'

interface Product {
  id: number
  name: string
  description: string
  price: number
  stock: number
  image: string
  category: string
}

interface ProductsPaginated {
  data: Product[]
  current_page: number
  last_page: number
  prev_page_url: string | null
  next_page_url: string | null
}

interface Props {
  products: ProductsPaginated
  categories: string[]
  filters: {
    search: string | null
    category: string | null
    sort: string
    direction: string
  }
}

const props = defineProps<Props>()
const page = usePage()

const addingToCart = ref<number | null>(null)

const searchForm = reactive({
  search: props.filters.search || '',
  category: props.filters.category || '',
  sort: props.filters.sort || 'name',
  direction: props.filters.direction || 'asc',
})

const formatPrice = (price: number) => {
  return new Intl.NumberFormat('id-ID').format(price)
}

const getStockClass = (stock: number): string => {
  if (stock <= 5) return 'bg-red-100 text-red-800 border-red-300'
  if (stock <= 10) return 'bg-yellow-100 text-yellow-800 border-yellow-300'
  return 'bg-green-100 text-green-800 border-green-300'
}

const search = () => {
  router.get('/products', searchForm, {
    preserveState: true,
    preserveScroll: true,
  })
}

const resetFilters = () => {
  searchForm.search = ''
  searchForm.category = ''
  searchForm.sort = 'name'
  searchForm.direction = 'asc'
  search()
}

const addToCart = async (productId: number) => {
  addingToCart.value = productId
  
  try {
    await router.post('/cart/add', {
      product_id: productId,
      quantity: 1,
    })
  } finally {
    addingToCart.value = null
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
