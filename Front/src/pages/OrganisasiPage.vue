<template>
  <div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-4">Cari Organisasi</h1>
    <input
      v-model="searchQuery"
      type="text"
      placeholder="Cari organisasi..."
      class="border rounded p-2 mb-4 w-full"
    />
    <div v-if="loading" class="text-center">Loading...</div>
    <div v-if="!loading && organizations.length === 0" class="text-center">No organizations found.</div>
    <div v-if="!loading && organizations.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="org in filteredOrganizations" :key="org.id" class="border rounded p-4">
        <h2 class="font-bold">{{ org.nama }}</h2>
        <p>Email: {{ org.email }}</p>
        <p>No Telepon: {{ org.no_telp }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';

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
      no_telp: '08123456789'
    },
    {
      id: 2,
      nama: 'Komunitas Peduli Lingkungan',
      email: 'lingkungan@example.com', 
      no_telp: '08234567890'
    },
    {
      id: 3,
      nama: 'Yayasan Pendidikan Anak',
      email: 'pendidikan@example.com',
      no_telp: '08345678901'
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
