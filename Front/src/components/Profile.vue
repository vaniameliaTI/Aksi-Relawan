<template>
  <div class="profile-container">
    <div class="profile-header">
      <h1>Profil Pengguna</h1>
    </div>

    <div class="profile-content">
      <div class="photo-section">
        <div class="photo-container" @click="triggerFileInput">
          <img v-if="previewImage || fullPhotoUrl" :src="previewImage || fullPhotoUrl" alt="Foto Profil" class="profile-photo" />
          <div v-else class="photo-placeholder">
            <i class="fas fa-user"></i>
          </div>
          <div class="photo-overlay">
            <span>Ubah Foto</span>
          </div>
        </div>
        <input
          type="file"
          ref="fileInput"
          @change="handlePhotoChange"
          accept="image/jpeg,image/png,image/gif"
          style="display: none"
        />
      </div>

      <div class="profile-form">
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

    <div v-if="message" :class="['message', messageType]">
      {{ message }}
    </div>
  </div>
</template>

<script>
import { ref, reactive, onMounted, computed } from 'vue';
import { getUserProfile, updateUserProfile, uploadProfilePhoto } from '../services/api';

export default {
  name: 'UserProfile',
  setup() {
    const profile = reactive({
      username: '',
      full_name: '',
      email: '',
      phone: '',
      address: '',
      photo_url: ''
    });
    
    const form = reactive({
      username: '',
      full_name: '',
      email: '',
      phone: '',
      address: ''
    });
    
    const isEditing = ref(false);
    const message = ref('');
    const messageType = ref('');
    const fileInput = ref(null);
    const previewImage = ref(null);
    
    // Compute full URL for photo
    const fullPhotoUrl = computed(() => {
      if (!profile.photo_url) return null;
      
      // Jika sudah URL lengkap, gunakan langsung
      if (profile.photo_url.startsWith('http')) {
        return profile.photo_url;
      }
      
      // Ambil base URL dari konfigurasi atau window.location
      const baseApiUrl = 'http://localhost:8080'; // Sesuaikan dengan API URL Anda
      return `${baseApiUrl}${profile.photo_url}`;
    });
    
    const fetchProfile = async () => {
      try {
        const response = await getUserProfile();
        console.log('Profile data:', response.data);
        
        if (response.data && response.data.status === 'success') {
          const userData = response.data.data;
          
          profile.username = userData.username || '';
          profile.full_name = userData.full_name || '';
          profile.email = userData.email || '';
          profile.phone = userData.phone || '';
          profile.address = userData.address || '';
          profile.photo_url = userData.photo_url || '';
          
          console.log('Photo URL:', profile.photo_url);
          console.log('Full Photo URL:', fullPhotoUrl.value);
          
          // Copy to form
          Object.assign(form, {
            username: profile.username,
            full_name: profile.full_name,
            email: profile.email,
            phone: profile.phone,
            address: profile.address
          });
        }
      } catch (error) {
        console.error('Error fetching profile:', error);
        showMessage('Gagal memuat profil', 'error');
      }
    };
    
    const toggleEdit = () => {
      if (isEditing.value) {
        // Reset form to current profile
        Object.assign(form, {
          username: profile.username,
          full_name: profile.full_name,
          email: profile.email,
          phone: profile.phone,
          address: profile.address
        });
      }
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
        
        if (response.data && response.data.status === 'success') {
          Object.assign(profile, form);
          isEditing.value = false;
          showMessage('Profil berhasil diperbarui', 'success');
        } else {
          showMessage('Gagal memperbarui profil', 'error');
        }
      } catch (error) {
        console.error('Error updating profile:', error);
        showMessage('Gagal memperbarui profil', 'error');
      }
    };
    
    const triggerFileInput = () => {
      fileInput.value.click();
    };
    
    const handlePhotoChange = async (event) => {
      const file = event.target.files[0];
      if (!file) return;
      
      console.log("Selected file:", file.name, file.type, file.size);
      
      // Check file type
      if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
        showMessage('Tipe file tidak didukung. Gunakan JPG, PNG, atau GIF', 'error');
        return;
      }
      
      // Check file size (max 5MB)
      if (file.size > 5 * 1024 * 1024) {
        showMessage('Ukuran file terlalu besar. Maksimum 5MB', 'error');
        return;
      }
      
      // Create preview
      const reader = new FileReader();
      reader.onload = (e) => {
        previewImage.value = e.target.result;
      };
      reader.readAsDataURL(file);
      
      // Upload photo
      const formData = new FormData();
      formData.append('photo', file);
      
      console.log("Uploading file to server...");
      
      try {
        // Display loading message
        showMessage('Sedang mengunggah foto...', 'info');
        
        const response = await uploadProfilePhoto(formData);
        console.log("Upload response:", response);
        
        if (response.data && response.data.status === 'success') {
          profile.photo_url = response.data.photo_url;
          showMessage('Foto profil berhasil diperbarui', 'success');
          console.log("Photo URL updated:", profile.photo_url);
          console.log("Full Photo URL:", fullPhotoUrl.value);
          
          // Reset preview after successful upload and refresh
          setTimeout(() => {
            previewImage.value = null;
            fetchProfile();
          }, 1000);
        } else {
          showMessage('Gagal mengunggah foto profil: ' + (response.data?.message || 'Error tidak diketahui'), 'error');
          console.error("Upload failed:", response.data);
          previewImage.value = null; // Reset preview on failure
        }
      } catch (error) {
        console.error('Error uploading photo:', error);
        showMessage('Gagal mengunggah foto profil: ' + (error.message || 'Error tidak diketahui'), 'error');
        previewImage.value = null; // Reset preview on failure
      }
    };
    
    const showMessage = (text, type = 'info') => {
      message.value = text;
      messageType.value = type;
      setTimeout(() => {
        message.value = '';
      }, 3000);
    };
    
    onMounted(() => {
      fetchProfile();
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
      toggleEdit,
      updateProfile,
      triggerFileInput,
      handlePhotoChange
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

.profile-content {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

@media (min-width: 768px) {
  .profile-content {
    flex-direction: row;
    align-items: flex-start;
  }
  
  .photo-section {
    flex: 1;
  }
  
  .profile-form {
    flex: 2;
  }
}

.photo-section {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.photo-container {
  width: 200px;
  height: 200px;
  border-radius: 50%;
  overflow: hidden;
  position: relative;
  cursor: pointer;
  background-color: #f0f0f0;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 1rem;
}

.profile-photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.photo-placeholder {
  font-size: 5rem;
  color: #ccc;
}

.photo-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.7);
  color: white;
  padding: 0.5rem;
  text-align: center;
  opacity: 0;
  transition: opacity 0.3s;
}

.photo-container:hover .photo-overlay {
  opacity: 1;
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
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
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
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 0.75rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 600;
}

.cancel-button {
  flex: 1;
  background-color: #f44336;
  color: white;
  border: none;
  padding: 0.75rem 1rem;
  border-radius: 4px;
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
</style>
