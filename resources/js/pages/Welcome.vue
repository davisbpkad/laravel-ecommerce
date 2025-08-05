<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="max-w-md mx-auto text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                {{ message || 'Laravel E-commerce' }}
            </h1>
            <p class="text-gray-600 mb-8">
                {{ status || 'Your application is starting up...' }}
            </p>
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
            <p class="text-sm text-gray-500 mt-4">
                Please wait while we initialize the application.
            </p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    message: String,
    status: String
})
</script>
