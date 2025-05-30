<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
      <button
        @click="$emit('close')"
        class="absolute top-4 right-4 text-gray-600 hover:text-gray-900"
        aria-label="Close modal"
      >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <img
        v-if="organization.image"
        :src="organization.image"
        alt="Organization Logo"
        class="w-32 h-32 object-contain rounded-md mx-auto mb-4"
      />
      <h2 class="text-2xl font-bold mb-2 text-center">{{ organization.nama }}</h2>
      <p class="text-center text-gray-600 mb-4">{{ organization.kategori }}</p>
      <div class="text-gray-700 text-sm space-y-2">
        <p><strong>Email:</strong> {{ organization.email }}</p>
        <p><strong>No Telepon:</strong> {{ organization.no_telp }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  organization: {
    type: Object,
    required: true
  }
});
</script>

<style scoped>
/* Add any additional styling if needed */
</style>
