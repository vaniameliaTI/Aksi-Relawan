<template>
  <div class="profile-container">
    <div class="profile-header">
      <h1>Profil Pengguna</h1>
    </div>
    <div class="profile-content-row">
      <!-- Foto Profil -->
      <div class="photo-column">
        <div class="photo-wrapper" @click="showPhotoPopup = true">
          <img
            :src="previewImage || fullPhotoUrl || defaultUserIcon"
            alt="Foto Profil"
            class="profile-photo-large"
          />
        </div>
      </div>
      <!-- Data Profil/Form -->
      <div class="profile-form" style="flex: 1;">
        <div v-if="!isEditing" class="profile-info">
          <div class="info-row">
            <h3>Nama Panggilan:</h3>
            <p>{{ profile.username }}</p>
          </div>
          <div class="info-row">
            <h3>Nama Lengkap:</h3>
            <p>{{ profile.full_name }}</p>
          </div>
          <div class="info-row">
            <h3>Email:</h3>
            <p>{{ profile.email }}</p>
          </div>
          <div class="info-row">
            <h3>Telepon:</h3>
            <p>{{ profile.phone }}</p>
          </div>
          <div class="info-row">
            <h3>Alamat:</h3>
            <p>{{ profile.address }}</p>
          </div>
          <button @click="toggleEdit" class="edit-button">Edit Profil</button>
        </div>

        <form v-else @submit.prevent="updateProfile" class="edit-form">
          <div class="form-group">
            <label for="username">Nama Panggilan:</label>
            <input type="text" id="username" v-model="form.username" required />
          </div>
          <div class="form-group">
            <label for="full_name">Nama Lengkap:</label>
            <input type="text" id="full_name" v-model="form.full_name" required />
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" v-model="form.email" disabled />
          </div>
          <div class="form-group">
            <label for="phone">Telepon:</label>
            <input type="tel" id="phone" v-model="form.phone" />
          </div>
          <div class="form-group">
            <label for="address">Alamat:</label>
            <textarea id="address" v-model="form.address" rows="3"></textarea>
          </div>
          <div class="form-actions">
            <button type="submit" class="save-button">Simpan</button>
            <button type="button" @click="toggleEdit" class="cancel-button">Batal</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Pop Up Foto -->
    <transition name="popup-zoom">
      <div v-if="showPhotoPopup" class="photo-popup-overlay" @click.self="showPhotoPopup = false">
        <div class="photo-popup-content">
          <img
            :src="previewImage || fullPhotoUrl || defaultUserIcon"
            alt="Foto Profil Besar"
            class="profile-photo-popup"
          />
          <div class="photo-popup-actions">
            <button @click="triggerFileInput" class="photo-popup-button upload-button">Unggah Foto</button>
            <button @click="deletePhoto" class="photo-popup-button delete-button">Hapus Foto</button>
            <button @click="showPhotoPopup = false" class="photo-popup-button cancel-button">Batal</button>
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
  </div>
</template>

<script>
import { ref, reactive, onMounted, onBeforeUnmount, computed, watch } from 'vue';
import { getUserProfile, updateUserProfile, uploadProfilePhoto } from '../services/api';
import defaultUserIcon from '../assets/images/icons/iconuser.png';

