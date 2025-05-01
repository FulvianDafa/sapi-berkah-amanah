<template>
  <div class="min-h-screen bg-white">
    <Navbar />

    <div class="p-8">
      <h1 class="text-3xl font-bold text-center mb-8">Katalog Sapi</h1>

      <!-- Tab Kategori -->
      <div class="flex flex-wrap justify-center space-x-4 border-b pb-2 mb-6">
        <button
          v-for="(cat, index) in categories"
          :key="index"
          @click="selectedCategory = cat.name"
          :class="[
            'text-lg font-semibold pb-2',
            selectedCategory === cat.name
              ? 'border-b-4 border-green-500 text-green-600'
              : 'text-gray-600'
          ]"
        >
          {{ cat.name }}
        </button>
      </div>

      <!-- Grid Item Sapi -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <div
          v-for="(item, index) in filteredItems"
          :key="index"
          class="p-4 bg-green-50 rounded-lg shadow hover:shadow-md transition"
        >
          <img
            :src="item.image"
            alt="sapi"
            class="w-full h-40 object-cover rounded mb-4"
          />
          <h3 class="text-lg font-bold text-green-700">{{ item.name }}</h3>
          <p class="text-sm text-gray-600">{{ item.weight }} kg</p>
          <p class="text-sm text-gray-500 italic">{{ item.class }}</p>

          <!-- Tombol WhatsApp -->
          <a
            :href="`https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20untuk%20memesan%20${encodeURIComponent(item.name)}.%20Apakah%20masih%20tersedia?`"
            target="_blank"
            class="mt-4 inline-block bg-green-600 text-white text-sm px-4 py-2 rounded-full hover:bg-green-700 transition"
          >
            Booking via WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Navbar from '../components/Navbar.vue'
import { ref, computed } from 'vue'

// Kategori aktif
const selectedCategory = ref('Prime Class')

// Kategori sapi
const categories = [
  { name: 'Prime Class' },
  { name: 'Bigboss Class' },
  { name: 'Sultan Class' }
]

// Data sapi
const sapiItems = [
  {
    name: 'Sapi Prime 1',
    weight: 500,
    class: 'Prime Class',
    image: '/assets/sapi1.jpg'
  },
  {
    name: 'Sapi Bigboss 1',
    weight: 620,
    class: 'Bigboss Class',
    image: '/assets/sapi2.jpg'
  },
  {
    name: 'Sapi Sultan 1',
    weight: 750,
    class: 'Sultan Class',
    image: '/assets/sapi3.jpg'
  },
  {
    name: 'Sapi Bigboss 2',
    weight: 670,
    class: 'Bigboss Class',
    image: '/assets/sapi1.jpg'
  },
  {
    name: 'Sapi Sultan 2',
    weight: 720,
    class: 'Sultan Class',
    image: '/assets/sapi2.jpg'
  }
]

// Filter berdasarkan kategori aktif
const filteredItems = computed(() =>
  sapiItems.filter((item) => item.class === selectedCategory.value)
)
</script>
