<template>
  <Modal
    :show="show"
    :title="modalTitle"
    :description="modalDescription"
    @close="$emit('close')"
  >
    <!-- Profile Settings Content -->
    <div v-if="type === 'profile'" class="space-y-6">
      <!-- Avatar Section -->
      <div class="flex items-center space-x-4 p-4 bg-background border border-border rounded-[5px]">
        <div class="flex-shrink-0">
          <div v-if="props.user?.avatar" class="w-16 h-16 rounded-full border-2 border-border overflow-hidden">
            <img :src="props.user.avatar" :alt="props.user.name" class="w-full h-full object-cover" />
          </div>
          <div v-else class="w-16 h-16 rounded-full border-2 border-border bg-muted flex items-center justify-center">
            <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
        </div>
        <div class="flex-1">
          <h3 class="font-medium text-foreground">{{ props.user?.name || 'User' }}</h3>
          <p class="text-sm text-muted-foreground">{{ props.user?.email || 'No email' }}</p>
          <p class="text-xs text-muted-foreground">Member since {{ props.user?.created_at ? formatMemberSince(props.user.created_at) : 'Unknown' }}</p>
        </div>
        <Link href="/settings/profile">
          
        </Link>
      </div>

      <!-- Quick Profile Update Form -->
      <form @submit.prevent="updateQuickProfile" class="space-y-4">
        <div class="grid gap-2">
          <Label for="quick_name">Name</Label>
          <Input
            id="quick_name"
            v-model="quickForm.name"
            type="text"
            placeholder="Your name"
          />
          <InputError :message="quickForm.errors.name" />
        </div>

        <div class="grid gap-2">
          <Label for="quick_email">Email Address</Label>
          <Input
            id="quick_email"
            v-model="quickForm.email"
            type="email"
            placeholder="Your email address"
          />
          <InputError :message="quickForm.errors.email" />
        </div>

        <div class="grid gap-2">
          <Label for="quick_phone">Phone Number</Label>
          <Input
            id="quick_phone"
            v-model="quickForm.phone"
            type="tel"
            placeholder="Your phone number"
          />
          <InputError :message="quickForm.errors.phone" />
        </div>

        <div class="flex justify-end space-x-2">
          <Button type="button" variant="outline" @click="$emit('close')">
            Cancel
          </Button>
          <Button type="submit" :disabled="quickForm.processing">
            <svg v-if="quickForm.processing" class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Update Profile
          </Button>
        </div>
      </form>
    </div>

    <!-- Password Settings Content -->
    <div v-else-if="type === 'password'" class="space-y-6">
      <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-[5px]">
        <div class="flex">
          <svg class="w-5 h-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
          </svg>
          <div>
            <h4 class="font-medium text-yellow-800">Security Notice</h4>
            <p class="text-sm text-yellow-700 mt-1">Ensure your account is using a long, random password to stay secure.</p>
          </div>
        </div>
      </div>

      <form @submit.prevent="updatePassword" class="space-y-4">
        <div class="grid gap-2">
          <Label for="current_password">Current Password</Label>
          <Input
            id="current_password"
            v-model="passwordForm.current_password"
            type="password"
            placeholder="Enter current password"
          />
          <InputError :message="passwordForm.errors.current_password" />
        </div>

        <div class="grid gap-2">
          <Label for="new_password">New Password</Label>
          <Input
            id="new_password"
            v-model="passwordForm.password"
            type="password"
            placeholder="Enter new password"
          />
          <InputError :message="passwordForm.errors.password" />
        </div>

        <div class="grid gap-2">
          <Label for="password_confirmation">Confirm New Password</Label>
          <Input
            id="password_confirmation"
            v-model="passwordForm.password_confirmation"
            type="password"
            placeholder="Confirm new password"
          />
          <InputError :message="passwordForm.errors.password_confirmation" />
        </div>

        <div class="flex justify-end space-x-2">
          <Button type="button" variant="outline" @click="$emit('close')">
            Cancel
          </Button>
          <Button type="submit" :disabled="passwordForm.processing">
            <svg v-if="passwordForm.processing" class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Update Password
          </Button>
        </div>
      </form>
    </div>

    <!-- Appearance Settings Content -->
    <div v-else-if="type === 'appearance'" class="space-y-6">
      <div class="p-4 bg-blue-50 border border-blue-200 rounded-[5px]">
        <div class="flex">
          <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
          </svg>
          <div>
            <h4 class="font-medium text-blue-800">Theme Settings</h4>
            <p class="text-sm text-blue-700 mt-1">Customize your visual experience.</p>
          </div>
        </div>
      </div>

      <!-- Theme Selection -->
      <div class="space-y-4">
        <div>
          <Label class="text-base font-medium">Color Theme</Label>
          <p class="text-sm text-muted-foreground">Choose your preferred color theme</p>
        </div>
        
        <div class="grid grid-cols-3 gap-3">
          <button
            v-for="theme in themes"
            :key="theme.value"
            type="button"
            @click="setTheme(theme.value)"
            :class="[
              'p-4 border-2 rounded-[8px] text-left transition-all hover:scale-105',
              currentTheme === theme.value 
                ? 'border-primary bg-primary/5' 
                : 'border-border hover:border-primary/50'
            ]"
          >
            <div class="flex items-center space-x-3">
              <div :class="theme.preview" class="w-8 h-8 rounded-full border-2 border-border"></div>
              <div>
                <div class="font-medium text-sm">{{ theme.name }}</div>
                <div class="text-xs text-muted-foreground">{{ theme.description }}</div>
              </div>
            </div>
          </button>
        </div>
      </div>

      <!-- Additional Settings -->
      <div class="space-y-4">
        <div>
          <Label class="text-base font-medium">Display Options</Label>
          <p class="text-sm text-muted-foreground">Adjust display preferences</p>
        </div>
        
        <div class="space-y-3">
          <div class="flex items-center justify-between p-3 border border-border rounded-[5px]">
            <div>
              <div class="font-medium text-sm">Compact Mode</div>
              <div class="text-xs text-muted-foreground">Reduce spacing for more content</div>
            </div>
            <input type="checkbox" v-model="compactMode" class="w-4 h-4 text-primary border-border rounded focus:ring-primary">
          </div>
          
          <div class="flex items-center justify-between p-3 border border-border rounded-[5px]">
            <div>
              <div class="font-medium text-sm">Animations</div>
              <div class="text-xs text-muted-foreground">Enable smooth transitions</div>
            </div>
            <input type="checkbox" v-model="animations" class="w-4 h-4 text-primary border-border rounded focus:ring-primary">
          </div>
        </div>
      </div>

      <div class="flex justify-end space-x-2">
        <Button type="button" variant="outline" @click="$emit('close')">
          Cancel
        </Button>
        <Button type="button" @click="saveAppearanceSettings">
          Save Settings
        </Button>
      </div>
    </div>
  </Modal>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import Modal from '@/components/Modal.vue'
