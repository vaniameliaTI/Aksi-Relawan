<template>
  <div>
    <NavBar />
    <div class="container mx-auto py-8">
<h1 class="text-3xl font-bold mb-4 text-center" style="color: #000000;">Cari Organisasi</h1>
      <p class="mb-8">Jelajahi berbagai organisasi yang membuka kesempatan bagi relawan untuk terlibat dalam program-program mereka. Dapatkan informasi mengenai visi, misi, dan fokus kegiatan dari setiap organisasi. Dengan bergabung bersama organisasi yang sejalan dengan nilai Anda, peran relawan dapat dijalankan secara lebih bermakna dan berkelanjutan.</p>
      <div class="max-w-4xl mx-auto mb-12">
        <form @submit.prevent="applySearch" class="flex bg-white rounded-full shadow-sm p-2 gap-x-3 items-center w-1/2 mx-auto search-bar">
          <input
            v-model="localSearchInput"
            type="text"
            placeholder="Cari organisasi..."
            class="flex-grow px-4 py-2 bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 text-sm"
          />
          <button
            type="submit"
            class="px-6 py-2 bg-blue-900 text-white font-medium rounded-full hover:bg-blue-800 transition-colors text-sm"
          >
            <span class="flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Cari
            </span>
          </button>
        </form>
      </div>
      <div v-if="loading" class="text-center">Loading...</div>
      <div v-if="!loading && organizations.length === 0" class="text-center">No organizations found.</div>
      <div v-if="!loading && organizations.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="org in displayedOrganizations" :key="org.id" class="bg-white border rounded p-4 flex flex-col items-center space-y-4 text-center hover:shadow-lg hover:scale-105 transition-transform transition-shadow duration-300 cursor-pointer hover:scale-[1.02]">
          <img 
            :src="org.image" 
            alt="Organization Logo" 
            class="w-16 h-16 object-contain mb-2"
          />
          <div>
            <h2 class="font-bold" style="color: #000000;">{{ org.nama }}</h2>
<p class="text-sm">{{ org.kategori }}</p>
            <p>Email: {{ org.email }}</p>
            <p>No Telepon: {{ org.no_telp }}</p>
          </div>
        </div>
      <div v-if="!showAll && filteredOrganizations.length > 1" class="col-span-full text-center">
        <button class="show-all-button rounded-lg" @click="showAll = true">Show All</button>
      </div>
      <div v-else-if="showAll" class="col-span-full text-center">
        <button class="show-all-button rounded-lg" @click="showAll = false">Show Less</button>
      </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import NavBar from '../components/NavBar.vue';
import Footer from '../components/Footer.vue';

const searchQuery = ref('');
const localSearchInput = ref('');
const organizations = ref([]);
const loading = ref(true);
const showAll = ref(false);

const route = useRoute();

