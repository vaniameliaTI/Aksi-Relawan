<script setup>
defineEmits(['close']);
</script>

<template>
  <div 
    class="py-1 bg-custom-light rounded shadow"
    @mouseleave="$emit('close')"
  >
    <router-link to="/tentang" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-300 transition-colors duration-150">Tentang Aksi Relawan</router-link>
    <a href="#" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-300 transition-colors duration-150">Visi Misi & Program</a>
    <a href="#" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-300 transition-colors duration-150">Donasi</a>
    <a href="#" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-300 transition-colors duration-150">Kontak Kami</a>
  </div>
</template>

<style scoped>
.bg-custom-light {
  background-color: #E5E7EB;
}

.hover\:bg-gray-300:hover {
  background-color: #D1D5DB;
}
</style>
