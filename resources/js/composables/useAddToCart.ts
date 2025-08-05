import { useCart } from '@/composables/useCart'
import { useNotifications } from '@/composables/useNotifications'

export function useAddToCart() {
  const { addToCart, fetchCartCount } = useCart()
  const { success, error } = useNotifications()

  const addItemToCart = async (productId: number, quantity: number = 1) => {
    try {
      await addToCart(productId, quantity)
      success(`Added ${quantity} item(s) to cart!`)
      
      // Force refresh cart count to ensure UI is updated
      await fetchCartCount()
      
      return true
    } catch (err) {
      console.error('Error adding to cart:', err)
      error('Failed to add item to cart. Please try again.')
      return false
    }
  }

  return {
    addItemToCart
  }
}
