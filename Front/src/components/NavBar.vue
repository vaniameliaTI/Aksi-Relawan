<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { gsap } from 'gsap';
import AuthModal from './AuthModal.vue';
import AboutPopup from './AboutPopup.vue';
import { useRouter } from 'vue-router';
import AksiRelawanIcon from '../assets/images/icons/AksiRelawan.png';
import UserIcon from '../assets/images/icons/iconuser.png';

const router = useRouter();
const showAuthModal = ref(false);
const authMode = ref('login');
const showAboutPopup = ref(false);
const showProfilePopup = ref(false);

import { watch } from 'vue';

let user = ref(null);

watch(user, (newVal, oldVal) => {
  // Close profile popup when user data changes to avoid stale info
  if (showProfilePopup.value) {
    showProfilePopup.value = false;
  }
});

function loadUserFromLocalStorage() {
  try {
    const userData = localStorage.getItem('user');
    if (userData) {
      const parsedUser = JSON.parse(userData);
      // Ensure profilePicture is set to actual photo or fallback to UserIcon
      if (!parsedUser.profilePicture || parsedUser.profilePicture === '') {
        // If profilePicture is empty or missing, try to fetch fresh profile photo from backend
        fetchUserProfile().then(freshUser => {
          if (freshUser && freshUser.profilePicture) {
            parsedUser.profilePicture = freshUser.profilePicture;
            localStorage.setItem('user', JSON.stringify(parsedUser));
            user.value = parsedUser;
          } else {
            parsedUser.profilePicture = UserIcon;
            user.value = parsedUser;
          }
        }).catch(() => {
          parsedUser.profilePicture = UserIcon;
          user.value = parsedUser;
        });
      } else {
        user.value = parsedUser;
      }
    } else {
      user.value = null;
    }
  } catch (e) {
    user.value = null;
  }
}

async function fetchUserProfile() {
  try {
    const response = await fetch('http://localhost:8080/api/profile', {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      }
    });
    if (response.ok) {
      const data = await response.json();
      if (data && data.status === 'success' && data.data) {
        let photoUrl = data.data.photo_url || '';
        // If photoUrl is relative path, prepend backend base URL
        if (photoUrl && !photoUrl.startsWith('http')) {
          photoUrl = 'http://localhost:8080/' + photoUrl.replace(/^\/+/, '');
        }
        return {
          profilePicture: photoUrl || UserIcon
        };
      }
    }
  } catch (error) {
    console.error('Failed to fetch user profile:', error);
  }
  return null;
}

loadUserFromLocalStorage();

function onStorageChange(event) {
  if (event.key === 'user') {
    loadUserFromLocalStorage();
  }
}

function onProfilePhotoUpdated() {
  console.log('profilePhotoUpdated event received');
  loadUserFromLocalStorage();
  console.log('User data reloaded:', user.value);
}

function onUserProfileUpdated() {
  loadUserFromLocalStorage();
  // Additional logging for debugging
  console.log('User profile updated event received, user data reloaded:', user.value);
}

onMounted(() => {
  window.addEventListener('storage', onStorageChange);
  window.addEventListener('profilePhotoUpdated', onProfilePhotoUpdated);
  window.addEventListener('userProfileUpdated', onUserProfileUpdated);
});

onBeforeUnmount(() => {
  window.removeEventListener('storage', onStorageChange);
  window.removeEventListener('profilePhotoUpdated', onProfilePhotoUpdated);
  window.removeEventListener('userProfileUpdated', onUserProfileUpdated);
});

function openLoginModal() {
  authMode.value = 'login';
  showAuthModal.value = true;
}

function openRegisterModal() {
  authMode.value = 'register';
  showAuthModal.value = true;
}

// Add a function to handle the navigation item click
function handleNavItemClick(item) {
  if (item.path) {
    if (router.currentRoute.value.path === item.path) {
      // If clicking the same route, reload the page
      window.location.reload();
    } else {
      router.push(item.path);
    }
  }
}

// Add a function to handle the login success
function handleLoginSuccess() {
  // Instead of reloading the page, update user data and close modal to avoid flicker
  loadUserFromLocalStorage();
  showAuthModal.value = false;
  // Avoid redirecting to profile page on login success to prevent flicker
  // Redirect to the current page to keep user on the same page after login
  const currentPath = router.currentRoute.value.fullPath;
  router.replace(currentPath);
}

// Add a function to handle the logout
function handleLogout() {
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
  showProfilePopup.value = false;
}

// Add a function to handle the profile button click
function toggleProfilePopup() {
  showProfilePopup.value = !showProfilePopup.value;
}

// Add a computed property to check if the user is logged in
const isLoggedIn = computed(() => {
  return localStorage.getItem('token') !== null;
});

// Add a computed property to check if the navigation item is active
const isActive = (item) => {
  return router.currentRoute.value.path === item.path;
};

