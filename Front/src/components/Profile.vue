<template>
  <div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-black mb-0">Profil Pengguna</h1>
    </div>

    <div class="flex flex-col md:flex-row items-start md:items-center gap-8 bg-white p-6 rounded-lg shadow-md">
      <!-- Foto Profil -->
      <div class="flex-shrink-0 w-48 h-48 mx-auto md:mx-0 cursor-pointer relative" @click="showPhotoPopup = true">
        <img
          :src="previewImage || fullPhotoUrl || defaultUserIcon"
          alt="Foto Profil"
          class="w-full h-full rounded-full object-cover border-4 border-blue-800"
        />
        <div class="absolute inset-0 rounded-full bg-black opacity-0 hover:opacity-25 transition-opacity flex items-center justify-center">
          <svg
            class="w-10 h-10 text-white transition-transform transform hover:scale-110"
            fill="white"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 20h9" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
          </svg>
        </div>
      </div>

      <!-- Data Profil/Form -->
      <div class="flex-grow w-full max-w-full overflow-hidden relative z-10">
        <div v-if="!isEditing" class="flex flex-col space-y-4 h-full justify-between max-w-full overflow-hidden">
          <div v-for="field in fields" :key="field.key" class="border-b border-gray-200 pb-2 max-w-full overflow-hidden">
            <h3 class="text-sm font-semibold text-gray-600 mb-2">{{ field.label }}</h3>
            <p class="text-gray-800 break-words overflow-wrap break-word max-w-full overflow-hidden">
              <span v-if="!profile[field.key] || profile[field.key].trim() === ''" class="text-gray-400 italic">empty</span>
              <span v-else>{{ profile[field.key] }}</span>
            </p>
          </div>
          <div class="flex justify-end">
            <button @click="toggleEdit" class="mt-2 bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-8 rounded-full transition duration-300">Edit Profil</button>
          </div>
        </div>

        <form v-else @submit.prevent="updateProfile" class="space-y-4">
          <div v-for="field in fields" :key="field.key" class="form-group">
            <label :for="field.key" class="block text-sm font-semibold text-gray-600">{{ field.label }}</label>
            <component :is="field.type === 'textarea' ? 'textarea' : 'input'"
                       :id="field.key"
                       v-model="form[field.key]"
                       :type="field.inputType || 'text'"
                       rows="field.type === 'textarea' ? 3 : undefined"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
          </div>
          <div class="flex justify-end gap-4">
            <button type="button" @click="toggleEdit" class="px-6 py-2 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100 transition duration-300">Batal</button>
            <button type="submit" class="px-6 py-2 bg-blue-800 hover:bg-blue-900 text-white font-bold rounded-full transition duration-300">Simpan</button>
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
            <button @click="triggerFileInput" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full transition duration-300">Unggah Foto</button>
            <button @click="deletePhoto" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-full transition duration-300">Hapus Foto</button>
            <button @click="showPhotoPopup = false" class="px-6 py-2 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100 transition duration-300">Batal</button>
          </div>
        </div>
      </div>
    </transition>

    <input type="file" ref="fileInput" @change="handlePhotoChange" accept="image/jpeg,image/png,image/gif" style="display: none" />

    <!-- Message Notification -->
    <transition name="slide-fade">
      <div v-if="message" :class="{
        'bg-green-500': messageType === 'success',
        'bg-red-500': messageType === 'error',
        'bg-blue-500': messageType === 'info',
      }" class="fixed bottom-4 right-4 text-white px-6 py-3 rounded-md shadow-lg z-50">
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

const fields = [
  { key: 'username', label: 'Nama Panggilan', inputType: 'text' },
  { key: 'full_name', label: 'Nama Lengkap', inputType: 'text' },
  { key: 'email', label: 'Email', inputType: 'email' },
  { key: 'phone', label: 'Telepon', inputType: 'tel' },
  { key: 'address', label: 'Alamat', type: 'textarea' },
];

