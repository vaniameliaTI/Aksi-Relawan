<script setup>
import { ref, computed, onMounted } from 'vue';
import { gsap } from 'gsap';
import AuthModal from './AuthModal.vue';
import AboutPopup from './AboutPopup.vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const showAuthModal = ref(false);
const authMode = ref('login');
const showAboutPopup = ref(false);

const isLoggedIn = computed(() => {
  return localStorage.getItem('token') !== null;
});

const navItems = [
  { name: 'Beranda', path: '/' },
  { name: 'Cari Aktivitas', path: '/aktivitas' },
  { name: 'Cari Organisasi', path: '/organisasi' },
  { 
    name: 'Tentang Kami', 
    hasPopup: true
  }
];

const handleNavItemClick = (item) => {
  if (item.path) {
    if (router.currentRoute.value.path === item.path) {
      // If clicking the same route, reload the page
      window.location.reload();
    } else {
      router.push(item.path);
    }
  }
};

const openLoginModal = () => {
  authMode.value = 'login';
  showAuthModal.value = true;
};

const openRegisterModal = () => {
  authMode.value = 'register';
  showAuthModal.value = true;
};

const handleLoginSuccess = () => {
  window.location.reload();
};

const handleLogout = () => {
  // Hapus semua data terkait user
  localStorage.removeItem('token');
  localStorage.removeItem('user');
  // Hapus semua item localStorage yang tidak dikenali (untuk berjaga-jaga)
  for (let i = 0; i < localStorage.length; i++) {
    const key = localStorage.key(i);
    if (key && key.match(/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/)) {
      localStorage.removeItem(key);
    }
  }
  window.location.reload();
};

const goToProfile = () => {
  router.push('/profile');
};

const isActive = (item) => {
  return router.currentRoute.value.path === item.path;
};

const isSubMenuActive = (item) => {
  return showAboutPopup.value && item.hasPopup;
};

onMounted(() => {
  // Animasi untuk logo
  gsap.from('.nav-logo', {
    duration: 1,
    x: -50,
    opacity: 0,
    ease: 'power3.out'
  });

  // Animasi untuk menu items
  gsap.from('.nav-item', {
    duration: 0.8,
    y: 20,
    opacity: 0,
    stagger: 0.1,
    ease: 'power3.out'
  });

  // Animasi untuk auth buttons
  gsap.from('.auth-button', {
    duration: 1,
    x: 50,
    opacity: 0,
    delay: 0.5,
    ease: 'power3.out'
  });
});
</script>

<template>
  <nav class="bg-white shadow-md py-4 fixed w-full top-0 z-50">
    <div class="container mx-auto px-4 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center nav-logo">
        <img src="../assets/images/icons/AksiRelawan.png" alt="AksiRelawan Logo" class="h-11 mr-2" />
        <div class="font-bold text-2xl text-black-800">Aksi Relawan</div>
      </div>
      
      <!-- Navigation Links -->
      <div class="hidden md:flex space-x-8">
        <div v-for="item in navItems" :key="item.name" class="relative group nav-item">
          <router-link 
            v-if="!item.hasPopup"
            :to="item.path"
            class="text-gray-700 hover:text-blue-900 transition-colors"
            :class="{ active: isActive(item) }"
          >
            {{ item.name }}
          </router-link>
          <div v-else>
            <a 
              href="#"
              class="text-gray-700 hover:text-blue-900 transition-colors cursor-pointer"
              :class="{ active: isSubMenuActive(item) }"
              @mouseenter="showAboutPopup = true"
            >
              {{ item.name }}
            </a>
            <AboutPopup 
              v-if="item.hasPopup && showAboutPopup" 
              @close="showAboutPopup = false"
              class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
            />
          </div>
        </div>
      </div>
      
      <!-- Auth Buttons -->
      <div class="flex space-x-4 auth-button" v-if="!isLoggedIn">
        <button @click="openLoginModal" class="btn-login">
          Masuk
        </button>
        <button @click="openRegisterModal" class="btn-register">
          Daftar
        </button>
      </div>

      <!-- Profile Menu -->
      <div class="flex items-center space-x-4 auth-button" v-else>
        <button @click="goToProfile" class="px-4 py-2 text-blue-900 font-medium rounded-lg hover:text-blue-700 transition-colors">
          Profil
        </button>
        <button @click="handleLogout" class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
          Keluar
        </button>
      </div>
    </div>
  </nav>
  
  <!-- Spacer -->
  <div class="h-16"></div>

  <!-- Auth Modal -->
  <AuthModal 
    v-if="showAuthModal"
    :initial-mode="authMode"
    @close="showAuthModal = false"
    @login-success="handleLoginSuccess"
  />
