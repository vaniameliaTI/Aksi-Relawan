<script setup>
// No props or data needed for this component
</script>

<template>
  <div class="bg-white rounded-3xl py-6 px-12 w-full max-w-xl mx-auto -mt-24 relative z-20 shadow-lg">
    <div class="flex justify-between items-center">
      <!-- Relawan -->
      <div class="flex flex-col items-center">
        <div class="w-14 h-14 mb-2 text-footer-blue">
          <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="8" r="4"/>
            <path d="M6 20c0-3.31 5.33-5 6-5s6 1.69 6 5v1H6v-1z"/>
          </svg>
        </div>
        <span class="text-footer-blue font-medium">Relawan</span>
      </div>

      <!-- Organisasi -->
      <div class="flex flex-col items-center">
        <div class="w-14 h-14 mb-2 text-footer-blue">
          <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
          </svg>
        </div>
        <span class="text-footer-blue font-medium">Organisasi</span>
      </div>

      <!-- Aktivitas -->
      <div class="flex flex-col items-center">
        <div class="w-14 h-14 mb-2 text-footer-blue">
          <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
            <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
          </svg>
        </div>
        <span class="text-footer-blue font-medium">Aktivitas</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.text-footer-blue {
  color: #1e3a8a;
}
</style>