const fullPhotoUrl = computed(() => {
  if (!profile.photo_url || profile.photo_url.trim() === '') return null;
  const url = `http://localhost:8080${profile.photo_url}`;
  return url.startsWith('http://localhost') ? `${url}?cb=${Date.now()}` : url;
});

onMounted(() => {
  fetchProfile();
  window.addEventListener('profilePhotoUpdated', fetchProfile);
});

onBeforeUnmount(() => {
  window.removeEventListener('profilePhotoUpdated', fetchProfile);
});

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
    console.error(error);
    showMessage('Gagal memuat profil', 'error');
  }
};

const toggleEdit = () => {
  if (isEditing.value) Object.assign(form, profile);
  isEditing.value = !isEditing.value;
};

const updateProfile = async () => {
  try {
    showMessage('Sedang menyimpan profil...', 'info');
    const response = await updateUserProfile({ ...form });
    if (response.data.status === 'success') {
      Object.assign(profile, form);
      isEditing.value = false;
      showMessage('Profil berhasil diperbarui', 'success');
      const storedUser = JSON.parse(localStorage.getItem('user')) || {};
      storedUser.username = form.username;
      localStorage.setItem('user', JSON.stringify(storedUser));
      window.dispatchEvent(new Event('userProfileUpdated'));
    } else {
      showMessage(response.data.message || 'Gagal memperbarui profil', 'error');
    }
  } catch (error) {
    console.error(error);
    showMessage('Gagal memperbarui profil', 'error');
  }
};

const triggerFileInput = () => fileInput.value.click();

const handlePhotoChange = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
  if (!allowedTypes.includes(file.type)) return showMessage('Jenis file tidak valid.', 'error');
  if (file.size > 5 * 1024 * 1024) return showMessage('Ukuran file terlalu besar.', 'error');

  const reader = new FileReader();
  reader.onload = e => previewImage.value = e.target.result;
  reader.readAsDataURL(file);
  showPhotoPopup.value = false;

  try {
    showMessage('Sedang mengunggah foto...', 'info');
    const formData = new FormData();
    formData.append('photo', file);
    const response = await uploadProfilePhoto(formData);
    if (response.data.status === 'success') {
      profile.photo_url = response.data.photo_url;
      const storedUser = JSON.parse(localStorage.getItem('user')) || {};
      storedUser.profilePicture = fullPhotoUrl.value;
      localStorage.setItem('user', JSON.stringify(storedUser));
      window.dispatchEvent(new Event('profilePhotoUpdated'));
      showMessage('Foto profil berhasil diperbarui', 'success');
      previewImage.value = null;
      fileInput.value.value = '';
      fetchProfile();
    } else {
      previewImage.value = null;
      showMessage(response.data.message || 'Gagal mengunggah foto', 'error');
    }
  } catch (error) {
    previewImage.value = null;
    console.error(error);
    showMessage('Gagal mengunggah foto', 'error');
  }
};

const deletePhoto = async () => {
  try {
    showMessage('Sedang menghapus foto...', 'info');
    const response = await updateUserProfile({ photo_url: '' });
    if (response.data.status === 'success') {
      profile.photo_url = '';
      previewImage.value = null;
      showPhotoPopup.value = false;
      const storedUser = JSON.parse(localStorage.getItem('user')) || {};
      storedUser.profilePicture = defaultUserIcon;
      localStorage.setItem('user', JSON.stringify(storedUser));
      window.dispatchEvent(new Event('profilePhotoUpdated'));
      showMessage('Foto profil berhasil dihapus', 'success');
      fileInput.value.value = '';
    } else {
      showMessage(response.data.message || 'Gagal menghapus foto profil', 'error');
    }
  } catch (error) {
    console.error(error);
    showMessage('Gagal menghapus foto profil', 'error');
  }
};

const showMessage = (text, type = 'info') => {
  message.value = text;
  messageType.value = type;
  setTimeout(() => { message.value = ''; }, 3000);
};

watch(() => profile.photo_url, (newVal) => {
  if (!newVal || newVal.trim() === '') {
    previewImage.value = null;
  }
});
</script>

<style scoped>
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
.slide-fade-enter-from, .slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>
