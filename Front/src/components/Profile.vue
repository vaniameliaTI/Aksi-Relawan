<template>
  <div>
    <NavBar />
    <div class="min-h-screen bg-gray-100 py-8">
      <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-md p-6">
          <h1 class="text-2xl font-bold text-gray-800 mb-6">Profil Saya</h1>
          
          <!-- Profile Photo Section -->
          <div class="mb-8 flex flex-col items-center">
            <div class="relative">
              <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-900">
                <img 
                  :src="profile.photo_url || '/default-avatar.png'" 
                  alt="Profile Photo"
                  class="w-full h-full object-cover"
                />
              </div>
              <label 
                for="photo-upload" 
                class="absolute bottom-0 right-0 bg-blue-900 text-white p-2 rounded-full cursor-pointer hover:bg-blue-800 transition-colors"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
              </label>
              <input 
                id="photo-upload" 
                type="file" 
                accept="image/*" 
                class="hidden" 
                @change="handlePhotoUpload"
              />
            </div>
            <p class="mt-2 text-sm text-gray-600">Klik ikon kamera untuk mengubah foto profil</p>
          </div>
          
          <form @submit.prevent="updateProfile" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input 
                  v-model="profile.full_name" 
                  type="text" 
                  class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input 
                  v-model="profile.email" 
                  type="email" 
                  disabled
                  class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 shadow-sm"
                >
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input 
                  v-model="profile.phone" 
                  type="tel" 
                  class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea 
                  v-model="profile.address" 
                  rows="3" 
                  class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                ></textarea>
              </div>
            </div>
            
            <div class="flex justify-end space-x-4">
              <button 
                type="button"
                @click="handleLogout"
                class="px-6 py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
              >
                Keluar
              </button>
              <button 
                type="submit" 
                class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
              >
                Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import NavBar from './NavBar.vue';
import { getUserProfile, updateUserProfile, logout } from '../services/api';

const router = useRouter();

const profile = ref({
  full_name: '',
  email: '',
  phone: '',
  address: '',
  photo_url: ''
});

const fetchProfile = async () => {
  try {
    const response = await getUserProfile();
    profile.value = response.data;
  } catch (error) {
    console.error('Error:', error);
    alert('Gagal mengambil data profil');
  }
};

const handlePhotoUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('photo', file);

  try {
    const response = await fetch('http://localhost:3000/api/profile/photo', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: formData
    });

    if (!response.ok) throw new Error('Gagal mengunggah foto');
    
    const data = await response.json();
    profile.value.photo_url = data.photo_url;
    alert('Foto profil berhasil diperbarui');
  } catch (error) {
    console.error('Error:', error);
    alert('Gagal mengunggah foto profil');
  }
};

const updateProfile = async () => {
  try {
    await updateUserProfile(profile.value);
    alert('Profil berhasil diperbarui');
  } catch (error) {
    console.error('Error:', error);
    alert('Gagal memperbarui profil');
  }
};

const handleLogout = async () => {
  try {
    await logout();
    router.push('/');
  } catch (error) {
    console.error('Error during logout:', error);
  }
};

onMounted(() => {
  if (!localStorage.getItem('token')) {
    router.push('/');
  } else {
    fetchProfile();
  }
});
</script> 