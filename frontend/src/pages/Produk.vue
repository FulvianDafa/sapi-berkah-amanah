<template>
  <div class="min-h-screen flex flex-col bg-white">
    <Navbar />
    <!-- Breadcrumb -->
<nav class="text-sm text-gray-500 py-2 px-6 bg-gray-100" aria-label="Breadcrumb">
  <ol class="flex items-center space-x-1">
    <li>
      <router-link to="/" class="text-green-700 hover:underline">Home</router-link>
    </li>
    <li>
      <span class="text-gray-400">›</span>
    </li>
    <span class="text-gray-700 font-medium">Katalog</span>
  </ol>
</nav>

    <div class="flex-1 p-8">
      <h1 class="text-3xl font-bold text-center mb-8">Katalog Sapi</h1>

      <!-- Loading State -->
      <div v-if="loading" class="text-center py-8">
        <div
          class="animate-spin duration-900 rounded-full h-12 w-12 border-b-2 border-green-500 mx-auto"
        ></div>
        <p class="mt-4 text-gray-600">Memuat data...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-8 text-red-600">
        {{ error }}
      </div>

      <div v-else>
        <!-- Tab Kategori -->
        <div class="flex flex-wrap justify-center space-x-4 border-b pb-2 mb-6">
          <button
            v-for="cat in categories"
            :key="cat"
            @click="selectedCategory = cat"
            :class="[
              'text-lg font-semibold pb-2',
              selectedCategory === cat
                ? 'border-b-4 border-green-500 text-green-600'
                : 'text-gray-600',
            ]"
          >
            {{ cat }}
          </button>
        </div>

        <!-- Grid Item Sapi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 min-h-[300px]">
          <router-link
            v-for="item in paginatedItems"
            :key="item.id"
            :to="`/produk/${item.id}`"
            class="p-4 bg-green-50 rounded-lg shadow hover:shadow-md transition"
          >
            <img
              :src="
                item.photos && item.photos.length > 0
                  ? item.photos[0]
                  : '/assets/default-sapi.jpg'
              "
              alt="sapi"
              class="w-full h-40 object-cover rounded mb-4"
            />
            <h3 class="text-lg font-bold text-green-700">
              {{ item.jenis_sapi }}
            </h3>
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
              @click.stop
            >
              Booking via WhatsApp
            </a>
          </router-link>
          <!-- Placeholder jika kosong -->
          <template v-if="paginatedItems.length === 0">
            <div class="col-span-3 flex flex-col items-center justify-center min-h-[200px]">
              <span class="text-center text-gray-500">Kategori kosong</span>
            </div>
          </template>
        </div>

        <!-- Pagination -->
        <nav v-if="filteredItems.length > itemsPerPage" class="flex justify-center mt-8" aria-label="Page navigation example">
          <ul class="flex items-center -space-x-px h-8 text-sm">
            <li>
              <button
                @click="goToPage(currentPage - 1)"
                :disabled="currentPage === 1"
                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 disabled:opacity-50"
              >
                <span class="sr-only">Previous</span>
                <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
              </button>
            </li>
            <li v-for="page in totalPages" :key="page">
              <button
                @click="goToPage(page)"
                :aria-current="currentPage === page ? 'page' : undefined"
                :class="[
                  'flex items-center justify-center px-3 h-8 leading-tight border',
                  currentPage === page
                    ? 'z-10 text-blue-600 border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700'
                    : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700'
                ]"
              >{{ page }}</button>
            </li>
            <li>
              <button
                @click="goToPage(currentPage + 1)"
                :disabled="currentPage === totalPages"
                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 disabled:opacity-50"
              >
                <span class="sr-only">Next</span>
                <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
              </button>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import axios from "../services/axiosConfig";
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";

const loading = ref(false);
const error = ref(null);
const sapiItems = ref([]);

// Kategori statis
const categories = [
  "Semua",
  "Prime Class",
  "Bigboss Class",
  "Sultan Class"
];
const selectedCategory = ref("Semua");

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
  if (selectedCategory.value === "Semua") return sapiItems.value;
  const map = {
    "Prime Class": "prime",
    "Bigboss Class": "bigboss",
    "Sultan Class": "sultan"
  };
  return sapiItems.value.filter(
    (item) => item.kategori === map[selectedCategory.value]
  );
});

const itemsPerPage = 6;
const currentPage = ref(1);

const totalPages = computed(() => {
  return Math.ceil(filteredItems.value.length / itemsPerPage);
});

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredItems.value.slice(start, start + itemsPerPage);
});

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
    window.scrollTo({ top: 0, behavior: "smooth" });
  }
}

// Fetch data dari API
const fetchData = async () => {
  loading.value = true;
  error.value = null;

  try {
    const response = await axios.get("/hewan-kurban");
    sapiItems.value = response.data.data;

    // Extract unique categories
    const uniqueCategories = [
      ...new Set(sapiItems.value.map((item) => item.kategori)),
    ];
    categories.value = uniqueCategories;
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

// Reset currentPage when selectedCategory changes
watch(selectedCategory, () => {
  currentPage.value = 1;
});
</script>