</template>

<style scoped>
/* Default style for navbar links */
.nav-item a {
  position: relative; /* Dibutuhkan untuk pseudo-element */
  text-decoration: none; /* Hilangkan underline default */
  color: #000000; /* Warna teks tetap hitam */
  font-weight: 400; /* Berat font default */
  transition: color 0.3s ease; /* Transisi untuk warna teks */
}

/* Pseudo-element for underline */
.nav-item a::after {
  content: ''; /* Pseudo-element kosong */
  position: absolute;
  left: 0;
  bottom: -2px; /* Jarak underline dari teks */
  width: 0; /* Awalnya tidak terlihat */
  height: 2px; /* Ketebalan underline */
  background-color: black; /* Warna garis bawah */
  transition: width 0.3s ease; /* Transisi untuk animasi */
}

/* Hover effect for navbar links */
.nav-item a:hover {
  color: #000000; /* Warna teks tetap hitam saat hover */
}

.nav-item a:hover::after {
  width: 100%; /* Underline meluas ke seluruh teks */
}

/* Active link style */
.nav-item a.active {
  color: #000000; /* Warna teks tetap hitam */
}

.nav-item a.active::after {
  width: 100%; /* Garis bawah penuh untuk link aktif */
}

/* Style for "Masuk" and "Daftar" buttons */
.auth-button button {
  display: inline-block; /* Membuat tombol hanya selebar kontennya */
  padding: 0.5rem 1rem; /* Padding untuk ukuran tombol */
  background-color: transparent; /* Latar belakang transparan */
  color: #000000; /* Warna teks default (hitam) */
  font-size: 1rem; /* Ukuran font */
  font-weight: 500; /* Berat font default */
  text-align: center; /* Teks rata tengah */
  border: none; /* Hilangkan border default */
  cursor: pointer; /* Menunjukkan tombol dapat diklik */
  transition: color 0.3s ease; /* Transisi untuk warna teks */
}

/* Hover effect for "Masuk" and "Daftar" buttons */
.auth-button button:hover {
  color: #000000; /* Warna teks tetap hitam saat hover */
}

/* Style for "Masuk" button */
.auth-button .btn-login {
  display: inline-block; /* Membuat tombol hanya selebar kontennya */
  padding: 0.5rem 1rem; /* Padding untuk ukuran tombol */
  background-color: transparent; /* Latar belakang transparan */
  color: #1e3a8a; /* Warna teks biru (default) */
  font-size: 1rem; /* Ukuran font */
  font-weight: 500; /* Berat font default */
  text-align: center; /* Teks rata tengah */
  border: none; /* Hilangkan border default */
  cursor: pointer; /* Menunjukkan tombol dapat diklik */
  transition: color 0.3s ease; /* Transisi untuk warna teks */
}

/* Hover effect for "Masuk" button */
.auth-button .btn-login:hover {
  color: #000000; /* Warna teks berubah menjadi hitam saat hover */
}

/* Style for "Daftar" button */
.auth-button .btn-register {
  display: inline-block; /* Membuat tombol hanya selebar kontennya */
  padding: 0.5rem 1rem; /* Padding untuk ukuran tombol */
  background-color: #1e3a8a; /* Warna latar belakang biru (default) */
  color: #ffffff; /* Warna teks putih */
  font-size: 1rem; /* Ukuran font */
  font-weight: 500; /* Berat font default */
  text-align: center; /* Teks rata tengah */
  border: none; /* Hilangkan border default */
  border-radius: 9999px; /* Membuat tombol berbentuk pill */
  cursor: pointer; /* Menunjukkan tombol dapat diklik */
  transition: background-color 0.3s ease, color 0.3s ease; /* Transisi untuk warna */
}

/* Hover effect for "Daftar" button */
.auth-button .btn-register:hover {
  background-color: #000000; /* Warna latar belakang berubah menjadi hitam saat hover */
  color: #ffffff; /* Warna teks tetap putih saat hover */
}
</style>