export default {
  name: 'UserProfile',
  setup() {
    const profile = reactive({ username: '', full_name: '', email: '', phone: '', address: '', photo_url: '' });
    const form = reactive({ username: '', full_name: '', email: '', phone: '', address: '' });
    const isEditing = ref(false);
    const message = ref('');
    const messageType = ref('');
    const fileInput = ref(null);
    const previewImage = ref(null);
    const showPhotoPopup = ref(false);

    const fullPhotoUrl = computed(() => {
      if (!profile.photo_url || profile.photo_url.trim() === '') return null;
      if (profile.photo_url.startsWith('http')) {
        // Add cache buster to force reload on change
        const cacheBuster = Date.now();
        return `${profile.photo_url}?cb=${cacheBuster}`;
      }
      return `http://localhost:8080${profile.photo_url}`;
    });

    const fetchProfile = async () => {
      try {
        const response = await getUserProfile();
        if (response.data.status === 'success') {
          Object.assign(profile, response.data.data);
          Object.assign(form, response.data.data);
        }
      } catch (error) {
        console.error('Error fetching profile:', error);
        showMessage('Gagal memuat profil', 'error');
      }
    };

    const toggleEdit = () => {
      if (isEditing.value) Object.assign(form, profile);
      isEditing.value = !isEditing.value;
    };

    const updateProfile = async () => {
      try {
        const response = await updateUserProfile({
          username: form.username,
          full_name: form.full_name,
          phone: form.phone,
          address: form.address
        });
        if (response.data.status === 'success') {
          Object.assign(profile, form);
          isEditing.value = false;
          showMessage('Profil berhasil diperbarui', 'success');
          // Update localStorage user data with new username and email
          const storedUser = JSON.parse(localStorage.getItem('user')) || {};
          storedUser.username = form.username;
          storedUser.email = form.email;
          localStorage.setItem('user', JSON.stringify(storedUser));
          // Emit event to notify other components (e.g., NavBar) about profile update
          window.dispatchEvent(new Event('userProfileUpdated'));
        } else {
          showMessage('Gagal memperbarui profil', 'error');
        }
      } catch (error) {
        console.error('Update error:', error);
        showMessage('Gagal memperbarui profil', 'error');
      }
    };

    const triggerFileInput = () => fileInput.value.click();

    const deletePhoto = async () => {
      try {
        // Call updateProfile API with empty photo_url to delete photo
        const response = await updateUserProfile({ photo_url: '' });
        if (response.data.status === 'success') {
          profile.photo_url = '';
          previewImage.value = null;
          // Update localStorage user photo to default icon path
          localStorage.setItem('user', JSON.stringify({ ...JSON.parse(localStorage.getItem('user')), profilePicture: defaultUserIcon }));
          window.dispatchEvent(new Event('profilePhotoUpdated'));
          showMessage('Foto profil berhasil dihapus', 'success');
          // Reset file input value to allow re-uploading the same file
          if (fileInput.value) {
            fileInput.value.value = '';
          }
        } else {
          showMessage('Gagal menghapus foto profil', 'error');
        }
      } catch (error) {
        console.error('Delete photo error:', error);
        showMessage('Gagal menghapus foto profil', 'error');
      }
    };

    const handlePhotoChange = async (event) => {
      const file = event.target.files[0];
      if (!file || !['image/jpeg', 'image/png', 'image/gif'].includes(file.type) || file.size > 5 * 1024 * 1024) {
        showMessage('File tidak valid', 'error');
        return;
      }
      const reader = new FileReader();
      reader.onload = e => previewImage.value = e.target.result;
      reader.readAsDataURL(file);
      try {
        showMessage('Sedang mengunggah foto...', 'info');
        const formData = new FormData();
        formData.append('photo', file);
        const response = await uploadProfilePhoto(formData);
        if (response.data.status === 'success') {
          profile.photo_url = response.data.photo_url;
          localStorage.setItem('user', JSON.stringify({ ...JSON.parse(localStorage.getItem('user')), profilePicture: fullPhotoUrl.value }));
          window.dispatchEvent(new Event('profilePhotoUpdated'));
          setTimeout(() => { previewImage.value = null; fetchProfile(); }, 1000);
          showMessage('Foto profil berhasil diperbarui', 'success');
          // Reset file input value to allow re-uploading the same file
          if (fileInput.value) {
            fileInput.value.value = '';
          }
        } else {
          previewImage.value = null;
          showMessage('Gagal mengunggah foto', 'error');
        }
      } catch (error) {
        previewImage.value = null;
        console.error('Upload error:', error);
        showMessage('Gagal mengunggah foto', 'error');
      }
    };

    const showMessage = (text, type = 'info') => {
      message.value = text;
      messageType.value = type;
      setTimeout(() => { message.value = ''; }, 3000);
    };

    onMounted(() => {
      fetchProfile();
      window.addEventListener('profilePhotoUpdated', fetchProfile);
    });
    onBeforeUnmount(() => {
      window.removeEventListener('profilePhotoUpdated', fetchProfile);
    });

    // Prevent flicker or blinking by avoiding unnecessary reloads or redirects
    // Add a flag to track if profile is freshly loaded
    const isProfileLoaded = ref(false);

    watch(profile, (newVal, oldVal) => {
      if (!isProfileLoaded.value) {
        isProfileLoaded.value = true;
      } else {
        // Handle profile updates without causing flicker
        // For example, avoid router.push or reload here
      }
    }, { deep: true });

    watch(() => profile.photo_url, newVal => {
      if (!newVal || newVal.trim() === '') previewImage.value = null;
    });

    return {
      profile,
      form,
      isEditing,
      message,
      messageType,
      fileInput,
      previewImage,
      fullPhotoUrl,
      showPhotoPopup,
      toggleEdit,
      updateProfile,
      triggerFileInput,
      deletePhoto,
      handlePhotoChange,
      defaultUserIcon
    };
  }
};
</script>


