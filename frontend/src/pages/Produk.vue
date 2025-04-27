<template>
    <div class="min-h-screen flex flex-col">
      <Navbar />
      <main class="p-6 bg-white flex-grow">
        <h1 class="text-3xl font-bold mb-4">Daftar Sapi Kurban</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <SapiCard v-for="item in daftarSapi" :key="item.id" :sapi="item" />
        </div>
      </main>
      <Footer />
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import Navbar from '../components/Navbar.vue'
  import Footer from '../components/Footer.vue'
  import SapiCard from '../components/SapiCard.vue'
  
  const daftarSapi = ref([])
  
  onMounted(async () => {
    // Fetch data dari API Laravel nanti
    daftarSapi.value = [
      { id: 1, nama: 'Limousine', berat: 550, harga: 35000000, gambar: '/assets/limousine.jpg', wa: '62812xxxx' },
      // ...data dummy
    ]
  })
  </script>
  
  <style scoped>
  </style>
  