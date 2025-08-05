<template>
  <Button
    @click="handleAddToCart"
    :disabled="isLoading"
    variant="default"
    size="default"
    class="w-full"
  >
    <svg v-if="isLoading" class="animate-spin -ml-1 mr-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 0h10" />
    </svg>
    {{ isLoading ? 'Adding...' : 'Add to Cart' }}
  </Button>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import Button from '@/components/ui/button/Button.vue'
import { useAddToCart } from '@/composables/useAddToCart'

interface Props {
  productId: number
  quantity?: number
}

const props = withDefaults(defineProps<Props>(), {
  quantity: 1
})

const { addItemToCart } = useAddToCart()
const isLoading = ref(false)

const handleAddToCart = async () => {
  isLoading.value = true
  
  try {
    await addItemToCart(props.productId, props.quantity)
  } finally {
    isLoading.value = false
  }
}
</script>
