<template>
  <div class="bg-white min-h-screen font-sans">
    <Navbar />

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 py-2 px-6 bg-gray-100" aria-label="Breadcrumb">
      <ol class="flex items-center space-x-1">
        <li>
          <router-link to="/" class="text-green-700 hover:underline">Home</router-link>
        </li>
        <li>
          <span class="text-gray-400">›</span>
        </li>
        <router-link to="/produk" class="text-green-700 hover:underline">Katalog</router-link>
        <li>
          <span class="text-gray-400">›</span>
        </li>
        <li class="text-gray-700 font-medium">Detail Sapi</li>
      </ol>
    </nav>

    <div class="container mx-auto px-6 py-10 flex flex-col md:flex-row gap-10">
      <!-- Gambar sapi -->
      <div class="md:w-1/2">
        <div class="w-full h-[400px] bg-gray-100 rounded overflow-hidden shadow">
          <component
            :is="isVideo(currentMedia) ? 'video' : 'img'"
            :src="currentMedia"
            class="w-full h-full object-cover"
            v-bind="isVideo(currentMedia) ? videoAttrs : {}"
          />
        </div>

        <!-- Thumbnail media -->
        <div class="flex space-x-3 mt-4">
          <div
            v-for="(media, index) in sapiMedia"
            :key="index"
            class="w-20 h-20 rounded border cursor-pointer overflow-hidden"
            :class="currentIndex === index ? 'border-green-600' : 'border-gray-300'"
            @click="currentIndex = index"
          >
            <img
              v-if="!isVideo(media)"
              :src="media"
              class="w-full h-full object-cover"
            />
            <video
              v-else
              :src="media"
              class="w-full h-full object-cover"
              muted
              loop
              playsinline
            ></video>
          </div>
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="md:w-1/2">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-3xl font-bold">Deskripsi</h2>
          <router-link
            to="/produk"
            class="inline-block text-green-700 hover:underline font-semibold"
          >
            &larr; Kembali ke Katalog
          </router-link>
        </div>
        <div class="bg-white p-6 rounded shadow text-gray-700 space-y-4 leading-relaxed">
          <p v-if="sapi">{{ sapi.deskripsi }}</p>
          <p v-else>Data tidak ditemukan.</p>
          <!-- Tombol Booking WhatsApp -->
          <a
            v-if="sapi"
            :href="generateWhatsAppLink(sapi)"
            target="_blank"
            class="mt-6 inline-block bg-green-600 text-white text-sm px-6 py-3 rounded-full hover:bg-green-700 transition font-semibold"
          >
            Booking via WhatsApp
          </a>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>


<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import Navbar from '../components/Navbar.vue'
import Footer from '../components/Footer.vue'
import axios from '../services/axiosConfig'

const route = useRoute()
const sapiId = route.params.id

const sapi = ref(null)
const sapiMedia = ref([])
const currentIndex = ref(0)
const currentMedia = computed(() => sapiMedia.value[currentIndex.value] || '')
const isVideo = (src) => src && src.endsWith('.mp4')
const videoAttrs = { controls: true }

const generateWhatsAppLink = (item) => {
  const text = `Halo, saya tertarik untuk memesan sapi ${item.jenis_sapi} (${item.kategori}) dengan berat ${item.berat_sapi ?? item.berat}kg. Apakah masih tersedia?`;
  return `https://wa.me/62811440944?text=${encodeURIComponent(text)}`;
};

onMounted(async () => {
  try {
    const response = await axios.get(`/hewan-kurban/${sapiId}`)
    sapi.value = response.data.data
    sapiMedia.value = [
      ...(sapi.value.photos || []),
      ...(sapi.value.video_url ? [sapi.value.video_url] : [])
    ]
  } catch (e) {
    sapi.value = null
    sapiMedia.value = []
  }
})
</script>
