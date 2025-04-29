<template>
  <div>
    <NavBar />
    <div class="container mx-auto py-8">
      <h1 class="text-3xl font-bold mb-4 text-center">Cari Organisasi</h1>
      <div class="relative mb-4 flex justify-center">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Cari"
          class="border rounded-md p-3 text-lg w-1/2 pl-4"
        />
      </div>
      <div v-if="loading" class="text-center">Loading...</div>
      <div v-if="!loading && organizations.length === 0" class="text-center">No organizations found.</div>
      <div v-if="!loading && organizations.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="org in filteredOrganizations" :key="org.id" class="border rounded p-4 flex flex-col items-center space-y-4 text-center">
          <img 
            :src="org.image" 
            alt="Organization Logo" 
            class="w-16 h-16 object-contain mb-2"
          />
          <div>
            <h2 class="font-bold">{{ org.nama }}</h2>
            <p>Email: {{ org.email }}</p>
            <p>No Telepon: {{ org.no_telp }}</p>
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import NavBar from '../components/NavBar.vue';
import Footer from '../components/Footer.vue';

const searchQuery = ref('');
const organizations = ref([]);
const loading = ref(true);

const fetchOrganizations = () => {
  // Mock data langsung di frontend
  organizations.value = [
    {
      id: 1,
      nama: 'Relawan Bencana Nasional',
      email: 'relawan@example.com',
      no_telp: '08123456789',
      image: '/src/assets/images/icon review/Logo1.png'
    },
    {
      id: 2,
      nama: 'Komunitas Peduli Lingkungan',
      email: 'lingkungan@example.com', 
      no_telp: '08234567890',
      image: '/src/assets/images/icon review/Logo2.png'
    },
    {
      id: 3,
      nama: 'Yayasan Pendidikan Anak',
      email: 'pendidikan@example.com',
      no_telp: '08345678901',
      image: '/src/assets/images/icon review/Logo3.png'
    }
  ];
  loading.value = false;
};

const filteredOrganizations = computed(() => {
  return organizations.value.filter(org => org.nama.toLowerCase().includes(searchQuery.value.toLowerCase()));
});

onMounted(fetchOrganizations);
</script>

<style scoped>
/* Add any specific styles for the organization page here */
</style>
