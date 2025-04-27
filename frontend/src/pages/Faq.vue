<template>
    <div class="min-h-screen flex flex-col">
      <Navbar />
  
      <main class="flex-grow p-8 bg-green-50">
        <h1 class="text-4xl font-bold text-center text-green-700 mb-10">Frequently Asked Questions</h1>
  
        <div class="max-w-4xl mx-auto space-y-6">
          <div v-for="(item, index) in faqList" :key="index" class="bg-white p-6 rounded-lg shadow-md">
            <div @click="toggle(index)" class="flex justify-between items-center cursor-pointer">
              <h2 class="text-xl font-semibold">{{ item.question }}</h2>
              <svg
                :class="{ 'transform rotate-180': item.open }"
                class="w-6 h-6 transition-transform duration-300"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7" />
              </svg>
            </div>
  
            <div v-show="item.open" class="mt-4 text-gray-600 transition-all duration-300">
              {{ item.answer }}
            </div>
          </div>
        </div>
      </main>
  
      <Footer />
    </div>
  </template>
  
  <script setup>
  import Navbar from '../components/Navbar.vue'
  import Footer from '../components/Footer.vue'
  import { reactive } from 'vue'
  
  const faqList = reactive([
    {
      question: 'Bagaimana cara memesan sapi kurban di Sapi Amanah?',
      answer: 'Anda bisa langsung memilih sapi dari katalog kami dan klik tombol Booking WA untuk menghubungi kami.',
      open: false
    },
    {
      question: 'Apakah sapi yang dijual sudah memenuhi syarat kurban?',
      answer: 'Semua sapi kami telah memenuhi syarat kurban sesuai syariat Islam, termasuk umur dan kesehatan.',
      open: false
    },
    {
      question: 'Apakah harga sudah termasuk ongkos kirim?',
      answer: 'Ya, harga yang tertera sudah termasuk ongkos kirim ke area Jabodetabek.',
      open: false
    },
    {
      question: 'Apakah ada layanan titip sapi untuk kurban?',
      answer: 'Kami menyediakan layanan titip sapi di tempat kami hingga hari H penyembelihan.',
      open: false
    },
    {
      question: 'Bagaimana cara bergabung menjadi reseller?',
      answer: 'Anda bisa mendaftar menjadi reseller melalui link pendaftaran reseller yang tersedia di website kami.',
      open: false
    },
  ])
  
  const toggle = (index) => {
    faqList[index].open = !faqList[index].open
  }
  </script>
  
  <style scoped>
  /* tambahan efek transisi smooth */
  </style>
  