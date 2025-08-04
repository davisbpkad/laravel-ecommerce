<template>
  <div class="fixed top-4 right-4 z-50 space-y-2">
    <Notification
      v-for="notification in notifications"
      :key="notification.id"
      :type="notification.type"
      :title="notification.title"
      :message="notification.message"
      :duration="notification.duration"
      @close="removeNotification(notification.id)"
    />
  </div>
</template>

<script setup lang="ts">
import { useNotifications } from '@/composables/useNotifications'
import Notification from './Notification.vue'

const { notifications, removeNotification } = useNotifications()
</script>
