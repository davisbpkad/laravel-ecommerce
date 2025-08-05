<script setup lang="ts">
interface Props {
  variant?: 'default' | 'noShadow' | 'neutral' | 'reverse' | 'destructive' | 'outline' | 'ghost' | 'link'
  size?: 'default' | 'sm' | 'lg' | 'icon'
  class?: string
  type?: 'button' | 'submit' | 'reset'
  disabled?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
  size: 'default',
  type: 'button',
  disabled: false
})

// Get variant styles
function getVariantStyles(variant: string): string {
  const variants: Record<string, string> = {
    default: 'text-primary-foreground bg-primary border-2 border-border shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none',
    noShadow: 'text-primary-foreground bg-primary border-2 border-border',
    neutral: 'bg-background text-foreground border-2 border-border shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none',
    reverse: 'text-primary-foreground bg-primary border-2 border-border shadow-[-4px_-4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-4px] hover:translate-y-[-4px] hover:shadow-none',
    destructive: 'bg-destructive text-destructive-foreground border-2 border-border shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none',
    outline: 'border-2 border-border bg-background shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none hover:bg-accent hover:text-accent-foreground',
    ghost: 'hover:bg-accent hover:text-accent-foreground border-2 border-transparent',
    link: 'text-primary underline-offset-4 hover:underline border-2 border-transparent'
  }
  return variants[variant] || variants.default
}

// Get size styles
function getSizeStyles(size: string): string {
  const sizes: Record<string, string> = {
    default: 'h-10 px-4 py-2',
    sm: 'h-9 px-3',
    lg: 'h-11 px-8',
    icon: 'size-10'
  }
  return sizes[size] || sizes.default
}

// Compute final classes - fixed approach
const buttonClasses = [
  // Base styles
  'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-[5px] text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2',
  // Variant styles
  getVariantStyles(props.variant),
  // Size styles
  getSizeStyles(props.size),
  // Custom classes
  props.class
].filter(Boolean).join(' ')
</script>

<template>
  <button
    :type="props.type"
    :disabled="props.disabled"
    :class="buttonClasses"
    v-bind="$attrs"
  >
    <slot />
  </button>
</template>
