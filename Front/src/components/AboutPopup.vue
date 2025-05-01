<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
defineEmits(['close']);
const showAboutPopup = ref(false);

const navItems = [
  { name: 'Beranda', path: '/' },
  { name: 'Cari Aktivitas', path: '/aktivitas' },
  { name: 'Cari Organisasi', path: '/organisasi' },
  { name: 'Tentang Kami', hasPopup: true, subPaths: ['/tentang', '/tentang/visi-misi-program', '/tentang/donasi', '/tentang/kontak-kami'] },
];

const isActive = (item) => {
  return router.currentRoute.value.path === item.path;
};

const isSubMenuActive = (item) => {
  return item.subPaths && item.subPaths.includes(router.currentRoute.value.path);
};

const handleNavItemClick = (item) => {
  if (!item.hasPopup) {
    router.push(item.path);
  }
};

const handleSubMenuClick = (path, event) => {
  event.preventDefault();
  if (router.currentRoute.value.path === path) {
    window.location.reload();
  } else {
    router.push(path);
  }
  // Tutup popup setelah navigasi
  emit('close');
};
</script>

<template>
  <div 
    class="py-1 bg-custom-light rounded shadow"
    @mouseleave="$emit('close')"
  >
    <a 
      href="/tentang" 
      class="block px-4 py-2 text-sm text-black hover:bg-gray-300 transition-colors duration-150"
      @click="handleSubMenuClick('/tentang', $event)"
    >
      Tentang Aksi Relawan
    </a>
    <a 
      href="/tentang/visi-misi-program" 
      class="block px-4 py-2 text-sm text-black hover:bg-gray-300 transition-colors duration-150"
      @click="handleSubMenuClick('/tentang/visi-misi-program', $event)"
    >
      Visi Misi & Program
    </a>
    <a 
      href="/tentang/donasi" 
      class="block px-4 py-2 text-sm text-black hover:bg-gray-300 transition-colors duration-150"
      @click="handleSubMenuClick('/tentang/donasi', $event)"
    >
      Donasi
    </a>
    <a 
      href="/tentang/kontak-kami" 
      class="block px-4 py-2 text-sm text-black hover:bg-gray-300 transition-colors duration-150"
      @click="handleSubMenuClick('/tentang/kontak-kami', $event)"
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

.nav-item a.active {
  color: #000000; /* Warna teks tetap hitam */
}

.nav-item a.active::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -2px;
  width: 100%;
  height: 2px;
  background-color: black; /* Garis bawah hitam */
}
</style>
