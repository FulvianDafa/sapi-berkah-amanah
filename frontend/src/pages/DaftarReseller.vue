<template>
  <div
    v-if="isLoading"
    class="fixed inset-0 flex items-center justify-center bg-white z-50"
  >
    <div class="flex flex-col items-center gap-4">
      <svg
        class="animate-spin h-10 w-10 text-green-600"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
        ></path>
      </svg>
      <span class="text-green-600 font-semibold">Memuat Halaman...</span>
    </div>
  </div>

  <div
    v-else
    class="min-h-screen flex flex-col items-center justify-center bg-green-50 px-4 py-10"
  >
    <h1 class="text-3xl font-bold mb-8 text-green-700">
      Form Pendaftaran Reseller
    </h1>
    <form
      @submit.prevent="handleSubmit"
      class="bg-white p-6 rounded-lg shadow-md w-full max-w-xl space-y-4"
    >
      <div>
        <label class="block font-semibold mb-1">Nama Lengkap</label>
        <input
          v-model="form.nama"
          type="text"
          required
          placeholder="Masukkan nama lengkap Anda"
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label class="block font-semibold mb-1">Nomor WhatsApp</label>
        <input
          v-model="form.wa"
          type="tel"
          required
          placeholder="Contoh: 081234567890"
          class="w-full p-2 border rounded"
          @input="form.wa = form.wa.replace(/\D/g, '')"
        />
      </div>

      <div>
        <label class="block font-semibold mb-1">Profesi</label>
        <input
          v-model="form.profesi"
          type="text"
          required
          placeholder="Masukkan profesi Anda"
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label class="block font-semibold mb-1">Alamat</label>
        <textarea
          v-model="form.alamat"
          required
          placeholder="Masukkan alamat lengkap Anda"
          class="w-full p-2 border rounded"
        ></textarea>
      </div>

      <div>
        <label class="block font-semibold mb-1">
          Apakah Anda punya rekening?
        </label>
        <select v-model="punyaRekening" class="w-full p-2 border rounded">
          <option value="tidak">Tidak</option>
          <option value="ya">Ya</option>
        </select>
      </div>

      <div v-if="punyaRekening === 'ya'" class="space-y-4">
        <div>
          <label class="block font-semibold mb-1">Nama Bank</label>
          <input
            v-model="form.bank"
            type="text"
            placeholder="Contoh: BCA, BRI, Mandiri"
            class="w-full p-2 border rounded"
          />
        </div>

        <div>
          <label class="block font-semibold mb-1">Nomor Rekening</label>
          <input
            v-model="form.norek"
            type="text"
            placeholder="Masukkan nomor rekening Anda"
            class="w-full p-2 border rounded"
            @input="form.norek = form.norek.replace(/\D/g, '')"
          />
        </div>

        <div>
          <label class="block font-semibold mb-1">Atas Nama</label>
          <input
            v-model="form.atasNama"
            type="text"
            placeholder="Nama pemilik rekening"
            class="w-full p-2 border rounded"
          />
        </div>
      </div>

      <div class="flex gap-4">
        <button
          type="submit"
          class="flex-1 bg-green-600 text-white py-2 rounded hover:bg-green-700 transition"
        >
          Daftar Sekarang
        </button>
        <button
          type="button"
          @click="showCancelConfirm = true"
          class="flex-1 bg-gray-200 text-gray-700 py-2 rounded hover:bg-gray-300 transition"
        >
          Cancel
        </button>
      </div>
    </form>

    <!-- Popup Konfirmasi -->
    <div
      v-if="showCancelConfirm"
      @click.self="showCancelConfirm = false"
      class="fixed inset-0 flex items-center justify-center backdrop-blur-sm bg-white/30 z-50 transition"
    >
      <div class="bg-white rounded-xl shadow-xl p-6 max-w-sm w-full text-center">
        <p class="mb-6 text-lg font-medium text-gray-800">
          Yakin ingin membatalkan pendaftaran?
        </p>
        <div class="flex justify-center gap-4">
          <button
            @click="cancelForm"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition"
          >
            Ya
          </button>
          <button
            @click="showCancelConfirm = false"
            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition"
          >
            Tidak
          </button>
        </div>
      </div>
    </div>
  </div>

  <Footer />
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { useRouter } from "vue-router";
import Footer from "../components/Footer.vue";
import axios from "../services/axiosConfig";

const router = useRouter();
const isLoading = ref(true);

onMounted(() => {
  setTimeout(() => {
    isLoading.value = false;
  }, 900);
});

const form = reactive({
  nama: "",
  wa: "",
  profesi: "",
  alamat: "",
  bank: "",
  norek: "",
  atasNama: "",
});

const punyaRekening = ref("tidak");
const showCancelConfirm = ref(false);

const handleSubmit = async () => {
  if (!form.nama || !form.wa || !form.profesi || !form.alamat) {
    alert("Silakan isi semua data yang wajib.");
    return;
  }

  if (!/^\d+$/.test(form.wa)) {
    alert("Nomor WhatsApp harus berupa angka.");
    return;
  }

  if (punyaRekening.value === "ya" && form.norek && !/^\d+$/.test(form.norek)) {
    alert("Nomor Rekening harus berupa angka.");
    return;
  }

  if (!/^\d+$/.test(form.wa)) {
    alert("Nomor WhatsApp harus berupa angka.");
    return;
  }

  if (punyaRekening.value === "ya" && form.norek && !/^\d+$/.test(form.norek)) {
    alert("Nomor Rekening harus berupa angka.");
    return;
  }

  try {
    isLoading.value = true;

    await axios.post("/daftar-reseller", {
      nama: form.nama,
      wa: form.wa,
      profesi: form.profesi,
      alamat: form.alamat,
      punyaRekening: punyaRekening.value,
      bank: punyaRekening.value === "ya" ? form.bank : "",
      norek: punyaRekening.value === "ya" ? form.norek : "",
      atasNama: punyaRekening.value === "ya" ? form.atasNama : "",
    });

    // Reset form field
    form.nama = "";
    form.wa = "";
    form.profesi = "";
    form.alamat = "";
    form.bank = "";
    form.norek = "";
    form.atasNama = "";
    punyaRekening.value = "tidak";
    
    // Loading false
    isLoading.value = false;

    // Alert pendaftaran berhasil
    alert("Pendaftaran berhasil. Silakan cek grup WA untuk informasi lebih lanjut.");

    // Redirect ke grup WA
    window.location.href = "https://chat.whatsapp.com/LyNfB43cenIJKc8jZMATlq";
  } catch (e) {
    alert("Gagal mengirim data. Coba lagi.");
    isLoading.value = false;
  }
};

const cancelForm = () => {
  showCancelConfirm.value = false;
  router.back();
};
</script>
