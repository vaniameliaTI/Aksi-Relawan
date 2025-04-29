<script setup>
import { useRouter } from 'vue-router';
const router = useRouter();
defineEmits(['close']);

const handleSubMenuClick = (to, event) => {
  event.preventDefault();
  if (router.currentRoute.value.name === to) {
    window.location.reload();
  } else {
    router.push({ name: to });
  }
};
</script>

<template>
  <div 
    class="py-1 bg-custom-light rounded shadow"
    @mouseleave="$emit('close')"
  >
    <a 
      href="/tentang" 
      class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-300 transition-colors duration-150"
      @click="handleSubMenuClick('about', $event)"
    >
      Tentang Aksi Relawan
    </a>
    <a 
      href="/tentang/visi-misi-program" 
      class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-300 transition-colors duration-150"
      @click="handleSubMenuClick('VisiMisiProgram', $event)"
    >
      Visi Misi & Program
    </a>
    <a 
      href="/tentang/donasi" 
      class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-300 transition-colors duration-150"
      @click="handleSubMenuClick('donasi', $event)"
    >
      Donasi
    </a>
<a 
  href="/tentang/kontak-kami" 
  class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-300 transition-colors duration-150"
  @click="handleSubMenuClick('kontakKami', $event)"
>
  Kontak Kami
</a>
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
