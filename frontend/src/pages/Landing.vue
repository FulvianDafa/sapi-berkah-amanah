<template>
    <div class="min-h-screen flex flex-col">
      <Navbar />
  
      <!-- Hero Section -->
      <section class="relative h-[90vh] flex flex-col justify-center items-center text-white text-center bg-cover bg-center" style="background-image: url('/src/assets/hero-sapi.jpg')">
        <h1 class="text-5xl md:text-6xl font-bold drop-shadow-lg">Sapi Berkah Amanah</h1>
        <p class="text-2xl mt-4 drop-shadow-lg">Menjual sapi kurban terpecaya</p>
      </section>
  
      <!-- Keunggulan Section -->
      <section class="py-16 bg-white text-center">
        <h2 class="text-3xl font-bold mb-10">Keunggulan Sapi Amanah</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 md:px-20">
          <div v-for="(item, index) in keunggulan" :key="index" class="bg-green-100 p-6 rounded-lg shadow-md">
            <div class="text-2xl font-bold mb-2">{{ index + 1 }}</div>
            <h3 class="text-xl font-semibold">{{ item.title }}</h3>
            <p class="text-gray-600 mt-2">{{ item.desc }}</p>
          </div>
        </div>
      </section>
  
      <!-- Galeri Section -->
      <section class="py-16 bg-green-50 text-center">
        <h2 class="text-3xl font-bold mb-10">Galeri Sapi Amanah</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 md:px-20">
          <img v-for="(foto, index) in galeri" :key="index" :src="foto" class="rounded-lg shadow-lg object-cover h-60 w-full" alt="Foto Sapi" />
        </div>
      </section>
  
      <!-- Call to Action Section -->
      <section class="py-16 bg-green-100 px-6 md:px-20">
  <div class="flex flex-col md:flex-row items-center justify-center gap-10">

    <!-- Kiri: Gambar + Overlay Text -->
    <div class="relative w-full md:w-1/2">
      <img src="/src/assets/galeri-sapi.jpg" alt="Sapi Berkah Amanah" class="rounded-2xl shadow-lg object-cover w-full h-[350px]" />
      <div class="absolute inset-0 bg-black bg-opacity-40 rounded-2xl flex flex-col justify-center items-start p-6">
        <h3 class="text-2xl font-bold text-white mb-2">Bergabung Bersama<br/>Sapi Amanah</h3>
        <p class="text-white text-sm">Sebuah platform jual sapi kurban berkualitas terjamin</p>
      </div>
    </div>

    <!-- Kanan: Card Daftar Reseller / Katalog -->
    <div class="bg-green-100 rounded-2xl shadow-lg w-full md:w-1/2 flex flex-col items-center p-8 text-center">
      <div class="flex space-x-6 mb-6">
        <div class="text-2xl font-bold text-green-700">Daftar Reseller</div>
        <div class="text-2xl font-bold text-green-700">Katalog Online</div>
      </div>

      <div class="flex space-x-4 mb-10">
        <a href="https://forms.gle/your-google-form-link" target="_blank" class="bg-white text-green-700 font-semibold py-2 px-6 rounded-full shadow hover:bg-green-50">
          DAFTAR SEKARANG
        </a>
        <router-link to="/produk" class="bg-white text-green-700 font-semibold py-2 px-6 rounded-full shadow hover:bg-green-50">
          CHECK KATALOG
        </router-link>
      </div>

      <div class="text-2xl font-bold text-green-700 mb-4">Ada Pertanyaan ?</div>

      <a
        href="https://wa.me/6281234567890?text=Halo%20saya%20mau%20cek%20katalog%20sapi"
        target="_blank"
        class="flex items-center justify-center bg-white text-green-700 py-2 px-6 rounded-full shadow hover:bg-green-50"
      >
        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
          <path d="M...Z" /> <!-- (kamu bisa pasang logo WA SVG atau pakai icon dari Heroicons) -->
        </svg>
        HUBUNGI KAMI
      </a>
    </div>

  </div>
</section>

  
      <Footer />
    </div>
  </template>
  
  <script setup>
  import Navbar from '../components/Navbar.vue'
  import Footer from '../components/Footer.vue'
  
  const keunggulan = [
    { title: 'Amanah', desc: 'Lorem ipsum' },
    { title: 'Kesehatan Terjamin', desc: 'Lorem ipsum' },
    { title: 'Kualitas Sapi Terbaik', desc: 'Lorem ipsum' },
    { title: 'Harga Sudah Termasuk Ongkir', desc: 'Lorem ipsum' },
    { title: 'Gratis Ongkir', desc: 'Lorem ipsum' },
  ]
  
  const galeri = [
    '/assets/sapi1.jpg',
    '/assets/sapi2.jpg',
    '/assets/sapi3.jpg',
  ]
  </script>
  
  <style scoped>
  </style>
  