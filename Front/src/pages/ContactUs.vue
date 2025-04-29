<template>
  <div>
    <NavBar />
    <div class="container mx-auto px-4 py-8 max-w-4xl">
      <h1 class="text-3xl font-bold text-center mb-8">Kontak dengan Kami</h1>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <form @submit.prevent="submitForm" class="space-y-6">
          <div>
            <label for="name" class="block text-gray-700 font-medium mb-2">Nama :</label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label for="email" class="block text-gray-700 font-medium mb-2">Alamat Email :</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label for="subject" class="block text-gray-700 font-medium mb-2">Subjek :</label>
            <input
              id="subject"
              v-model="form.subject"
              type="text"
              required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label for="message" class="block text-gray-700 font-medium mb-2">Isi Pesan :</label>
            <textarea
              id="message"
              v-model="form.message"
              rows="5"
              required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
          </div>
          <div class="flex justify-end">
            <button
              type="submit"
              class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800 transition-colors"
            >
              Kirim
            </button>
          </div>
        </form>
      </div>

      <!-- Info Section -->
      <div class="bg-white p-6 rounded-lg shadow-md mt-8 flex justify-center">
        <div>
          <ul class="flex space-x-8 justify-center text-gray-700">
            <li class="flex items-center space-x-2">
              <img :src="pinIcon" alt="Alamat" class="w-8 h-8" />
              <span>Volunteer Hub Magelang, Jl. Panglima Polim V No. 60, Magelang Utara 12160</span>
            </li>
            <li class="flex items-center space-x-2">
              <img :src="whatsappIcon" alt="Nomor" class="w-7 h-7" />
              <span>+62 1122 3341 40</span>
            </li>
            <li class="flex items-center space-x-2">
              <img :src="mailIcon" alt="Email" class="w-7 h-7" />
              <span>kontak@aksirelawan.org</span>
            </li>
          </ul>
        </div>
      </div>

    </div>
    <Footer />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import NavBar from '../components/NavBar.vue';
import Footer from '../components/Footer.vue';

import pinIcon from '../assets/images/icons/pin.png';
import whatsappIcon from '../assets/images/icons/whatsapp.png';
import mailIcon from '../assets/images/icons/mail.png';

const form = ref({
  name: '',
  email: '',
  subject: '',
  message: ''
});

const submitForm = () => {
  alert(`Terima kasih, ${form.value.name}! Pesan Anda telah terkirim.`);
  form.value.name = '';
  form.value.email = '';
  form.value.subject = '';
  form.value.message = '';
};
</script>

<style scoped>
/* Add any additional styling if needed */
</style>
