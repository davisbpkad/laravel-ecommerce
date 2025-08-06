<template>
  <SettingsLayout 
    title="Profile Settings" 
    description="Manage your admin profile information and security settings"
  >
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Information -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Profile Info Card -->
          <div class="bg-card border border-border rounded-lg p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-card-foreground mb-6">Profile Information</h2>
            
            <form @submit.prevent="updateProfile" class="space-y-6">
              
              <!-- Form Fields -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-card-foreground mb-2">
                    Full Name *
                  </label>
                  <input
                    v-model="profileForm.name"
                    type="text"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter your full name"
                    required
                  />
                  <div v-if="profileForm.errors.name" class="text-destructive text-sm mt-1">
                    {{ profileForm.errors.name }}
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-card-foreground mb-2">
                    Email Address *
                  </label>
                  <input
                    v-model="profileForm.email"
                    type="email"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter your email"
                    required
                  />
                  <div v-if="profileForm.errors.email" class="text-destructive text-sm mt-1">
                    {{ profileForm.errors.email }}
                  </div>
                </div>

                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-card-foreground mb-2">
                    Phone Number
                  </label>
                  <input
                    v-model="profileForm.phone"
                    type="tel"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="+62 812 3456 7890"
                  />
                  <div v-if="profileForm.errors.phone" class="text-destructive text-sm mt-1">
                    {{ profileForm.errors.phone }}
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="flex justify-end">
                <Button
                  type="submit"
                  :disabled="profileForm.processing"
                >
                  <svg v-if="profileForm.processing" class="animate-spin -ml-1 mr-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ profileForm.processing ? 'Updating...' : 'Update Profile' }}
                </Button>
              </div>
            </form>
          </div>

          <!-- Change Password Card -->
          <div class="bg-card border border-border rounded-lg p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-card-foreground mb-6">Change Password</h2>
            
            <form @submit.prevent="updatePassword" class="space-y-6">
              <div>
                <label class="block text-sm font-medium text-card-foreground mb-2">
                  Current Password *
                </label>
                <input
                  v-model="passwordForm.current_password"
                  type="password"
                  class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="Enter current password"
                  required
                />
                <div v-if="passwordForm.errors.current_password" class="text-destructive text-sm mt-1">
                  {{ passwordForm.errors.current_password }}
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-card-foreground mb-2">
                    New Password *
                  </label>
                  <input
                    v-model="passwordForm.password"
                    type="password"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter new password"
                    required
                  />
                  <div v-if="passwordForm.errors.password" class="text-destructive text-sm mt-1">
                    {{ passwordForm.errors.password }}
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-card-foreground mb-2">
                    Confirm Password *
                  </label>
                  <input
                    v-model="passwordForm.password_confirmation"
                    type="password"
                    class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Confirm new password"
                    required
                  />
                </div>
              </div>

              <div class="bg-muted p-4 rounded-md">
                <p class="text-sm text-muted-foreground">
                  <strong>Password Requirements:</strong>
                </p>
                <ul class="text-xs text-muted-foreground mt-2 space-y-1">
                  <li>• At least 8 characters long</li>
                  <li>• Mix of uppercase and lowercase letters</li>
                  <li>• At least one number</li>
                  <li>• At least one special character</li>
                </ul>
              </div>

              <!-- Submit Button -->
              <div class="flex justify-end">
                <Button
                  type="submit"
                  :disabled="passwordForm.processing"
                  variant="destructive"
                >
                  <svg v-if="passwordForm.processing" class="animate-spin -ml-1 mr-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ passwordForm.processing ? 'Updating...' : 'Update Password' }}
                </Button>
              </div>
            </form>
          </div>
        </div>

        <!-- Account Information Sidebar -->
        <div class="space-y-6">
        
          <!-- Security Notice -->
          <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
              <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 15.5c-.77.833.192 2.5 1.732 2.5z" />
              </svg>
              <div>
                <h4 class="text-sm font-medium text-yellow-800">Security Reminder</h4>
                <p class="text-sm text-yellow-700 mt-1">
                  Always use a strong password and enable two-factor authentication when available.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
  </SettingsLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import SettingsLayout from '@/layouts/SettingsLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { useNotifications } from '@/composables/useNotifications'

interface User {
  id: number
  name: string
  email: string
  phone?: string
  avatar?: string
  role?: string
  email_verified_at?: string
  created_at: string
  updated_at: string
}

interface Props {
  user: User
}

const props = defineProps<Props>()
const { success, error, info } = useNotifications()

const avatarInput = ref<HTMLInputElement | null>(null)
const avatarPreview = ref<string | null>(null)

// Profile form
const profileForm = useForm({
  name: props.user.name,
  email: props.user.email,
  phone: props.user.phone || '',
  avatar: null as File | null
})

// Password form
const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: ''
})

// Handle avatar upload
const handleAvatarUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  
  if (file) {
    const reader = new FileReader()
    reader.onload = (e) => {
      avatarPreview.value = e.target?.result as string
    }
    reader.readAsDataURL(file)
    
    profileForm.avatar = file
  }
}

// Remove avatar
const removeAvatar = () => {
  if (confirm('Are you sure you want to remove your avatar?')) {
    router.delete(route('admin.settings.profile.remove-avatar'), {
      onSuccess: () => {
        success('Avatar removed successfully!')
        avatarPreview.value = null
      },
      onError: () => {
        error('Failed to remove avatar.')
      }
    })
  }
}

// Update profile
const updateProfile = () => {
  profileForm.put(route('admin.settings.profile.update'), {
    onSuccess: () => {
      success('Profile updated successfully!')
      avatarPreview.value = null
    },
    onError: () => {
      error('Failed to update profile. Please check the form.')
    }
  })
}

// Update password
const updatePassword = () => {
  passwordForm.put(route('admin.settings.profile.password'), {
    onSuccess: () => {
      success('Password updated successfully!')
      passwordForm.reset()
    },
    onError: () => {
      error('Failed to update password. Please check the form.')
    }
  })
}

// Quick actions
const downloadData = () => {
  info('Data download will be available soon.')
}

const viewActivity = () => {
  info('Activity log feature will be available soon.')
}
</script>
