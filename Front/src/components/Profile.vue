<template>
  <transition name="fade-slide">
    <div class="container mx-auto px-4 py-2 max-w-3xl" v-if="profileLoaded">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-black mb-0">Profil Pengguna</h1>
      </div>

      <div class="flex flex-col md:flex-row items-start md:items-start gap-8 bg-white p-6 rounded-lg shadow-md min-h-[260px]">
        <!-- Foto Profil -->
        <div
          class="flex-shrink-0 w-56 h-56 mx-auto md:mx-0 cursor-pointer relative mb-4 md:mb-0 transition-all duration-300 profile-photo-container"
          @click="showPhotoPopup = true"
        >
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

        <!-- Data Profil dengan Transisi -->
        <transition name="fade" mode="out-in">
          <div v-if="!isEditing" key="display" class="flex-grow w-full max-w-full overflow-hidden relative z-10 flex flex-col space-y-4 h-full justify-between">
            <!-- Data Profil Display -->
            <div v-for="field in fields" :key="field.key" class="border-b border-gray-200 pb-2 max-w-full overflow-hidden">
              <h3 class="text-sm font-semibold text-gray-600 mb-2">{{ field.label }}</h3>
              <p class="text-gray-800 break-words overflow-wrap break-word max-w-full overflow-hidden">
                <span v-if="profileLoaded && (!profile[field.key] || profile[field.key].trim() === '')" class="text-gray-400 italic">empty</span>
                <span v-else>{{ profile[field.key] }}</span>
              </p>
            </div>
            <div class="flex justify-end">
              <button @click="toggleEdit" class="mt-2 bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-8 rounded-full transition duration-300">Edit Profil</button>
            </div>
          </div>
          <div v-else key="edit" class="flex-grow w-full max-w-full overflow-hidden relative z-10">
            <!-- Data Profil Form -->
            <form @submit.prevent="updateProfile" class="space-y-4">
              <div v-for="field in fields" :key="field.key" class="form-group">
                <label :for="field.key" class="block text-sm font-semibold text-gray-600">{{ field.label }}</label>
                <template v-if="field.type === 'textarea'">
                  <textarea
                    :id="field.key"
                    v-model="form[field.key]"
                    rows="3"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  />
                </template>
                <template v-else>
                  <input
                    :id="field.key"
                    v-model="form[field.key]"
                    :type="field.inputType || 'text'"
                    :disabled="field.key === 'email' && (!emailVerified || emailError)"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  />
                  <div v-if="field.key === 'email' && emailError" class="text-red-500 text-xs mt-1">{{ emailError }}</div>
                  <div v-if="field.key === 'email' && !emailVerified && !emailError && form.email !== profile.email">
                    <button
                      type="button"
                      @click="sendEmailVerification"
                      :disabled="emailVerificationSent"
                      class="mt-2 px-4 py-1 bg-blue-600 text-white rounded-full"
                    >
                      {{ emailVerificationSent ? 'Verifikasi Terkirim...' : 'Kirim Verifikasi Email' }}
                    </button>
                  </div>
                </template>
              </div>
              <div class="flex justify-end gap-4">
                <button
                  type="button"
                  @click="toggleEdit"
                  class="px-6 py-2 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100 transition duration-300"
                >
                  Batal
                </button>
                <button
                  type="submit"
                  class="px-6 py-2 bg-blue-800 hover:bg-blue-900 text-white font-bold rounded-full transition duration-300"
                  :disabled="form.email !== profile.email && (!emailVerified || emailError)"
                >
                  Simpan
                </button>
              </div>
            </form>
          </div>
        </transition>
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
    <div v-else class="flex items-center justify-center min-h-[400px]">
      <!-- Spinner Loading -->
      <div class="flex flex-col items-center">
        <svg class="animate-spin h-12 w-12 text-blue-800 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
        <span class="text-blue-800 font-semibold">Memuat profil...</span>
      </div>
    </div>
  </transition>
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

const emailVerified = ref(false);
const emailVerificationSent = ref(false);
const emailError = ref('');

