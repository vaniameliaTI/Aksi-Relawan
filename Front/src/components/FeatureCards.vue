<script setup>
// No props or data needed for this component
</script>

<template>
  <div class="bg-white rounded-3xl py-6 px-12 w-full max-w-xl mx-auto -mt-16 relative z-20 shadow-lg">
    <div class="flex justify-between items-center">
      <!-- Relawan -->
      <div class="flex flex-col items-center">
        <div class="w-14 h-14 mb-2 text-blue-600">
          <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
            <path d="M9 11a4 4 0 100-8 4 4 0 000 8zm0-6a2 2 0 110 4 2 2 0 010-4z"/>
            <path d="M17 13a3 3 0 100-6 3 3 0 000 6zm0-4a1 1 0 110 2 1 1 0 010-2z"/>
            <path d="M12 14H6a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6z"/>
            <path d="M20.59 16.59A5 5 0 0018 16h-2v6h8v-1a5 5 0 00-3.41-4.41z"/>
          </svg>
        </div>
        <span class="text-gray-900 font-medium">Relawan</span>
      </div>

      <!-- Organisasi -->
      <div class="flex flex-col items-center">
        <div class="w-14 h-14 mb-2 text-blue-600">
          <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
            <!-- Gear (outer circle) -->
            <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
            
            <!-- People in center -->
            <circle cx="12" cy="12" r="2.5" fill="white"/>
            <circle cx="10.5" cy="11" r="1" fill="currentColor"/>
            <circle cx="13.5" cy="11" r="1" fill="currentColor"/>
            <path d="M12 13.5c-1 0-2 .5-2.5 1.2.7.8 1.5 1.3 2.5 1.3s1.8-.5 2.5-1.3c-.5-.7-1.5-1.2-2.5-1.2z" fill="currentColor"/>
          </svg>
        </div>
        <span class="text-gray-900 font-medium">Organisasi</span>
      </div>

      <!-- Aktivitas -->
      <div class="flex flex-col items-center">
        <div class="w-14 h-14 mb-2 text-blue-600">
          <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
            <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
          </svg>
        </div>
        <span class="text-gray-900 font-medium">Aktivitas</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.text-blue-600 {
  color: #2563eb;
}
</style>
