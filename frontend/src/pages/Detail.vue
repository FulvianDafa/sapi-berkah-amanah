<template>
    <div class="min-h-screen flex flex-col">
      <Navbar />
      <main class="p-6 bg-white flex-grow">
        <h1 class="text-3xl font-bold mb-4">Detail Sapi Kurban</h1>
        <p>Detail sapi ID: {{ id }}</p>
        <!-- nanti tampilkan detail lengkap dari API berdasarkan param route -->
      </main>
      <Footer />
    </div>
  </template>
  
  <script setup>
  import { useRoute } from 'vue-router'
  import Navbar from '../components/Navbar.vue'
  import Footer from '../components/Footer.vue'
  
  const route = useRoute()
  const id = route.params.id
  </script>
  
  <style scoped>
  </style>
  