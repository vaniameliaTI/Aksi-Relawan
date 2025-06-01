<template>
  <div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-blue-800">Profil Pengguna</h1>
    </div>

    <div class="flex flex-col md:flex-row items-start md:items-center gap-8 bg-white p-6 rounded-lg shadow-md">
      <!-- Foto Profil -->
      <div class="flex-shrink-0 w-48 h-48 mx-auto md:mx-0 cursor-pointer relative" @click="showPhotoPopup = true">
        <img
          :src="previewImage || fullPhotoUrl || defaultUserIcon"
          alt="Foto Profil"
          class="w-full h-full rounded-full object-cover border-4 border-blue-500"
        />
        <!-- Optional: Add an edit icon overlay -->
        <div class="absolute inset-0 rounded-full bg-black opacity-0 hover:opacity-25 transition-opacity flex items-center justify-center">
           <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a12.006 12.006 0 010 16.972l-7.5 7.5L3 17.5l1.5-7.5 7.5-7.5z"></path></svg>
        </div>
      </div>

      <!-- Data Profil/Form -->
      <div class="flex-grow w-full">
        <div v-if="!isEditing" class="space-y-4">
          <div class="pb-2 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-600">Nama Panggilan:</h3>
            <p class="text-gray-800">{{ profile.username }}</p>
          </div>
          <div class="pb-2 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-600">Nama Lengkap:</h3>
            <p class="text-gray-800">{{ profile.full_name }}</p>
          </div>
          <div class="pb-2 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-600">Email:</h3>
            <p class="text-gray-800">{{ profile.email }}</p>
          </div>
          <div class="pb-2 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-600">Telepon:</h3>
            <p class="text-gray-800">{{ profile.phone }}</p>
          </div>
          <div class="pb-2 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-600">Alamat:</h3>
            <p class="text-gray-800">{{ profile.address }}</p>
          </div>
          <button @click="toggleEdit" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full transition duration-300">
            Edit Profil
          </button>
        </div>

        <form v-else @submit.prevent="updateProfile" class="space-y-4">
          <div class="form-group">
            <label for="username" class="block text-sm font-semibold text-gray-600">Nama Panggilan:</label>
            <input type="text" id="username" v-model="form.username" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div class="form-group">
            <label for="full_name" class="block text-sm font-semibold text-gray-600">Nama Lengkap:</label>
            <input type="text" id="full_name" v-model="form.full_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div class="form-group">
            <label for="email" class="block text-sm font-semibold text-gray-600">Email:</label>
            <input type="email" id="email" v-model="form.email" disabled class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed">
          </div>
          <div class="form-group">
            <label for="phone" class="block text-sm font-semibold text-gray-600">Telepon:</label>
            <input type="tel" id="phone" v-model="form.phone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div class="form-group">
            <label for="address" class="block text-sm font-semibold text-gray-600">Alamat:</label>
            <textarea id="address" v-model="form.address" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
          </div>
          <div class="flex justify-end gap-4">
            <button type="button" @click="toggleEdit" class="px-6 py-2 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100 transition duration-300">
              Batal
            </button>
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full transition duration-300">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Pop Up Foto -->
    <transition name="fade">
      <div v-if="showPhotoPopup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.self="showPhotoPopup = false">
        <div class="bg-white p-6 rounded-lg shadow-xl flex flex-col items-center gap-4">
          <img
            :src="previewImage || fullPhotoUrl || defaultUserIcon"
            alt="Foto Profil Besar"
            class="w-64 h-64 rounded-full object-cover border-4 border-blue-500"
          />
          <div class="flex justify-center gap-4">
            <button @click="triggerFileInput" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full transition duration-300">
              Unggah Foto
            </button>
            <button @click="deletePhoto" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-full transition duration-300">
              Hapus Foto
            </button>
            <button @click="showPhotoPopup = false" class="px-6 py-2 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100 transition duration-300">
              Batal
            </button>
          </div>
        </div>
      </div>
    </transition>

    <input
      type="file"
      ref="fileInput"
      @change="handlePhotoChange"
      accept="image/jpeg,image/png,image/gif"
      style="display: none"
    />

    <!-- Message Notification -->
    <transition name="slide-fade">
      <div
        v-if="message"
        :class="{
          'bg-green-500': messageType === 'success',
          'bg-red-500': messageType === 'error',
          'bg-blue-500': messageType === 'info',
        }"
        class="fixed bottom-4 right-4 text-white px-6 py-3 rounded-md shadow-lg z-50"
      >
        {{ message }}
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, onBeforeUnmount, computed, watch } from 'vue';
import { getUserProfile, updateUserProfile, uploadProfilePhoto } from '../services/api';
import defaultUserIcon from '../assets/images/icons/iconuser.png';

const profile = reactive({ username: '', full_name: '', email: '', phone: '', address: '', photo_url: '' });
const form = reactive({ username: '', full_name: '', email: '', phone: '', address: '' });
const isEditing = ref(false);
const message = ref('');
const messageType = ref('');
const fileInput = ref(null);
const previewImage = ref(null);
const showPhotoPopup = ref(false);

// Computed property for full photo URL
const fullPhotoUrl = computed(() => {
  if (!profile.photo_url || profile.photo_url.trim() === '') return null;
  // Assuming backend serves uploads from /uploads
  // Add cache buster to force reload on change if URL is from localhost
  const url = `http://localhost:8080${profile.photo_url}`;
  if (url.startsWith('http://localhost')) {
     const cacheBuster = Date.now();
     return `${url}?cb=${cacheBuster}`;
  }
  return url;
});