const fetchOrganizations = () => {
  // Mock data langsung di frontend
  organizations.value = [
    {
      id: 1,
      nama: 'Relawan Bencana Nasional',
      kategori: 'Mitigasi Bencana & Lingkungan',
      email: 'relawan@example.com',
      no_telp: '08123456789',
      image: '/src/assets/images/icon review/Logo1.png'
    },
    {
      id: 2,
      nama: 'Komunitas Peduli Lingkungan',
      kategori: 'Mitigasi Bencana & Lingkungan',
      email: 'lingkungan@example.com', 
      no_telp: '08234567890',
      image: '/src/assets/images/icon review/Logo2.png'
    },
    {
      id: 3,
      nama: 'Yayasan Pendidikan Anak',
      kategori: 'Pendidikan & Seni Budaya',
      email: 'pendidikan@example.com',
      no_telp: '08345678901',
      image: '/src/assets/images/icon review/Logo3.png'
    },
    {
      id: 4,
      nama: 'Lembaga Sosial Kemanusiaan',
      kategori: 'Sosial & Kemanusiaan',
      email: 'sosial@example.com',
      no_telp: '08456789012',
      image: '/src/assets/images/icon review/Logo1.png'
    },
    {
      id: 5,
      nama: 'Yayasan Kesehatan Masyarakat',
      kategori: 'Kesehatan',
      email: 'kesehatan@example.com',
      no_telp: '08567890123',
      image: '/src/assets/images/icon review/Logo2.png'
    },
    {
      id: 6,
      nama: 'Komunitas Seni Budaya Nusantara',
      kategori: 'Pendidikan & Seni Budaya',
      email: 'seni@example.com',
      no_telp: '08678901234',
      image: '/src/assets/images/icon review/Logo3.png'
    },
    {
      id: 7,
      nama: 'Yayasan Peduli Anak',
      kategori: 'Sosial & Kemanusiaan',
      email: 'anak@example.com',
      no_telp: '08789012345',
      image: '/src/assets/images/icon review/Logo1.png'
    },
    {
      id: 8,
      nama: 'Lembaga Kesehatan Masyarakat',
      kategori: 'Kesehatan',
      email: 'kesehatan2@example.com',
      no_telp: '08890123456',
      image: '/src/assets/images/icon review/Logo2.png'
    },
    {
      id: 9,
      nama: 'Relawan Lingkungan Hidup',
      kategori: 'Mitigasi Bencana & Lingkungan',
      email: 'lingkungan2@example.com',
      no_telp: '08901234567',
      image: '/src/assets/images/icon review/Logo1.png'
    },
    {
      id: 10,
      nama: 'Yayasan Pendidikan Anak Bangsa',
      kategori: 'Pendidikan & Seni Budaya',
      email: 'pendidikan2@example.com',
      no_telp: '08012345678',
      image: '/src/assets/images/icon review/Logo3.png'
    },
    {
      id: 11,
      nama: 'Lembaga Sosial Peduli Masyarakat',
      kategori: 'Sosial & Kemanusiaan',
      email: 'sosial2@example.com',
      no_telp: '08123456780',
      image: '/src/assets/images/icon review/Logo2.png'
    },
    {
      id: 12,
      nama: 'Yayasan Kesehatan Anak',
      kategori: 'Kesehatan',
      email: 'kesehatan3@example.com',
      no_telp: '08234567890',
      image: '/src/assets/images/icon review/Logo1.png'
    },
    {
      id: 13,
      nama: 'Komunitas Mitigasi Bencana',
      kategori: 'Mitigasi Bencana & Lingkungan',
      email: 'mitigasi@example.com',
      no_telp: '08345678901',
      image: '/src/assets/images/icon review/Logo3.png'
    },
    {
      id: 14,
      nama: 'Yayasan Seni dan Budaya',
      kategori: 'Pendidikan & Seni Budaya',
      email: 'seni2@example.com',
      no_telp: '08456789012',
      image: '/src/assets/images/icon review/Logo2.png'
    },
    {
      id: 15,
      nama: 'Lembaga Sosial dan Kemanusiaan',
      kategori: 'Sosial & Kemanusiaan',
      email: 'sosial3@example.com',
      no_telp: '08567890123',
      image: '/src/assets/images/icon review/Logo1.png'
    }
  ];
  loading.value = false;
};

function applySearch() {
  searchQuery.value = localSearchInput.value;
}

const filteredOrganizations = computed(() => {
  const kategoriFilter = route.query.kategori ? route.query.kategori.toString().toLowerCase() : '';
  return organizations.value.filter(org => {
    const matchesName = org.nama.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchesCategory = kategoriFilter ? org.kategori.toLowerCase().includes(kategoriFilter) : true;
    return matchesName && matchesCategory;
  });
});

const displayedOrganizations = computed(() => {
  if (showAll.value) {
    return filteredOrganizations.value;
  } else {
    return filteredOrganizations.value.slice(0, 3);
  }
});

onMounted(() => {
  fetchOrganizations();
  window.scrollTo(0, 0);
});
</script>

<style scoped>
/* Add any specific styles for the organization page here */
.show-all-button {
  display: inline-flex; /* Pastikan tombol hanya selebar kontennya */
  align-items: center; /* Vertikal rata tengah */
  justify-content: center; /* Horizontal rata tengah */
  padding: 0.5rem 1rem; /* Sesuaikan padding untuk ukuran tombol */
  font-size: 1rem; /* Ukuran font yang sesuai */
  line-height: 1; /* Pastikan tinggi teks tidak memanjang */
  height: auto; /* Pastikan tinggi tombol tidak memanjang */
  width: auto; /* Pastikan lebar tombol hanya mengikuti konten */
  color: #1e3a8a; /* Warna teks */
  background: none; /* Hilangkan background */
  border: none; /* Hilangkan border */
  cursor: pointer;
  transition: color 0.3s ease, transform 0.3s ease;
  white-space: nowrap; /* Mencegah teks menjadi dua baris */
}

.show-all-button:hover {
  color: #2563eb; /* Warna teks saat hover */
  transform: scale(1.05); /* Efek zoom saat hover */
}

.show-all-button::after {
  content: none; /* Hilangkan underline */
}
.search-bar:hover {
  box-shadow: 0 0 10px rgba(37, 99, 235, 0.6);
  transition: box-shadow 0.3s ease-in-out;
  cursor: text;
}
</style>
