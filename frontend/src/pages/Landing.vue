<template>
  <div class="min-h-screen flex flex-col">
    <Navbar />

    <!-- Hero Section -->
    <section
      class="relative h-[90vh] flex flex-col justify-center items-center text-white text-center bg-cover bg-center"
      :style="{ backgroundImage: `url(${heroImage})` }"
    >
      <h1 class="text-5xl md:text-6xl font-bold drop-shadow-lg">Sapi Berkah Amanah</h1>
      <p class="text-2xl mt-4 drop-shadow-lg">Menjual sapi kurban terpercaya</p>
    </section>

    <!-- Keunggulan Section -->
    <section class="py-16 bg-white text-center">
      <h2 class="text-3xl font-bold mb-12 text-green-700">Keunggulan Sapi Amanah</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-10 px-6 md:px-20">
        <div
          v-for="(item, index) in keunggulan"
          :key="index"
          class="relative bg-white rounded-xl shadow-lg p-6 pt-12 transition-transform hover:-translate-y-1 hover:shadow-xl"
        >
          <!-- Icon -->
          <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-white-100 p-3 rounded-full shadow">
            <img :src="item.icon" alt="Icon" class="w-12 h-12" />
          </div>
          <h3 class="text-lg font-bold text-green-800 mt-4">{{ item.title }}</h3>
          <p class="text-gray-600 text-sm mt-2">{{ item.desc }}</p>
        </div>
      </div>
    </section>

    <!-- Galeri Section -->
    <section class="py-16 bg-green-50 text-center">
      <h2 class="text-3xl font-bold mb-10">Galeri Sapi Amanah</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 md:px-20">
        <img
          v-for="(foto, index) in galeri"
          :key="index"
          :src="foto"
          class="rounded-lg shadow-lg object-cover h-60 w-full"
          alt="Foto Sapi"
        />
      </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-16 bg-green-100 px-6 md:px-20">
      <div class="flex flex-col md:flex-row items-center justify-center gap-10">

        <!-- Kiri: Gambar + Overlay Box -->
        <div class="relative w-full md:w-1/2">
          <img
            :src="ctaImage"
            alt="Sapi Berkah Amanah"
            class="rounded-2xl shadow-lg object-cover w-full h-[350px]"
          />
          <div class="absolute inset-0 flex items-center justify-center p-6">
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-6 max-w-md w-full shadow-lg">
              <h3 class="text-xl font-bold text-green-900 mb-2">
                Bergabung Bersama<br />Sapi Amanah
              </h3>
              <p class="text-sm text-gray-800">
                Sebuah platform jual sapi kurban berkualitas terjamin
              </p>
            </div>
          </div>
        </div>

        <!-- Kanan: Card Daftar Reseller / Katalog -->
        <div class="bg-green-100 rounded-2xl shadow-lg w-full md:w-1/2 flex flex-col items-center p-8 text-center">
          <div class="flex space-x-6 mb-6">
            <div class="text-2xl font-bold text-green-700">Daftar Reseller</div>
            <div class="text-2xl font-bold text-green-700">Katalog Online</div>
          </div>

          <div class="flex space-x-4 mb-10">
            <router-link to="/daftarreseller" class="bg-white text-green-700 font-semibold py-2 px-6 rounded-full shadow hover:bg-green-50">
              DAFTAR SEKARANG
            </router-link>
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
              <path d="M5 13l4 4L19 7" />
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

const heroImage = new URL('@/assets/hero-sapi.jpg', import.meta.url).href
const ctaImage = new URL('@/assets/galeri-sapi.jpg', import.meta.url).href

const keunggulan = [
  {
    title: 'Amanah',
    desc: 'Sapi dari peternak terpercaya dan jujur.',
    icon: new URL('@/assets/icons/trusted.gif', import.meta.url).href
  },
  {
    title: 'Kesehatan Terjamin',
    desc: 'Diperiksa dan divaksin oleh dokter hewan.',
    icon: new URL('@/assets/icons/healthy.gif', import.meta.url).href
  },
  {
    title: 'Kualitas Sapi Terbaik',
    desc: 'Bobot dan jenis sapi diseleksi dengan ketat.',
    icon: new URL('@/assets/icons/quality.gif', import.meta.url).href
  },
  {
    title: 'Harga Termasuk Ongkir',
    desc: 'Sudah termasuk pengiriman wilayah Jabodetabek.',
    icon: new URL('@/assets/icons/shipping.gif', import.meta.url).href
  },
  {
    title: 'Gratis Ongkir',
    desc: 'Wilayah tertentu mendapatkan pengiriman gratis.',
    icon: new URL('@/assets/icons/ongkir.gif', import.meta.url).href
  },
  {
    title: 'Layanan After Sales',
    desc: 'Bantuan kurban, video penyembelihan, dll.',
    icon: new URL('@/assets/icons/after.gif', import.meta.url).href
  }
]

const galeri = [
  new URL('@/assets/sapi1.jpg', import.meta.url).href,
  new URL('@/assets/sapi2.jpg', import.meta.url).href,
  new URL('@/assets/sapi3.jpg', import.meta.url).href
]
</script>

<style scoped>
</style>
