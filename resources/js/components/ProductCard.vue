<!-- Example usage in Product page or component -->
<template>
  <div class="product-card border rounded-lg p-4">
    <h3 class="text-lg font-semibold mb-2">{{ product.name }}</h3>
    <p class="text-2xl font-bold text-primary mb-4">
      Rp {{ formatCurrency(product.price) }}
    </p>
    
    <!-- Quantity selector -->
    <div class="flex items-center space-x-2 mb-4">
      <label class="text-sm font-medium">Quantity:</label>
      <select v-model="selectedQuantity" class="border rounded px-2 py-1">
        <option v-for="i in 10" :key="i" :value="i">{{ i }}</option>
      </select>
    </div>
    
    <!-- Add to Cart Button -->
    <AddToCartButton 
      :product-id="product.id" 
      :quantity="selectedQuantity"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import AddToCartButton from '@/components/AddToCartButton.vue'

interface Product {
  id: number
  name: string
  price: number
}

interface Props {
  product: Product
}

defineProps<Props>()

const selectedQuantity = ref(1)

const formatCurrency = (amount: number): string => {
  return new Intl.NumberFormat('id-ID').format(amount)
}
</script>
