<template>
  <section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-8">What People Say</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div 
          v-for="(review, index) in reviews" 
          :key="index"
          class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"
        >
          <div class="flex items-center mb-4">
            <img 
              :src="review.avatar" 
              :alt="review.name"
              class="w-12 h-12 rounded-full object-cover mr-4"
            >
            <div>
              <h3 class="font-semibold text-lg">{{ review.name }}</h3>
              <div class="flex mt-1">
                <span v-for="i in 5" :key="i" class="text-yellow-400">
                  {{ i <= review.rating ? '★' : '☆' }}
                </span>
              </div>
            </div>
          </div>
          <p class="text-gray-600">{{ review.text }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      reviews: [
        {
          name: "John Doe",
          avatar: "https://randomuser.me/api/portraits/men/1.jpg",
          rating: 5,
          text: "Great experience with this platform. Highly recommended!"
        },
        {
          name: "Jane Smith",
          avatar: "https://randomuser.me/api/portraits/women/1.jpg",
          rating: 4,
          text: "Very user friendly and the support team is responsive."
        },
        {
          name: "Robert Johnson",
          avatar: "https://randomuser.me/api/portraits/men/2.jpg",
          rating: 5,
          text: "Excellent service, will definitely use again."
        }
      ]
    }
  }
}
</script>

<style scoped>
/* Additional custom styles can be added here if needed */
</style>
