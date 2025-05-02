<template>
  <div
    class="min-h-screen flex flex-col items-center justify-center bg-green-50 px-4 py-10"
  >
    <h1 class="text-3xl font-bold mb-8 text-green-700">
      Form Pendaftaran Reseller
    </h1>
    <button
      @click="goBack"
      class="mt-6 text-sm text-green-700 hover:underline hover:text-green-900 transition"
    >
      ←
    </button>
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
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label class="block font-semibold mb-1">Nomor WhatsApp</label>
        <input
          v-model="form.wa"
          type="tel"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label class="block font-semibold mb-1">Profesi</label>
        <input
          v-model="form.profesi"
          type="text"
          required
          class="w-full p-2 border rounded"
        />
      </div>

      <div>
        <label class="block font-semibold mb-1">Alamat</label>
        <textarea
          v-model="form.alamat"
          required
          class="w-full p-2 border rounded"
        ></textarea>
      </div>

      <div>
        <label class="block font-semibold mb-1"
          >Apakah Anda punya rekening?</label
        >
        <select v-model="punyaRekening" class="w-full p-2 border rounded">
          <option value="tidak">Tidak</option>
          <option value="ya">Ya</option>
        </select>
      </div>

      <!-- Tampilkan jika punya rekening -->
      <div v-if="punyaRekening === 'ya'" class="space-y-4">
        <div>
          <label class="block font-semibold mb-1">Nama Bank</label>
          <input
            v-model="form.bank"
            type="text"
            class="w-full p-2 border rounded"
          />
        </div>

        <div>
          <label class="block font-semibold mb-1">Nomor Rekening</label>
          <input
            v-model="form.norek"
            type="text"
            class="w-full p-2 border rounded"
          />
        </div>

        <div>
          <label class="block font-semibold mb-1">Atas Nama</label>
          <input
            v-model="form.atasNama"
            type="text"
            class="w-full p-2 border rounded"
          />
        </div>
      </div>

      <button
        type="submit"
        class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition"
      >
        Daftar Sekarang
      </button>
    </form>

    <!-- Tombol Kembali -->
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

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

// Aksi ketika submit form
const handleSubmit = async () => {
  if (!form.nama || !form.wa || !form.profesi || !form.alamat) {
    alert("Silakan isi semua data yang wajib.");
    return;
  }

  try {
    await fetch("http://localhost:8000/api/daftar-reseller", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        nama: form.nama,
        wa: form.wa,
        profesi: form.profesi,
        alamat: form.alamat,
        punyaRekening: punyaRekening.value,
        bank: punyaRekening.value === "ya" ? form.bank : "",
        norek: punyaRekening.value === "ya" ? form.norek : "",
        atasNama: punyaRekening.value === "ya" ? form.atasNama : "",
      }),
    });
    // Redirect ke grup WA
    window.location.href = "https://chat.whatsapp.com/GRUP_LINK";
  } catch (e) {
    alert("Gagal mengirim data. Coba lagi.");
  }
};

// Fungsi tombol kembali
const goBack = () => {
  router.back();
};
</script>
