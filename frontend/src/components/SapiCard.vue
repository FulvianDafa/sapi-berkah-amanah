<template>
    <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-xl transition p-4 flex flex-col">
      <img :src="sapi.gambar" alt="foto sapi" class="h-48 w-full object-cover mb-4">
      <h2 class="text-lg font-semibold mb-1">{{ sapi.nama }}</h2>
      <p class="text-sm text-gray-600 mb-1">Berat: {{ sapi.berat }} kg</p>
      <p class="text-sm text-gray-600 mb-2">Harga: Rp {{ sapi.harga.toLocaleString() }}</p>
      <button
        @click="hubungiWA"
        class="mt-auto bg-green-700 text-white py-2 rounded hover:bg-green-600"
      >
        Hubungi via WhatsApp
      </button>
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue'
  import { generateWaLink } from '../utils/waLink'
  
  defineProps({
    sapi: { type: Object, required: true }
  })
  
  const hubungiWA = () => {
    const url = generateWaLink(sapi.nama, sapi.berat, sapi.harga, sapi.wa)
    window.open(url, '_blank')
  }
  </script>
  
  <style scoped>
  </style>
  
  