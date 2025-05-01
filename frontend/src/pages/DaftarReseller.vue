<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-green-50 px-4 py-10">
      <h1 class="text-3xl font-bold mb-8 text-green-700">Form Pendaftaran Reseller</h1>
  
      <form @submit.prevent="handleSubmit" class="bg-white p-6 rounded-lg shadow-md w-full max-w-xl space-y-4">
        <div>
          <label class="block font-semibold mb-1">Nama Lengkap</label>
          <input v-model="form.nama" type="text" required class="w-full p-2 border rounded" />
        </div>
  
        <div>
          <label class="block font-semibold mb-1">Nomor WhatsApp</label>
          <input v-model="form.wa" type="tel" required class="w-full p-2 border rounded" />
        </div>
  
        <div>
          <label class="block font-semibold mb-1">Profesi</label>
          <input v-model="form.profesi" type="text" required class="w-full p-2 border rounded" />
        </div>
  
        <div>
          <label class="block font-semibold mb-1">Alamat</label>
          <textarea v-model="form.alamat" required class="w-full p-2 border rounded"></textarea>
        </div>
  
        <div>
          <label class="block font-semibold mb-1">Apakah Anda punya rekening?</label>
          <select v-model="punyaRekening" class="w-full p-2 border rounded">
            <option value="tidak">Tidak</option>
            <option value="ya">Ya</option>
          </select>
        </div>
  
        <!-- Tampilkan jika punya rekening -->
        <div v-if="punyaRekening === 'ya'" class="space-y-4">
          <div>
            <label class="block font-semibold mb-1">Nama Bank</label>
            <input v-model="form.bank" type="text" class="w-full p-2 border rounded" />
          </div>
  
          <div>
            <label class="block font-semibold mb-1">Nomor Rekening</label>
            <input v-model="form.norek" type="text" class="w-full p-2 border rounded" />
          </div>
  
          <div>
            <label class="block font-semibold mb-1">Atas Nama</label>
            <input v-model="form.atasNama" type="text" class="w-full p-2 border rounded" />
          </div>
        </div>
  
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
          Daftar Sekarang
        </button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { reactive, ref } from 'vue'
  import Navbar from '../components/Navbar.vue'
  import Footer from '../components/Footer.vue'
  
  // Form data
  const form = reactive({
    nama: '',
    wa: '',
    profesi: '',
    alamat: '',
    bank: '',
    norek: '',
    atasNama: ''
  })
  
  const punyaRekening = ref('tidak')
  
  // Handler submit
  const handleSubmit = () => {
    // Validasi minimal
    if (!form.nama || !form.wa || !form.profesi || !form.alamat) {
      alert('Silakan isi semua data yang wajib.')
      return
    }
  
    // Simulasi kirim data ke backend (bisa pakai axios.post)
  
    // Setelah submit → redirect ke grup WA
    window.location.href = 'https://chat.whatsapp.com/GRUP_LINK';
  }
  </script>
  