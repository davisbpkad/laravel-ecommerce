import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

// Simple event system for cart updates
const cartEventListeners = new Set<() => void>()

const emitCartUpdate = () => {
  cartEventListeners.forEach(listener => listener())
}

// Global cart state
const cartCount = ref(0)
const cartItems = ref([])
const isLoading = ref(false)
let pollingInterval: number | null = null

export function useCart() {
  const page = usePage()

  // Subscribe to cart updates
  const subscribeToCartUpdates = (callback: () => void) => {
    cartEventListeners.add(callback)
    return () => cartEventListeners.delete(callback)
  }

  // Start polling for cart updates (less frequent)
  const startPolling = () => {
    if (pollingInterval) return
    
    pollingInterval = setInterval(() => {
      if (page.props.auth?.user) {
        // Silent fetch without emitting events to avoid UI flickering
        fetchCartCountSilent()
      }
    }, 300000) // Poll every 5 minutes instead of 2 minutes
  }

  // Stop polling
  const stopPolling = () => {
    if (pollingInterval) {
      clearInterval(pollingInterval)
      pollingInterval = null
    }
  }

  // Fetch cart count from API (silent - no events)
  const fetchCartCountSilent = async () => {
    if (!page.props.auth?.user) {
      cartCount.value = 0
      return
    }

    try {
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      const response = await fetch('/api/cart/count', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token || '',
          'Accept': 'application/json'
        }
      })
      
      if (response.ok) {
        const data = await response.json()
        cartCount.value = data.count || 0
        // No event emission for silent fetch
      } else {
        console.error('Failed to fetch cart count:', response.status)
        cartCount.value = 0
      }
    } catch (error) {
      console.error('Failed to fetch cart count:', error)
      cartCount.value = 0
    }
  }

  // Fetch cart count from API
  const fetchCartCount = async () => {
    if (!page.props.auth?.user) {
      cartCount.value = 0
      return
    }

    try {
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      const response = await fetch('/api/cart/count', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token || '',
          'Accept': 'application/json'
        }
      })
      
      if (response.ok) {
        const data = await response.json()
        cartCount.value = data.count || 0
        
        // Only emit update event when explicitly fetching (not during polling)
        emitCartUpdate()
      } else {
        console.error('Failed to fetch cart count:', response.status)
        cartCount.value = 0
      }
    } catch (error) {
      console.error('Failed to fetch cart count:', error)
      cartCount.value = 0
    }
  }

  // Fetch cart items from API
  const fetchCartItems = async () => {
    if (!page.props.auth?.user) {
      cartItems.value = []
      return
    }

    isLoading.value = true
    try {
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      const response = await fetch('/api/cart/items', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token || '',
          'Accept': 'application/json'
        }
      })
      
      if (response.ok) {
        const data = await response.json()
        cartItems.value = data.items || []
        cartCount.value = data.count || 0
        
        // Only emit update event when data actually changes
        emitCartUpdate()
      } else {
        console.error('Failed to fetch cart items:', response.status)
        cartItems.value = []
        cartCount.value = 0
      }
    } catch (error) {
      console.error('Failed to fetch cart items:', error)
      cartItems.value = []
      cartCount.value = 0
    } finally {
      isLoading.value = false
    }
  }

  // Add item to cart
  const addToCart = async (productId: number, quantity: number = 1) => {
    if (!page.props.auth?.user) {
      throw new Error('Please login to add items to cart')
    }

    try {
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      const response = await fetch('/api/cart/add', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token || '',
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          product_id: productId,
          quantity: quantity
        })
      })

      if (response.ok) {
        const data = await response.json()
        
        // Update cart count immediately
        cartCount.value = data.count
        
        // Emit update event
        emitCartUpdate()
        
        // Clear cached items so they reload fresh
        cartItems.value = []
        
        return data
      } else {
        throw new Error('Failed to add item to cart')
      }
    } catch (error) {
      console.error('Error adding to cart:', error)
      throw error
    }
  }

  // Remove item from cart
  const removeFromCart = async (cartItemId: number) => {
    try {
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      const response = await fetch(`/api/cart/remove/${cartItemId}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token || '',
          'Accept': 'application/json'
        }
      })

      if (response.ok) {
        const data = await response.json()
        
        // Update cart count immediately
        cartCount.value = data.count
        
        // Emit update event
        emitCartUpdate()
        
        // Refresh cart items
        await fetchCartItems()
        
        return data
      } else {
        throw new Error('Failed to remove item from cart')
      }
    } catch (error) {
      console.error('Error removing from cart:', error)
      throw error
    }
  }

  // Update cart item quantity
  const updateCartItemQuantity = async (cartItemId: number, quantity: number) => {
    try {
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      const response = await fetch(`/api/cart/update/${cartItemId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token || '',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity })
      })

      if (response.ok) {
        const data = await response.json()
        
        // Update cart count immediately
        cartCount.value = data.count
        
        // Emit update event
        emitCartUpdate()
        
        // Refresh cart items
        await fetchCartItems()
        
        return data
      } else {
        throw new Error('Failed to update cart item')
      }
    } catch (error) {
      console.error('Error updating cart item:', error)
      throw error
    }
  }

  // Clear entire cart
  const clearCart = async () => {
    try {
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      const response = await fetch('/api/cart/clear', {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token || '',
          'Accept': 'application/json'
        }
      })

      if (response.ok) {
        cartCount.value = 0
        cartItems.value = []
        
        // Emit update event
        emitCartUpdate()
        
        return await response.json()
      } else {
        throw new Error('Failed to clear cart')
      }
    } catch (error) {
      console.error('Error clearing cart:', error)
      throw error
    }
  }

  // Computed total price
  const cartTotal = computed(() => {
    return cartItems.value.reduce((total, item: any) => {
      return total + (item.product.price * item.quantity)
    }, 0)
  })

  // Initialize cart data
  const initializeCart = async () => {
    if (page.props.auth?.user) {
      await fetchCartCount()
      // Disable polling temporarily for debugging
      // startPolling() 
    }
  }

  // Refresh cart data (count and items) - optimized
  const refreshCart = async () => {
    if (page.props.auth?.user) {
      // Only fetch items, which includes count in response
      await fetchCartItems()
    }
  }

  return {
    // State
    cartCount: computed(() => cartCount.value),
    cartItems: computed(() => cartItems.value),
    cartTotal,
    isLoading: computed(() => isLoading.value),
    
    // Methods
    fetchCartCount,
    fetchCartCountSilent,
    fetchCartItems,
    addToCart,
    removeFromCart,
    updateCartItemQuantity,
    clearCart,
    initializeCart,
    refreshCart,
    subscribeToCartUpdates,
    startPolling,
    stopPolling
  }
}
