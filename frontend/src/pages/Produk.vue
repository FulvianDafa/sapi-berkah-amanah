<template>
  <div class="min-h-screen bg-white">
    <Navbar />

    <div class="p-8">
      <h1 class="text-3xl font-bold text-center mb-8">Katalog Sapi</h1>

      <!-- Loading State -->
      <div v-if="loading" class="text-center py-8">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-500 mx-auto"></div>
        <p class="mt-4 text-gray-600">Memuat data...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-8 text-red-600">
        {{ error }}
      </div>

      <!-- Data Loaded -->
      <div v-else>
        <!-- Tab Kategori -->
        <div class="flex flex-wrap justify-center space-x-4 border-b pb-2 mb-6">
          <button
            v-for="(cat, index) in categories"
            :key="index"
            @click="selectedCategory = cat"
            :class="[
              'text-lg font-semibold pb-2',
              selectedCategory === cat
                ? 'border-b-4 border-green-500 text-green-600'
                : 'text-gray-600'
            ]"
          >
            {{ cat }}
          </button>
        </div>

        <!-- Grid Item Sapi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          <div
            v-for="item in filteredItems"
            :key="item.id"
            class="p-4 bg-green-50 rounded-lg shadow hover:shadow-md transition"
          >
            <img
              :src="item.photos && item.photos.length > 0 ? item.photos[0] : '/assets/default-sapi.jpg'"
              alt="sapi"
              class="w-full h-40 object-cover rounded mb-4"
            />
            <h3 class="text-lg font-bold text-green-700">{{ item.jenis_sapi }}</h3>
            <p class="text-sm text-gray-600">{{ item.berat_sapi }} kg</p>
            <p class="text-sm text-gray-500 italic">{{ item.kategori }}</p>
            <p class="text-sm font-semibold text-green-600 mt-2">
              Rp {{ formatPrice(item.harga) }}
            </p>
            <!-- Tombol WhatsApp -->
            <a
              :href="generateWhatsAppLink(item)"
              target="_blank"
              class="mt-4 inline-block bg-green-600 text-white text-sm px-4 py-2 rounded-full hover:bg-green-700 transition"
            >
              Booking via WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>


<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";

const loading = ref(false);
const error = ref(null);
const sapiItems = ref([]);
const selectedCategory = ref(null);
const categories = ref([]);

// Format harga ke format Rupiah
const formatPrice = (price) => {
  return new Intl.NumberFormat("id-ID").format(price);
};

// Generate link WhatsApp
const generateWhatsAppLink = (item) => {
  const text = `Halo, saya tertarik untuk memesan sapi ${item.jenis_sapi} (${item.kategori}) dengan berat ${item.berat_sapi}kg. Apakah masih tersedia?`;
  return `https://wa.me/6282127590547?text=${encodeURIComponent(text)}`;
};

// Filter berdasarkan kategori aktif
const filteredItems = computed(() => {
  if (!selectedCategory.value) return sapiItems.value;
  return sapiItems.value.filter(
    (item) => item.kategori === selectedCategory.value
  );
});

// Fetch data dari API
const fetchData = async () => {
  loading.value = true;
  error.value = null;

  try {
    const response = await axios.get("http://localhost:8000/api/hewan-kurban");
    sapiItems.value = response.data.data;

    // Extract unique categories
    const uniqueCategories = [
      ...new Set(sapiItems.value.map((item) => item.kategori)),
    ];
    categories.value = uniqueCategories;

    // Set default selected category
    if (uniqueCategories.length > 0) {
      selectedCategory.value = uniqueCategories[0];
    }
  } catch (err) {
    error.value = "Gagal memuat data. Silakan coba lagi nanti.";
    console.error("Error fetching data:", err);
  } finally {
    loading.value = false;
  }
};

// Fetch data when component mounts
onMounted(() => {
  fetchData();
});
</script>
