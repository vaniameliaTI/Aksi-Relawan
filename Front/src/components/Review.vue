<template>
  <section class="py-12 bg-white">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-10">Review</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
          v-for="(review, index) in reviews"
          :key="index"
          class="bg-white p-6 rounded-xl border shadow text-center hover:shadow-md transition duration-300"
        >
          <img 
            :src="review.image" 
            :alt="review.title" 
            class="mx-auto mb-4 w-12 h-12 object-contain"
          />
          <h3 class="text-blue-800 font-semibold text-base mb-2 uppercase tracking-wide">
            {{ review.title }}
          </h3>
          <hr class="border-t border-gray-300 w-10 mx-auto mb-4" />
          <p class="text-gray-600 text-sm leading-relaxed text-justify">
            {{ review.text }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "ReviewSection",
  data() {
    return {
      reviews: [
  {
    title: "Partnership",
    image: ('/assets/images/partnership.png'),
    text: "Aksi Relawan adalah platform yang sangat membantu dalam menghubungkan organisasi dengan volunteer secara efektif. Dengan tampilan yang intuitif dan fitur pendaftaran berbasis minat, website ini mempermudah relawan menemukan peluang yang sesuai, sementara sistem verifikasi organisasi memastikan kepercayaan dan transparansi. Sangat direkomendasikan bagi siapa saja yang ingin berkontribusi dalam kegiatan sosial"
  },
  {
    title: "Ingoude Company",
    image: ('/assets/images/ingoude.png'),
    text: "Aksi Relawan adalah solusi terbaik bagi organisasi yang ingin menjangkau lebih banyak volunteer dengan mudah. Proses pendaftaran yang sederhana dan sistem verifikasi organisasi membuat platform ini terpercaya dan nyaman digunakan. Sebuah inovasi yang sangat bermanfaat bagi komunitas sosial!"
  },
  {
    title: "Teamwork",
    image: ('/assets/images/teamwork.png'),
    text: "Website Aksi Relawan sangat memudahkan relawan dalam menemukan kegiatan yang sesuai dengan minat dan keterampilan mereka. Antarmukanya bersih, informatif, dan responsif, menjadikannya pilihan utama bagi siapa saja yang ingin berkontribusi dalam aksi sosial!"
  }
]
    }
  }
}
</script>