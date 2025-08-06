<template>
  <SettingsLayout 
    title="Store Settings" 
    description="Manage your store configuration and settings"
  >
    <!-- Settings Form -->
    <form @submit.prevent="updateSettings" class="space-y-8">
        <!-- General Settings -->
        <div class="bg-card border border-border rounded-lg p-6 shadow-sm">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h2 class="text-lg font-semibold text-card-foreground">General Settings</h2>
              <p class="text-sm text-muted-foreground">Basic store information</p>
            </div>
            <Button 
              type="button" 
              variant="outline" 
              size="sm"
              @click="resetGroup('general')"
            >
              Reset to Default
            </Button>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-card-foreground mb-2">
                  Store Name *
                </label>
                <input
                  v-model="form.settings.store_name"
                  type="text"
                  class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="Enter store name"
                  required
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-card-foreground mb-2">
                  Store Email
                </label>
                <input
                  v-model="form.settings.store_email"
                  type="email"
                  class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="store@example.com"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-card-foreground mb-2">
                  Store Phone
                </label>
                <input
                  v-model="form.settings.store_phone"
                  type="text"
                  class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="+62 21 1234 5678"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-card-foreground mb-2">
                  Currency
                </label>
                <select
                  v-model="form.settings.currency"
                  class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                >
                  <option value="IDR">Indonesian Rupiah (IDR)</option>
                  <option value="USD">US Dollar (USD)</option>
                  <option value="EUR">Euro (EUR)</option>
                </select>
              </div>
            </div>

            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-card-foreground mb-2">
                  Store Description
                </label>
                <textarea
                  v-model="form.settings.store_description"
                  rows="3"
                  class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="Brief description of your store"
                ></textarea>
              </div>

              <div>
                <label class="block text-sm font-medium text-card-foreground mb-2">
                  Store Address
                </label>
                <textarea
                  v-model="form.settings.store_address"
                  rows="3"
                  class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="Physical address of your store"
                ></textarea>
              </div>

              <div>
                <label class="block text-sm font-medium text-card-foreground mb-2">
                  Currency Symbol
                </label>
                <input
                  v-model="form.settings.currency_symbol"
                  type="text"
                  class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="Rp"
                />
              </div>
            </div>
          </div>
        </div>
        
        <!-- Social Media Settings -->
        <div class="bg-card border border-border rounded-lg p-6 shadow-sm">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h2 class="text-lg font-semibold text-card-foreground">Social Media</h2>
              <p class="text-sm text-muted-foreground">Your social media presence</p>
            </div>
            <Button 
              type="button" 
              variant="outline" 
              size="sm"
              @click="resetGroup('social')"
            >
              Reset to Default
            </Button>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">
                Facebook URL
              </label>
              <input
                v-model="form.settings.facebook_url"
                type="url"
                class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="https://facebook.com/yourstore"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">
                Instagram URL
              </label>
              <input
                v-model="form.settings.instagram_url"
                type="url"
                class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="https://instagram.com/yourstore"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">
                Twitter URL
              </label>
              <input
                v-model="form.settings.twitter_url"
                type="url"
                class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="https://twitter.com/yourstore"
              />
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4">
          <Button
            type="button"
            variant="outline"
            @click="resetForm"
          >
            Cancel
          </Button>
          <Button
            type="submit"
            :disabled="form.processing"
          >
            <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ form.processing ? 'Saving...' : 'Save Settings' }}
          </Button>
        </div>
      </form>
  </SettingsLayout>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import SettingsLayout from '@/layouts/SettingsLayout.vue'
import Button from '@/components/ui/button/Button.vue'
import { useNotifications } from '@/composables/useNotifications'

interface Setting {
  key: string
  value: any
  type: string
  label: string
  description: string
  is_public: boolean
}

interface Props {
  settings: Record<string, Setting[]>
}

const props = defineProps<Props>()
const { success, error, info } = useNotifications()

const logoInput = ref<HTMLInputElement | null>(null)
const logoPreview = ref<string | null>(null)

// Initialize form with current settings
const initializeFormData = () => {
  const formData: Record<string, any> = {}
  
  Object.values(props.settings).flat().forEach((setting: Setting) => {
    formData[setting.key] = setting.value
  })
  
  return formData
}

const form = useForm({
  settings: initializeFormData()
})

// Handle logo upload
const handleLogoUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  
  if (file) {
    const reader = new FileReader()
    reader.onload = (e) => {
      logoPreview.value = e.target?.result as string
    }
    reader.readAsDataURL(file)
    
    form.settings.store_logo = file
  }
}

// Update settings
const updateSettings = () => {
  form.put(route('admin.settings.store.update'), {
    onSuccess: () => {
      success('Store settings updated successfully!')
    },
    onError: (errors) => {
      error('Failed to update settings. Please check the form.')
    }
  })
}

// Reset form to original values
const resetForm = () => {
  form.settings = initializeFormData()
  logoPreview.value = null
}

// Reset specific group to defaults
const resetGroup = (group: string) => {
  if (confirm(`Are you sure you want to reset ${group} settings to default values?`)) {
    // This would typically make an API call to reset the group
    info(`${group} settings reset to default`)
  }
}

onMounted(() => {
  // Set logo preview if exists
  const storeLogo = props.settings.general?.find(s => s.key === 'store_logo')
  if (storeLogo?.value) {
    logoPreview.value = `/storage/${storeLogo.value}`
  }
})
</script>
