<template>
  <div>
    <NavBar />
    <div class="min-h-screen bg-gray-100 py-8">
      <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-md p-6">
          <h1 class="text-2xl font-bold text-gray-800 mb-6">Profil Saya</h1>
          
          <form @submit.prevent="updateProfile" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input 
                  v-model="profile.full_name" 
                  type="text" 
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input 
                  v-model="profile.email" 
                  type="email" 
                  disabled
                  class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm"
                >
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input 
                  v-model="profile.phone" 
                  type="tel" 
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea 
                  v-model="profile.address" 
                  rows="3" 
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                ></textarea>
              </div>
            </div>
            
            <div class="flex justify-end">
              <button 
                type="submit" 
                class="px-4 py-2 bg-blue-900 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
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

const router = useRouter();

const profile = ref({
  full_name: '',
  email: '',
  phone: '',
  address: ''
});

const fetchProfile = async () => {
  try {
    const response = await fetch('http://localhost:3000/api/profile', {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      }
    });
    
    if (!response.ok) throw new Error('Gagal mengambil data profil');
    
    const data = await response.json();
    profile.value = data;
  } catch (error) {
    console.error('Error:', error);
    alert('Gagal mengambil data profil');
  }
};

const updateProfile = async () => {
  try {
    const response = await fetch('http://localhost:3000/api/profile', {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: JSON.stringify(profile.value)
    });
    
    if (!response.ok) throw new Error('Gagal memperbarui profil');
    
    alert('Profil berhasil diperbarui');
  } catch (error) {
    console.error('Error:', error);
    alert('Gagal memperbarui profil');
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