// Fetch user profile on component mount
onMounted(() => {
  fetchProfile();
  // Add event listener for profile photo updates
  window.addEventListener('profilePhotoUpdated', fetchProfile);
});

// Remove event listener on component unmount
onBeforeUnmount(() => {
  window.removeEventListener('profilePhotoUpdated', fetchProfile);
});

// Function to fetch profile data
const fetchProfile = async () => {
  try {
    const response = await getUserProfile();
    if (response.data.status === 'success') {
      Object.assign(profile, response.data.data);
      Object.assign(form, response.data.data);
    } else {
      showMessage(response.data.message || 'Gagal memuat profil', 'error');
    }
  } catch (error) {
    console.error('Error fetching profile:', error);
    showMessage('Gagal memuat profil', 'error');
  }
};

// Toggle between view and edit mode
const toggleEdit = () => {
  if (isEditing.value) {
    // Reset form if canceling edit
    Object.assign(form, profile);
  }
  isEditing.value = !isEditing.value;
};

// Update user profile
const updateProfile = async () => {
  try {
    showMessage('Sedang menyimpan profil...', 'info');
    const response = await updateUserProfile({
      username: form.username,
      full_name: form.full_name,
      phone: form.phone,
      address: form.address,
    });

    if (response.data.status === 'success') {
      // Update profile data and toggle edit mode
      Object.assign(profile, form);
      isEditing.value = false;
      showMessage('Profil berhasil diperbarui', 'success');

      // Update localStorage and dispatch event
      const storedUser = JSON.parse(localStorage.getItem('user')) || {};
      storedUser.username = form.username;
      // assuming email can't be changed via this form, keep existing email in storedUser
      localStorage.setItem('user', JSON.stringify(storedUser));
      window.dispatchEvent(new Event('userProfileUpdated'));

    } else {
      showMessage(response.data.message || 'Gagal memperbarui profil', 'error');
    }
  } catch (error) {
    console.error('Update error:', error);
    showMessage('Gagal memperbarui profil', 'error');
  }
};

// Trigger file input click
const triggerFileInput = () => fileInput.value.click();

// Handle photo file selection and upload
const handlePhotoChange = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  // Basic file validation
  const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
  if (!allowedTypes.includes(file.type)) {
    showMessage('Jenis file tidak valid. Hanya JPG, PNG, dan GIF yang diizinkan.', 'error');
    return;
  }
  if (file.size > 5 * 1024 * 1024) { // 5MB
    showMessage('Ukuran file terlalu besar. Maksimum 5MB.', 'error');
    return;
  }

  // Show preview
  const reader = new FileReader();
  reader.onload = e => previewImage.value = e.target.result;
  reader.readAsDataURL(file);
  showPhotoPopup.value = false; // Close popup after selecting file

  try {
    showMessage('Sedang mengunggah foto...', 'info');
    const formData = new FormData();
    formData.append('photo', file);
    const response = await uploadProfilePhoto(formData);

    if (response.data.status === 'success') {
      // Update profile photo_url and localStorage
      profile.photo_url = response.data.photo_url;
       const storedUser = JSON.parse(localStorage.getItem('user')) || {};
      storedUser.profilePicture = fullPhotoUrl.value; // Use computed property for full URL
      localStorage.setItem('user', JSON.stringify(storedUser));
      window.dispatchEvent(new Event('profilePhotoUpdated'));

      showMessage('Foto profil berhasil diperbarui', 'success');

      // Reset preview and file input
      previewImage.value = null;
      if (fileInput.value) {
        fileInput.value.value = '';
      }
       fetchProfile(); // Re-fetch profile to ensure data consistency
    } else {
      previewImage.value = null;
      showMessage(response.data.message || 'Gagal mengunggah foto', 'error');
    }
  } catch (error) {
    previewImage.value = null;
    console.error('Upload error:', error);
    showMessage('Gagal mengunggah foto', 'error');
  }
};

// Delete profile photo
const deletePhoto = async () => {
  try {
    showMessage('Sedang menghapus foto...', 'info');
    // Call updateProfile API with empty photo_url to trigger deletion on backend
    const response = await updateUserProfile({ photo_url: '' });
    if (response.data.status === 'success') {
      profile.photo_url = '';
      previewImage.value = null;
      showPhotoPopup.value = false;

      // Update localStorage and dispatch event
      const storedUser = JSON.parse(localStorage.getItem('user')) || {};
      storedUser.profilePicture = defaultUserIcon;
      localStorage.setItem('user', JSON.stringify(storedUser));
      window.dispatchEvent(new Event('profilePhotoUpdated'));

      showMessage('Foto profil berhasil dihapus', 'success');

      // Reset file input value
      if (fileInput.value) {
        fileInput.value.value = '';
      }
    } else {
      showMessage(response.data.message || 'Gagal menghapus foto profil', 'error');
    }
  } catch (error) {
    console.error('Delete photo error:', error);
    showMessage('Gagal menghapus foto profil', 'error');
  }
};

// Show message notification
const showMessage = (text, type = 'info') => {
  message.value = text;
  messageType.value = type;
  setTimeout(() => { message.value = '', 3000 }); // Fix: setTimeout callback should be a function
};

// Watcher to reset preview image if profile.photo_url changes
watch(() => profile.photo_url, newVal => {
  if (!newVal || newVal.trim() === '') {
    previewImage.value = null;
  }
});

</script>

<style scoped>
/* Optional: Add simple fade/slide transitions if desired, otherwise remove */
/* These could also be done with Tailwind transition utilities */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

</style>