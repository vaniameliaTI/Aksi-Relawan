import { ref, computed } from 'vue'

const activities = [
  {
    id: 1,
    title: 'Relawan Edukasi Mitigasi Bencana',
    organization: 'Badan Nasional Penanggulangan Bencana (BNPB)',
    date: '21 Maret 2025',
    location: 'Jakarta, Indonesia',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Mitigasi Bencana']
  },
  {
    id: 2,
    title: 'Aksi Hijau untuk Bumi',
    organization: 'Organisasi Peduli Lingkungan',
    date: '25 Maret 2025',
    location: 'Kota Yogyakarta',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Lingkungan']
  },
  {
    id: 3,
    title: 'Relawan Pengajar',
    organization: 'Sobat Mengajar',
    date: '2 Maret 2025',
    location: 'Kota Surabaya',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Pendidikan']
  },
  {
    id: 4,
    title: 'Aksi Bersih Pantai',
    organization: 'Komunitas Peduli Lingkungan',
    date: '10 April 2025',
    location: 'Bali',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Lingkungan']
  },
  {
    id: 5,
    title: 'Pelatihan Kesehatan Masyarakat',
    organization: 'Yayasan Kesehatan',
    date: '15 April 2025',
    location: 'Bandung',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Kesehatan']
  },
  {
    id: 6,
    title: 'Kampanye Pendidikan Anak',
    organization: 'Lembaga Pendidikan',
    date: '20 April 2025',
    location: 'Semarang',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Pendidikan']
  },
  {
    id: 7,
    title: 'Donor Darah Massal',
    organization: 'Palang Merah Indonesia',
    date: '25 April 2025',
    location: 'Jakarta',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Kesehatan']
  },
  {
    id: 8,
    title: 'Pelatihan Mitigasi Bencana',
    organization: 'BNPB',
    date: '30 April 2025',
    location: 'Surabaya',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Mitigasi Bencana']
  },
  {
    id: 9,
    title: 'Kegiatan Sosial Masyarakat',
    organization: 'Lembaga Sosial',
    date: '5 Mei 2025',
    location: 'Yogyakarta',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Sosial']
  },
  {
    id: 10,
    title: 'Pelatihan Seni Budaya',
    organization: 'Komunitas Seni',
    date: '10 Mei 2025',
    location: 'Bandung',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Seni Budaya']
  },
  {
    id: 11,
    title: 'Kampanye Lingkungan Hidup',
    organization: 'Organisasi Lingkungan',
    date: '15 Mei 2025',
    location: 'Jakarta',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Lingkungan']
  },
  {
    id: 12,
    title: 'Pelatihan Kesehatan Anak',
    organization: 'Yayasan Kesehatan Anak',
    date: '20 Mei 2025',
    location: 'Semarang',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Kesehatan']
  },
  {
    id: 13,
    title: 'Aksi Peduli Pendidikan',
    organization: 'Lembaga Pendidikan',
    date: '25 Mei 2025',
    location: 'Surabaya',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Pendidikan']
  },
  {
    id: 14,
    title: 'Donor Organisasi Sosial',
    organization: 'Organisasi Sosial',
    date: '30 Mei 2025',
    location: 'Yogyakarta',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Sosial']
  },
  {
    id: 15,
    title: 'Pelatihan Mitigasi Bencana Lanjutan',
    organization: 'BNPB',
    date: '5 Juni 2025',
    location: 'Jakarta',
    image: '/src/assets/images/Aksi.png',
    categories: ['Event', 'Mitigasi Bencana']
  }
]

const activitiesRef = ref(activities)

const filteredActivities = computed(() => {
  // For now, no filtering, just return all activities
  return activitiesRef.value
})

// Add reactive refs for filters
const selectedOrganizationName = ref('')
const selectedLocation = ref('')
const selectedTipeKegiatan = ref('')

export function useActivities() {
  return {
    activities: activitiesRef,
    filteredActivities,
    selectedOrganizationName,
    selectedLocation,
    selectedTipeKegiatan
  }
}