const authProvider = localStorage.getItem('authProvider') || 'email'; // contoh, sesuaikan dengan implementasi Anda

const fields = [
  { key: 'username', label: 'Nama Panggilan', inputType: 'text' },
  { key: 'full_name', label: 'Nama Lengkap', inputType: 'text' },
  { key: 'email', label: 'Email', inputType: 'email', editable: authProvider === 'email' },
  { key: 'phone', label: 'Telepon', inputType: 'tel' },
  { key: 'address', label: 'Alamat', type: 'textarea' },
];

const fullPhotoUrl = computed(() => {
  if (!profile.photo_url || profile.photo_url.trim() === '') return null;
  const url = `http://localhost:8080${profile.photo_url}`;
  return url.startsWith('http://localhost') ? `${url}?cb=${Date.now()}` : url;
});

const profileLoaded = ref(false);

function onProfilePhotoUpdated() {
  fetchProfile();
}

onMounted(() => {
  fetchProfile();
  window.addEventListener('profilePhotoUpdated', onProfilePhotoUpdated);
});

onBeforeUnmount(() => {
  window.removeEventListener('profilePhotoUpdated', onProfilePhotoUpdated);
});

const fetchProfile = async () => {
  try {
    const response = await getUserProfile();
    if (response.data.status === 'success') {
      const data = response.data.data;
      profile.username = data.username || '';
      profile.full_name = data.full_name || '';
      profile.email = data.email || '';
      profile.phone = data.phone || '';
      profile.address = data.address || '';
      profile.photo_url = data.photo_url || '';

      form.username = data.username || '';
      form.full_name = data.full_name || '';
      form.email = data.email || '';
      form.phone = data.phone || '';
      form.address = data.address || '';
      profileLoaded.value = true;
    } else {
      showMessage(response.data.message || 'Gagal memuat profil', 'error');
    }
  } catch (error) {
    console.error(error);
    showMessage('Gagal memuat profil', 'error');
  }
};

const toggleEdit = () => {
  if (!isEditing.value) {
    // entering edit mode, copy profile to form
    form.username = profile.username;
    form.full_name = profile.full_name;
    form.email = profile.email;
    form.phone = profile.phone;
    form.address = profile.address;
  }
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

function validateEmail(email) {
  // Regex sederhana validasi email
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

watch(() => form.email, (newEmail) => {
  emailVerified.value = false;
  emailVerificationSent.value = false;
  if (!validateEmail(newEmail)) {
    emailError.value = 'Format email tidak valid';
  } else if (newEmail === profile.email) {
    emailError.value = '';
    emailVerified.value = true;
  } else {
    emailError.value = '';
  }
});

const sendEmailVerification = async () => {
  // Simulasi kirim email verifikasi (ganti dengan API Anda)
  emailVerificationSent.value = true;
  showMessage('Link verifikasi telah dikirim ke email baru. Silakan cek email Anda.', 'info');
  // Setelah user klik link di email, set emailVerified.value = true (simulasi manual di sini)
  setTimeout(() => {
    emailVerified.value = true;
    showMessage('Email berhasil diverifikasi. Anda bisa menyimpan perubahan.', 'success');
  }, 3000); // Simulasi delay verifikasi
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
.fade-slide-enter-active {
  transition: all 0.5s cubic-bezier(.55,0,.1,1);
}
.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(40px);
}
.fade-slide-enter-to {
  opacity: 1;
  transform: translateY(0);
}
/* Menggunakan animasi fade yang sudah ada */
.button-fade-slide-enter-active, .button-fade-slide-leave-active {
  transition: all 0.3s cubic-bezier(.55,0,.1,1);
}
.button-fade-slide-enter-from, .button-fade-slide-leave-to {
  opacity: 0;
  transform: translateY(20px) scale(0.95);
}
.button-fade-slide-enter-to, .button-fade-slide-leave-from {
  opacity: 1;
  transform: translateY(0) scale(1);
}
.profile-photo-container {
  margin-top: 70px;
  transition: margin 0.3s;
}
@media (min-width: 768px) {
  .profile-photo-container {
    margin-bottom: 0;
  }
}
</style>