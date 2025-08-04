<template>
  <div class="min-h-screen bg-background p-8">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-4xl font-bold text-foreground mb-2">Neobrutalism Buttons</h1>
      <p class="text-muted-foreground mb-8">A collection of neobrutalism-styled buttons - Now Fixed!</p>
      
      <div class="grid gap-8">
        <!-- Default Buttons -->
        <section>
          <h2 class="text-2xl font-semibold text-foreground mb-4">Default</h2>
          <div class="flex flex-wrap gap-4">
            <Button>Default Button</Button>
            <Button size="sm">Small Button</Button>
            <Button size="lg">Large Button</Button>
            <Button size="icon">
              <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
            </Button>
          </div>
        </section>

        <!-- Variant Buttons -->
        <section>
          <h2 class="text-2xl font-semibold text-foreground mb-4">Variants</h2>
          <div class="flex flex-wrap gap-4">
            <Button variant="default">Default</Button>
            <Button variant="neutral">Neutral</Button>
            <Button variant="reverse">Reverse</Button>
            <Button variant="noShadow">No Shadow</Button>
            <Button variant="destructive">Destructive</Button>
            <Button variant="outline">Outline</Button>
            <Button variant="ghost">Ghost</Button>
            <Button variant="link">Link</Button>
          </div>
        </section>

        <!-- With Icons -->
        <section>
          <h2 class="text-2xl font-semibold text-foreground mb-4">With Icons</h2>
          <div class="flex flex-wrap gap-4">
            <Button>
              <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
              Send Message
            </Button>
            <Button variant="neutral">
              <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
              Like
            </Button>
            <Button variant="reverse">
              <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
              </svg>
              Chat
            </Button>
          </div>
        </section>

        <!-- Interactive Examples -->
        <section>
          <h2 class="text-2xl font-semibold text-foreground mb-4">Interactive Examples</h2>
          <div class="space-y-4">
            <div>
              <h3 class="font-medium mb-2">Counter Example:</h3>
              <div class="flex items-center gap-2">
                <Button variant="outline" @click="counter--" :disabled="counter <= 0">-</Button>
                <span class="px-4 py-2 border-2 border-border rounded-[5px] bg-background">{{ counter }}</span>
                <Button variant="outline" @click="counter++">+</Button>
              </div>
            </div>
          </div>
        </section>

        <!-- Loading States -->
        <section>
          <h2 class="text-2xl font-semibold text-foreground mb-4">Loading States</h2>
          <div class="flex flex-wrap gap-4">
            <Button :disabled="isLoading" @click="toggleLoading">
              <svg v-if="isLoading" class="size-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 16c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z" />
              </svg>
              {{ isLoading ? 'Loading...' : 'Click to Load' }}
            </Button>
          </div>
        </section>

        <!-- Dark Mode Toggle -->
        <section>
          <h2 class="text-2xl font-semibold text-foreground mb-4">Dark Mode</h2>
          <Button @click="toggleDarkMode" variant="outline">
            Toggle Dark Mode
          </Button>
        </section>

        <!-- Form Example -->
        <section class="bg-card border-2 border-border rounded-[5px] p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
          <h2 class="text-2xl font-semibold text-card-foreground mb-4">Form Example</h2>
          <form @submit.prevent="handleSubmit" class="space-y-4 max-w-md">
            <div class="space-y-2">
              <label class="text-sm font-medium text-card-foreground">Email</label>
              <input 
                v-model="formData.email"
                type="email" 
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="Enter your email"
              />
            </div>
            <div class="space-y-2">
              <label class="text-sm font-medium text-card-foreground">Message</label>
              <textarea 
                v-model="formData.message"
                class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="Enter your message"
                rows="3"
              ></textarea>
            </div>
            <div class="flex gap-2 pt-2">
              <Button type="submit" class="flex-1">Send Message</Button>
              <Button variant="neutral" type="button" class="flex-1" @click="resetForm">Reset</Button>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import Button from '@/components/ui/button/Button.vue'

const isDark = ref(false)
const counter = ref(0)
const isLoading = ref(false)
const formData = ref({
  email: '',
  message: ''
})

const toggleDarkMode = () => {
  isDark.value = !isDark.value
  if (isDark.value) {
    document.documentElement.classList.add('dark')
  } else {
    document.documentElement.classList.remove('dark')
  }
}

const toggleLoading = () => {
  isLoading.value = true
  setTimeout(() => {
    isLoading.value = false
  }, 2000)
}

const handleSubmit = () => {
  alert(`Email: ${formData.value.email}\nMessage: ${formData.value.message}`)
}

const resetForm = () => {
  formData.value = {
    email: '',
    message: ''
  }
}

onMounted(() => {
  // Check if dark mode is already enabled
  isDark.value = document.documentElement.classList.contains('dark')
})
</script>
