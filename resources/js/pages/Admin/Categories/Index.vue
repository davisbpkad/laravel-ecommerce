<template>
  <AdminLayout title="Categories">
    <div class="min-h-screen bg-background">
      <!-- Header -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-6">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-3xl font-bold text-foreground">Product Categories</h1>
              <p class="text-muted-foreground mt-2">Manage your product categories</p>
            </div>
            <div class="flex items-center space-x-2">
              <Button @click="openCreateModal" class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Category
              </Button>
            </div>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <!-- Categories List -->
        <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
          <div class="p-6">
            <div v-if="loading" class="text-center py-8">
              <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
              <p class="mt-2 text-muted-foreground">Loading categories...</p>
            </div>

            <div v-else-if="categories.length === 0" class="text-center py-8">
              <svg class="mx-auto h-12 w-12 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a.997.997 0 01-1.414 0l-7-7A1.997 1.997 0 013 12V7a4 4 0 014-4z" />
              </svg>
              <h3 class="mt-2 text-sm font-medium text-foreground">No categories</h3>
              <p class="mt-1 text-sm text-muted-foreground">Get started by creating a new category.</p>
              <div class="mt-6">
                <Button @click="openCreateModal">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Add Category
                </Button>
              </div>
            </div>

            <div v-else class="overflow-hidden">
              <table class="w-full">
                <thead class="bg-muted">
                  <tr>
                    <th class="text-left p-4 text-sm font-medium text-muted-foreground">Name</th>
                    <th class="text-left p-4 text-sm font-medium text-muted-foreground">Description</th>
                    <th class="text-left p-4 text-sm font-medium text-muted-foreground">Created</th>
                    <th class="text-right p-4 text-sm font-medium text-muted-foreground">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="category in categories" :key="category.id" class="border-t border-border hover:bg-muted/50">
                    <td class="p-4">
                      <div class="font-medium text-foreground">{{ category.name }}</div>
                    </td>
                    <td class="p-4">
                      <div class="text-muted-foreground">{{ category.description || '-' }}</div>
                    </td>
                    <td class="p-4">
                      <div class="text-sm text-muted-foreground">{{ formatDate(category.created_at) }}</div>
                    </td>
                    <td class="p-4 text-right">
                      <div class="flex items-center justify-end space-x-2">
                        <Button @click="openEditModal(category)" variant="outline" size="sm">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                          </svg>
                        </Button>
                        <Button @click="deleteCategory(category)" variant="outline" size="sm" class="text-destructive hover:bg-destructive hover:text-destructive-foreground">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </Button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] w-full max-w-md mx-4">
        <div class="p-6">
          <h3 class="text-lg font-semibold text-foreground mb-4">
            {{ editingCategory ? 'Edit Category' : 'Create Category' }}
          </h3>
          
          <form @submit.prevent="saveCategory">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-2">Name</label>
                <input
                  v-model="form.name"
                  type="text"
                  required
                  class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="Category name"
                />
              </div>
              
              <div>
                <label class="block text-sm font-medium text-foreground mb-2">Description</label>
                <textarea
                  v-model="form.description"
                  rows="3"
                  class="w-full px-3 py-2 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  placeholder="Category description (optional)"
                ></textarea>
              </div>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
              <Button @click="closeModal" variant="outline" type="button">
                Cancel
              </Button>
              <Button type="submit" :disabled="saving">
                <svg v-if="saving" class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ saving ? 'Saving...' : (editingCategory ? 'Update' : 'Create') }}
              </Button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import Button from '@/components/ui/button/Button.vue'

// Types
interface Category {
  id: number
  name: string
  description?: string
  created_at: string
  updated_at: string
}

// Reactive data
const categories = ref<Category[]>([])
const loading = ref(true)
const showModal = ref(false)
const saving = ref(false)
const editingCategory = ref<Category | null>(null)

const form = ref({
  name: '',
  description: ''
})

// Methods
const loadCategories = async () => {
  try {
    loading.value = true
    const response = await fetch('/api/categories')
    const result = await response.json()
    categories.value = result.data
  } catch (error) {
    console.error('Failed to load categories:', error)
  } finally {
    loading.value = false
  }
}

const openCreateModal = () => {
  editingCategory.value = null
  form.value = { name: '', description: '' }
  showModal.value = true
}

const openEditModal = (category: Category) => {
  editingCategory.value = category
  form.value = {
    name: category.name,
    description: category.description || ''
  }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingCategory.value = null
  form.value = { name: '', description: '' }
}

const saveCategory = async () => {
  try {
    saving.value = true
    
    const url = editingCategory.value 
      ? `/api/categories/${editingCategory.value.id}`
      : '/api/categories'
    
    const method = editingCategory.value ? 'PUT' : 'POST'
    
    const response = await fetch(url, {
      method,
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(form.value)
    })
    
    if (response.ok) {
      await loadCategories()
      closeModal()
    } else {
      console.error('Failed to save category')
    }
  } catch (error) {
    console.error('Error saving category:', error)
  } finally {
    saving.value = false
  }
}

const deleteCategory = async (category: Category) => {
  if (!confirm(`Are you sure you want to delete "${category.name}"?`)) {
    return
  }
  
  try {
    const response = await fetch(`/api/categories/${category.id}`, {
      method: 'DELETE'
    })
    
    if (response.ok) {
      await loadCategories()
    } else {
      console.error('Failed to delete category')
    }
  } catch (error) {
    console.error('Error deleting category:', error)
  }
}

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  })
}

// Load categories on mount
onMounted(() => {
  loadCategories()
})
</script>
