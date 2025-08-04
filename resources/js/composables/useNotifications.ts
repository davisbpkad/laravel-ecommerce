import { ref, reactive } from 'vue'

export interface NotificationItem {
  id: string
  type: 'success' | 'error' | 'warning' | 'info'
  title?: string
  message: string
  duration?: number
}

const notifications = ref<NotificationItem[]>([])

let notificationId = 0

export const useNotifications = () => {
  const addNotification = (notification: Omit<NotificationItem, 'id'>) => {
    const id = `notification-${++notificationId}`
    const newNotification: NotificationItem = {
      id,
      duration: 5000,
      ...notification
    }
    
    notifications.value.push(newNotification)
    
    return id
  }

  const removeNotification = (id: string) => {
    const index = notifications.value.findIndex(n => n.id === id)
    if (index > -1) {
      notifications.value.splice(index, 1)
    }
  }

  const clearAll = () => {
    notifications.value = []
  }

  // Convenience methods
  const success = (message: string, title?: string, duration?: number) => {
    return addNotification({ type: 'success', message, title, duration })
  }

  const error = (message: string, title?: string, duration?: number) => {
    return addNotification({ type: 'error', message, title, duration })
  }

  const warning = (message: string, title?: string, duration?: number) => {
    return addNotification({ type: 'warning', message, title, duration })
  }

  const info = (message: string, title?: string, duration?: number) => {
    return addNotification({ type: 'info', message, title, duration })
  }

  return {
    notifications,
    addNotification,
    removeNotification,
    clearAll,
    success,
    error,
    warning,
    info
  }
}