import Button from '@/components/ui/button/Button.vue'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import InputError from '@/components/InputError.vue'
interface Props {
  show: boolean
  type: 'profile' | 'password' | 'appearance'
  user?: {
    id: number
    name: string
    email: string
    phone?: string
    avatar?: string
    created_at: string
  }
}

const props = defineProps<Props>()
const emit = defineEmits<{
  close: []
}>()

// Simple notification function - you can replace with your preferred notification system
const showNotification = (message: string, type: 'success' | 'error' | 'warning' | 'info' = 'success') => {
  // For now, just using alert - replace with your notification system
  console.log(`${type}: ${message}`)
  if (type === 'success') {
    alert(`✓ ${message}`)
  } else if (type === 'error') {
    alert(`✗ ${message}`)
  } else {
    alert(`${type}: ${message}`)
  }
}

// Modal title and description
const modalTitle = computed(() => {
  switch (props.type) {
    case 'profile':
      return 'Profile Settings'
    case 'password':
      return 'Change Password'
    case 'appearance':
      return 'Appearance Settings'
    default:
      return 'Settings'
  }
})

const modalDescription = computed(() => {
  switch (props.type) {
    case 'profile':
      return 'Update your profile information'
    case 'password':
      return 'Change your account password'
    case 'appearance':
      return 'Customize your visual experience'
    default:
      return ''
  }
})

// Quick Profile Form
const quickForm = useForm({
  name: props.user?.name || '',
  email: props.user?.email || '',
  phone: props.user?.phone || '',
})

const updateQuickProfile = () => {
  quickForm.patch('/settings/profile', {
    onSuccess: () => {
      showNotification('Profile updated successfully!', 'success')
      emit('close')
    },
    onError: (errors) => {
      console.error('Profile update errors:', errors)
      showNotification('Failed to update profile', 'error')
    }
  })
}

// Password Form
const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

const updatePassword = () => {
  passwordForm.put('/settings/password', {
    onSuccess: () => {
      showNotification('Password updated successfully!', 'success')
      passwordForm.reset()
      emit('close')
    },
    onError: (errors) => {
      console.error('Password update errors:', errors)
      showNotification('Failed to update password', 'error')
    }
  })
}

// Appearance Settings
const currentTheme = ref('light')
const compactMode = ref(false)
const animations = ref(true)

const themes = [
  {
    name: 'Light',
    value: 'light',
    description: 'Clean and bright',
    preview: 'bg-white'
  },
  {
    name: 'Dark',
    value: 'dark',
    description: 'Easy on the eyes',
    preview: 'bg-gray-900'
  },
  {
    name: 'System',
    value: 'system',
    description: 'Follow system',
    preview: 'bg-gradient-to-r from-white to-gray-900'
  }
]

const setTheme = (theme: string) => {
  currentTheme.value = theme
}

const saveAppearanceSettings = () => {
  // Save appearance settings to localStorage or API
  localStorage.setItem('theme', currentTheme.value)
  localStorage.setItem('compactMode', compactMode.value.toString())
  localStorage.setItem('animations', animations.value.toString())
  
  showNotification('Appearance settings saved!', 'success')
  emit('close')
}

// Helper functions
const formatMemberSince = (dateString: string): string => {
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'short'
  })
}
</script>
