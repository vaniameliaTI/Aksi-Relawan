<script setup>
defineEmits(['close']);
</script>

<template>
  <div 
    class="py-1"
    @mouseleave="$emit('close')"
  >
    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tentang Aksi Relawan</a>
    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Visi Misi & Program</a>
    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Donasi</a>
    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kontak Kami</a>
  </div>
</template>

<style scoped>
/* Add any custom styles if needed */
</style>
