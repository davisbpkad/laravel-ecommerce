# Button Component

A customizable button component with neobrutalism design style, built for Vue.js applications.

## Features

- **Neobrutalism Design**: Bold shadows, thick borders, and distinctive hover effects
- **Multiple Variants**: Default, neutral, reverse, destructive, outline, ghost, and link styles
- **Size Options**: Small, default, large, and icon sizes
- **TypeScript Support**: Full TypeScript definitions and type safety
- **Accessibility**: ARIA compliant with proper focus management
- **Customizable**: Easy to extend with custom classes

## Installation

The Button component is already included in this project. Simply import it:

```vue
<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue'
</script>
```

## Basic Usage

```vue
<template>
  <Button>Click me</Button>
</template>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `'default' \| 'noShadow' \| 'neutral' \| 'reverse' \| 'destructive' \| 'outline' \| 'ghost' \| 'link'` | `'default'` | Button style variant |
| `size` | `'default' \| 'sm' \| 'lg' \| 'icon'` | `'default'` | Button size |
| `type` | `'button' \| 'submit' \| 'reset'` | `'button'` | HTML button type |
| `disabled` | `boolean` | `false` | Whether the button is disabled |
| `class` | `string` | `undefined` | Additional CSS classes |

## Variants

### Default
The primary button with neobrutalism shadow effect.

```vue
<Button variant="default">Primary Button</Button>
```

### Neutral
Neutral background with border and shadow.

```vue
<Button variant="neutral">Neutral Button</Button>
```

### Reverse
Shadow effect in the opposite direction.

```vue
<Button variant="reverse">Reverse Button</Button>
```

### Destructive
Red button for dangerous actions.

```vue
<Button variant="destructive">Delete</Button>
```

### Outline
Transparent background with border.

```vue
<Button variant="outline">Outline Button</Button>
```

### Ghost
Minimal styling with hover effects.

```vue
<Button variant="ghost">Ghost Button</Button>
```

### Link
Styled as a text link.

```vue
<Button variant="link">Link Button</Button>
```

### No Shadow
Primary style without shadow effect.

```vue
<Button variant="noShadow">No Shadow</Button>
```

## Sizes

### Small
```vue
<Button size="sm">Small</Button>
```

### Default
```vue
<Button>Default Size</Button>
```

### Large
```vue
<Button size="lg">Large</Button>
```

### Icon
Square button for icons only.

```vue
<Button size="icon">
  <PlusIcon />
</Button>
```

## Advanced Examples

### Form Submit Button
```vue
<Button type="submit" :disabled="form.processing">
  <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
  Submit Form
</Button>
```

### Custom Styled Button
```vue
<Button 
  variant="outline" 
  size="lg" 
  class="border-blue-500 text-blue-500 hover:bg-blue-50"
>
  Custom Button
</Button>
```

### Button with Icon
```vue
<Button>
  <PlusIcon class="h-4 w-4 mr-2" />
  Add Item
</Button>
```

### Disabled State
```vue
<Button :disabled="true">
  Disabled Button
</Button>
```

## Styling

The Button component uses CSS custom properties for theming:

```css
:root {
  --primary: hsl(var(--primary));
  --primary-foreground: hsl(var(--primary-foreground));
  --background: hsl(var(--background));
  --foreground: hsl(var(--foreground));
  --border: hsl(var(--border));
  /* ... other CSS variables */
}
```

### Neobrutalism Design Features

- **Bold Shadows**: `shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]`
- **Thick Borders**: `border-2 border-border`
- **Hover Animation**: Translates button and removes shadow on hover
- **Rounded Corners**: `rounded-[5px]` for subtle rounding

## Accessibility

The Button component includes:

- Proper focus management with `focus-visible` styles
- Screen reader support through semantic HTML
- Disabled state handling
- Keyboard navigation support

## Troubleshooting

### Common Issues

#### "[object Object]" Error
If you see `[object Object]` instead of button text, ensure you're using the direct import:

```vue
// ✅ Correct
import Button from '@/components/ui/button/Button.vue'

// ❌ Avoid barrel exports if having issues
import { Button } from '@/components/ui/button'
```

#### Styling Issues
Make sure your CSS variables are properly defined in your global CSS file.

#### TypeScript Errors
Ensure you're using the correct prop types as defined in the component interface.

## Dependencies

- Vue.js 3.x
- Tailwind CSS
- CSS custom properties (CSS variables)

## Browser Support

- Modern browsers with CSS custom properties support
- Vue.js 3.x compatibility

## Contributing

When modifying the Button component:

1. Maintain backward compatibility
2. Update TypeScript definitions
3. Test all variants and sizes
4. Ensure accessibility standards
5. Update this documentation

## Examples in Project

You can find usage examples in:
- `pages/auth/Login.vue` - Form submit buttons
- `pages/auth/Register.vue` - Registration form
- `components/DeleteUser.vue` - Destructive actions
- `pages/ButtonDemo.vue` - All variants showcase
- `layouts/settings/Layout.vue` - Navigation buttons

## Version History

- **v1.0.0**: Initial implementation with neobrutalism design
- **v1.1.0**: Added new variants and improved TypeScript support
- **v1.2.0**: Fixed reactivity issues and optimized class handling