// Add a computed property to check if the sub menu is active
const isSubMenuActive = (item) => {
  // Keep active if current route path starts with /tentang for "Tentang Kami" submenu
  if (item.hasPopup && router.currentRoute.value.path.startsWith('/tentang')) {
    return true;
  }
  return showAboutPopup.value && item.hasPopup;
};

// Add a mounted lifecycle hook to animate the logo and auth buttons
onMounted(() => {
  // Animasi untuk logo dan auth buttons bersama-sama dengan animasi yang sama
  gsap.from('.nav-logo-content', {
    duration: 1,
    x: -50,
    opacity: 0,
    ease: 'power3.out'
  });

  gsap.from('.auth-button', {
    duration: 1,
    x: 50,
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

  // Removed automatic opening of login modal on initial load to show only buttons
  // if (!localStorage.getItem('token')) {
  //   openLoginModal();
  // }
});

const navItems = [
  { name: 'Beranda', path: '/home' },
  { name: 'Cari Aktivitas', path: '/aktivitas' },
  { name: 'Cari Organisasi', path: '/organisasi' },
  { 
    name: 'Tentang Kami', 
    hasPopup: true
  }
];

// Method to handle profile photo click
function onProfilePhotoClick() {
  showProfilePopup.value = false;
  router.push('/profile');
}

// Method to handle profile photo click with reload
function onProfilePhotoClickWithReload() {
  showProfilePopup.value = false;
  router.push('/profile').then(() => {
    window.location.reload();
  });
}

// Method to handle mouse leave on "Tentang Kami" nav item
function onAboutMouseLeave() {
  showAboutPopup.value = false;
}
</script>

<template>
  <nav class="bg-white shadow-md py-4 fixed w-full top-0 z-50">
    <div class="container mx-auto px-4 flex justify-between items-center">
      <!-- Logo -->
<a
  href="#"
  class="flex items-center nav-logo cursor-pointer"
  @click.prevent="handleNavItemClick({ path: '/home' })"
>
        <div class="nav-logo-content flex items-center">
          <img :src="AksiRelawanIcon" alt="AksiRelawan Logo" class="h-11 mr-2" />
          <div class="font-bold text-xl text-black-800">Aksi Relawan</div>
        </div>
      </a>
      
      <!-- Navigation Links -->
      <div class="hidden md:flex space-x-8">
        <div v-for="item in navItems" :key="item.name" class="relative group nav-item">
          <a
            v-if="!item.hasPopup"
            href="#"
            class="text-black hover:text-black transition-colors cursor-pointer"
            :class="{ active: isActive(item) }"
            @click.prevent="handleNavItemClick(item)"
          >
            {{ item.name }}
          </a>
          <div v-else
            @mouseenter="showAboutPopup = true"
            @mouseleave="onAboutMouseLeave"
          >
            <a 
              href="#"
              class="text-black hover:text-black transition-colors cursor-pointer"
              :class="{ active: isSubMenuActive(item) }"
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
      <div class="flex space-x-2 auth-button" v-if="!isLoggedIn">
        <button @click="openLoginModal" class="btn-login">
          Masuk
        </button>
        <button @click="openRegisterModal" class="btn-register">
          Daftar
        </button>
      </div>

      <!-- Profile Menu -->
      <div class="relative auth-button" v-else>
        <template v-if="user && user.profilePicture">
          <img
            :src="user.profilePicture"
            alt="Profile"
            class="w-10 h-10 rounded-full cursor-pointer"
            @click="toggleProfilePopup"
          />
        </template>
        <template v-else>
          <img
            :src="UserIcon"
            alt="User Icon"
            class="w-10 h-10 rounded-full cursor-pointer"
            @click="toggleProfilePopup"
          />
        </template>
        <div
          v-if="showProfilePopup"
          class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-4 px-4 z-50"
        >
          <div class="flex flex-col items-center space-y-2 mb-4">
            <img
              :src="user.profilePicture || UserIcon"
              alt="Profile Photo"
              class="w-16 h-16 rounded-full cursor-pointer"
              @click="onProfilePhotoClickWithReload"
   
              />
            <p class="font-semibold text-gray-800">{{ user.username || 'User' }}</p>
            <p class="text-gray-600 text-sm">{{ user.email || 'user@example.com' }}</p>
          </div>
          <button
            @click="handleLogout"
            class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition-colors"
          >
            Keluar
          </button>
        </div>
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
  ></AuthModal>
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
  font-size: 1.10rem; /* Ukuran font disesuaikan dengan navbar title */
  font-weight: 700; /* Berat font disesuaikan dengan navbar title */
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
  font-size: 1.10rem; /* Ukuran font disesuaikan dengan navbar title */
  font-weight: 700; /* Berat font disesuaikan dengan navbar title */
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
  font-size: 1.10rem; /* Ukuran font disesuaikan dengan navbar title */
  font-weight: 700; /* Berat font disesuaikan dengan navbar title */
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
  /* Increase border thickness for user icon placeholder */
  /* Removed invalid CSS selector targeting template element */
</style>