<style scoped>
.profile-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;
}

.profile-header {
  text-align: center;
  margin-bottom: 2rem;
}

.profile-content-row {
  display: flex;
  flex-direction: row;
  gap: 2rem;
  align-items: flex-start;
}

.photo-column {
  flex: 0 0 220px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.photo-wrapper {
  width: 200px;
  height: 200px;
  border-radius: 50%;
  overflow: hidden;
  position: relative;
  cursor: pointer;
  background-color: #222;
  display: flex;
  justify-content: center;
  align-items: center;
}

.profile-photo-large,
.profile-photo-popup {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
  background: #fff;
}

.edit-icon {
  position: absolute;
  bottom: 10px;
  right: 10px;
  background: #222;
  border-radius: 50%;
  padding: 5px;
  opacity: 0.8;
}

.profile-info {
  background-color: #f9f9f9;
  padding: 1.5rem;
  border-radius: 8px;
}

.info-row {
  display: flex;
  margin-bottom: 1rem;
  border-bottom: 1px solid #eee;
  padding-bottom: 0.5rem;
}

.info-row h3 {
  min-width: 150px;
  margin: 0;
  font-weight: 600;
}

.info-row p {
  margin: 0;
  flex: 1;
}

.edit-button {
  background-color: #1e3a8a; /* Adjusted to web theme color */
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 9999px; /* Full rounded corners */
  cursor: pointer;
  font-weight: 600;
  margin-top: 1rem;
  width: 100%;
}

.edit-form {
  background-color: #f9f9f9;
  padding: 1.5rem;
  border-radius: 8px;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.form-actions {
  display: flex;
  gap: 1rem;
  margin-top: 1.5rem;
}

.save-button {
  flex: 1;
  background-color: #1e3a8a; /* Theme blue */
  color: white;
  border: none;
  padding: 0.75rem 1rem;
  border-radius: 9999px; /* Full rounded corners */
  cursor: pointer;
  font-weight: 600;
}
.cancel-button {
  flex: 1;
  background-color: #1e3a8a; /* Theme blue */
  color: white;
  border: none;
  padding: 0.75rem 1rem;
  border-radius: 9999px; /* Full rounded corners */
  cursor: pointer;
  font-weight: 600;
}

.message {
  margin-top: 1rem;
  padding: 0.75rem;
  border-radius: 4px;
  text-align: center;
}

.success {
  background-color: #e8f5e9;
  color: #2e7d32;
}

.error {
  background-color: #ffebee;
  color: #c62828;
}

.info {
  background-color: #e3f2fd;
  color: #1565c0;
}

.photo-popup-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5); /* Redup transparan, tanpa blur */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  /* Removed animation */
}

.photo-popup-content {
  background: transparent;
  padding: 0;
  border-radius: 0;
  box-shadow: none;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.profile-photo-popup {
  width: 320px;
  height: 320px;
  object-fit: cover;
  border-radius: 50%;
  margin-bottom: 1.5rem;
  background: #fff;
  border: none !important;
  box-shadow: none !important;
}

.photo-popup-actions {
  display: flex;
  gap: 1rem;
}

.photo-popup-button {
  padding: 0.5rem 1.5rem;
  border: none;
  border-radius: 9999px; /* Full rounded corners */
  font-weight: 600;
  cursor: pointer;
}
.upload-button { background: #1e3a8a; color: #fff; } /* Adjusted to theme blue */
.delete-button { background: #ed4956; color: #fff; }
.cancel-button { background: #888; color: #fff; }

@media (max-width: 767px) {
  .profile-content_row { flex-direction: column; align-items: center; }
  .photo-popup-content { padding: 1rem; }
  .profile-photo-popup { width: 200px; height: 200px; }
}
</style>
