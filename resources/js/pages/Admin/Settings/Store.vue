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

          <!-- Store Logo Upload -->
          <div class="mt-6">
            <label class="block text-sm font-medium text-card-foreground mb-2">
              Store Logo
            </label>
            <div class="flex items-center space-x-4">
              <div class="w-16 h-16 border-2 border-dashed border-border rounded-lg flex items-center justify-center bg-muted">
                <img
                  v-if="logoPreview"
                  :src="logoPreview"
                  alt="Store Logo"
                  class="w-full h-full object-cover rounded-lg"
                />
                <svg v-else class="w-6 h-6 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="flex-1">
                <input
                  ref="logoInput"
                  type="file"
                  accept="image/*"
                  @change="handleLogoUpload"
                  class="hidden"
                />
                <Button
                  type="button"
                  variant="outline"
                  @click="logoInput?.click()"
                >
                  Upload Logo
                </Button>
                <p class="text-xs text-muted-foreground mt-1">
                  Recommended: 200x200px, PNG or JPG, max 2MB
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Shipping Settings -->
        <div class="bg-card border border-border rounded-lg p-6 shadow-sm">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h2 class="text-lg font-semibold text-card-foreground">Shipping Settings</h2>
              <p class="text-sm text-muted-foreground">Configure shipping options and costs</p>
            </div>
            <Button 
              type="button" 
              variant="outline" 
              size="sm"
              @click="resetGroup('shipping')"
            >
              Reset to Default
            </Button>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">
                Free Shipping Threshold
              </label>
              <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground">
                  {{ form.settings.currency_symbol || 'Rp' }}
                </span>
                <input
                  v-model="form.settings.free_shipping_threshold"
                  type="number"
                  min="0"
                  class="w-full pl-10 pr-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="100000"
                />
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">
                Standard Shipping Cost
              </label>
              <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground">
                  {{ form.settings.currency_symbol || 'Rp' }}
                </span>
                <input
                  v-model="form.settings.standard_shipping_cost"
                  type="number"
                  min="0"
                  class="w-full pl-10 pr-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="15000"
                />
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">
                Express Shipping Cost
              </label>
              <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground">
                  {{ form.settings.currency_symbol || 'Rp' }}
                </span>
                <input
                  v-model="form.settings.express_shipping_cost"
                  type="number"
                  min="0"
                  class="w-full pl-10 pr-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="25000"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- SEO Settings -->
        <div class="bg-card border border-border rounded-lg p-6 shadow-sm">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h2 class="text-lg font-semibold text-card-foreground">SEO Settings</h2>
              <p class="text-sm text-muted-foreground">Search engine optimization settings</p>
            </div>
            <Button 
              type="button" 
              variant="outline" 
              size="sm"
              @click="resetGroup('seo')"
            >
              Reset to Default
            </Button>
          </div>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">
                SEO Title
              </label>
              <input
                v-model="form.settings.seo_title"
                type="text"
                class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="Your Store - Description"
              />
              <p class="text-xs text-muted-foreground mt-1">
                Recommended: 50-60 characters
              </p>
            </div>

            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">
                SEO Description
              </label>
              <textarea
                v-model="form.settings.seo_description"
                rows="3"
                class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="Brief description for search engines"
              ></textarea>
              <p class="text-xs text-muted-foreground mt-1">
                Recommended: 150-160 characters
              </p>
            </div>

            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">
                SEO Keywords
              </label>
              <input
                v-model="form.settings.seo_keywords"
                type="text"
                class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="keyword1, keyword2, keyword3"
              />
              <p class="text-xs text-muted-foreground mt-1">
                Separate keywords with commas
              </p>
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

        <!-- Maintenance Settings -->
        <div class="bg-card border border-border rounded-lg p-6 shadow-sm">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h2 class="text-lg font-semibold text-card-foreground">Maintenance</h2>
              <p class="text-sm text-muted-foreground">Site maintenance options</p>
            </div>
            <Button 
              type="button" 
              variant="outline" 
              size="sm"
              @click="resetGroup('maintenance')"
            >
              Reset to Default
            </Button>
          </div>

          <div class="space-y-4">
            <div class="flex items-center space-x-3">
              <input
                v-model="form.settings.maintenance_mode"
                type="checkbox"
                id="maintenance_mode"
                class="w-4 h-4 text-primary bg-background border-border rounded focus:ring-ring focus:ring-2"
              />
              <label for="maintenance_mode" class="text-sm font-medium text-card-foreground">
                Enable Maintenance Mode
              </label>
            </div>
            <p class="text-xs text-muted-foreground ml-7">
              When enabled, only administrators can access the site
            </p>

            <div>
              <label class="block text-sm font-medium text-card-foreground mb-2">
                Maintenance Message
              </label>
              <textarea
                v-model="form.settings.maintenance_message"
                rows="3"
                class="w-full px-3 py-2 border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="Message to display during maintenance"
              ></textarea>
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
