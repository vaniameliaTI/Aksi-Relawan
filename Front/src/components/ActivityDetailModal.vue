<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
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
        v-if="activity.image"
        :src="activity.image"
        alt="Activity Image"
        class="w-full h-48 object-cover rounded-md mb-4"
      />
      <h2 class="text-2xl font-bold mb-2">{{ activity.title }}</h2>
      <p class="text-sm text-gray-600 mb-2">{{ activity.organization }}</p>
      <div class="flex flex-wrap gap-2 mb-4">
        <span
          v-for="(category, index) in activity.categories"
          :key="index"
          class="px-2 py-1 text-xs rounded-full font-medium"
          :class="category === 'Event' ? 'bg-blue-100 text-blue-600' :
                  category === 'Mitigasi Bencana' ? 'bg-purple-100 text-purple-600' :
                  category === 'Lingkungan' ? 'bg-green-100 text-green-600' :
                  category === 'Pendidikan' ? 'bg-yellow-100 text-yellow-600' :
                  'bg-gray-100 text-gray-600'"
        >
          {{ category }}
        </span>
      </div>
      <div class="text-gray-700 text-sm space-y-1 mb-4">
        <div class="flex items-center">
          <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>{{ activity.date }}</span>
        </div>
        <div class="flex items-center">
          <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>{{ activity.location }}</span>
        </div>
      </div>
      <p v-if="activity.description" class="text-gray-700 text-sm whitespace-pre-line">{{ activity.description }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  activity: {
    type: Object,
    required: true
  }
});
</script>

<style scoped>
/* Add any additional styling if needed */
</style>
