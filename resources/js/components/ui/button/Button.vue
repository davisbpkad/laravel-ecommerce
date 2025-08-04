<script setup lang="ts">
import type { HTMLAttributes, ButtonHTMLAttributes } from 'vue'
import { computed } from 'vue'
import { cn } from '@/lib/utils'
import { type ButtonVariants, buttonVariants } from '.'

interface Props extends ButtonHTMLAttributes {
  variant?: ButtonVariants['variant']
  size?: ButtonVariants['size']
  class?: HTMLAttributes['class']
  asChild?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
  size: 'default',
})

const buttonClass = computed(() => {
  return cn(buttonVariants({ variant: props.variant, size: props.size }), props.class)
})
</script>

<template>
  <button
    v-if="!asChild"
    data-slot="button"
    :class="buttonClass"
    v-bind="$attrs"
  >
    <slot />
  </button>
  <component 
    v-else
    :is="'div'"
    data-slot="button"
    :class="buttonClass"
  >
    <slot />
  </component>
</template>
