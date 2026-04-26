<template>
  <div class="min-h-screen flex flex-col bg-gray-100">
    <Navbar />
    <!-- Breadcrumb -->
<nav class="text-sm text-gray-500 py-2 px-6 bg-white" aria-label="Breadcrumb">
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
    <!-- <div class="flex justify-between">
      <!-- sidebar -->
      <!-- <div class="w-[300px] px-5 py-10 h-auto"> 
        <div class="bg-green-50 shadow p-5 rounded-lg flex flex-col gap-2 h-full">
            <div class="bg-green-600 text-white py-3 px-5 rounded-lg">
              Sapi
            </div>
            <div class="bg-green-200 text-black py-3 px-5 rounded-lg">
              Kambing
            </div>
            <div class="bg-green-200 text-black py-3 px-5 rounded-lg">
              Domba
            </div>
        </div>
      </div> --> 
      <div class="flex-1 ">
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

        <div v-else class="flex flex-row gap-0">
          <div class="hidden md:block w-[400px] px-5 py-4 h-auto "> 
            <div class="bg-white p-5 rounded-lg flex flex-col gap-2 h-full">
                <div class=" font-semibold group text-green-600 bg-gray-100 rounded-t-lg">
                  <div class="py-3 px-5 ">Sapi</div>
                  <div class="h-1 rounded-xl w-full duration-300 bg-green-600"></div>
                </div>
                <div class="text-black font-semibold group hover:text-green-600 hover:bg-gray-100 rounded-t-lg">
                  <div class="py-3 px-5 ">Kambing</div>
                  <div class="h-1 rounded-xl w-0 group-hover:w-full duration-300 bg-green-600"></div>
                </div>
                <div class="text-black font-semibold group hover:text-green-600 hover:bg-gray-100 rounded-t-lg">
                  <div class="py-3 px-5 ">Domba</div>
                  <div class="h-1 rounded-xl w-0 group-hover:w-full duration-300 bg-green-600"></div>
                </div>
            </div>
          </div>

          <div class="w-full p-0 md:py-4 md:pr-4 md:pl-0">
            <!-- Tab Kategori -->
            <div class="flex flex-col lg:flex-row justify-center md:justify-between mb-6 bg-white pt-2 md:px-4 pb-2 rounded-lg ">
              <div class="flex flex-row items-center justify-between md:justify-center lg:justify-between px-5 sm:px-20 md:px-0 my-3">
                <h1 class="text-lg line-height md:text-xl lg:text-3xl font-bold text-center">KATALOG SAPI</h1>
                <button 
                  @click="showModal = true" 
                  class="flex flex-row gap-2 text-md md:text-lg md:hidden bg-green-600 rounded-lg font-semibold py-2 px-3 md:py-2 md:px-4 text-white">
                  GANTI HEWAN 
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                  </svg>
                </button>
              </div>  
              <div class="flex flex-wrap justify-center space-x-6 sm:space-x-15 md:space-x-6 mt-2 md:mt-0">
                <button
                  v-for="cat in categories"
                  :key="cat"
                  @click="selectedCategory = cat"
                  :class="[
                    'text-sm sm:text-md md:text-lg font-semibold py-2 group flex flex-col justify-center items-center transition',
                    selectedCategory === cat ? 'text-green-600' : 'text-black hover:text-green-600'
                  ]"
                >
                  {{ cat }}

                  <div 
                    :class="[
                      'h-1 rounded-xl duration-300 bg-green-600 mt-2',
                      selectedCategory === cat ? 'w-full' : 'w-0 group-hover:w-full'
                    ]"
                  ></div>
                </button>
              </div>
            </div>

            <!-- Grid Item Sapi -->
            <div class="px-2 md:px-0 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-6 min-h-[300px]">
              <router-link
                v-for="item in paginatedItems"
                :key="item.id"
                :to="`/produk/${item.id}`"
                class="p-4 bg-white rounded-lg shadow hover:shadow-md transition"
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
                <h3 class="text-sm md:text-lg font-bold text-green-700">
                  {{ item.jenis_sapi}} SAPI AUSTRALIA
                </h3>
                <p class="text-md font-semibold text-green-600">
                  Rp {{ formatPrice(item.harga) }}
                </p>
                <p class="text-sm text-gray-600">{{ item.berat }} kg</p>

                <p class="text-sm text-gray-500 italic">{{ item.kategori }}</p>
                

                <!-- Tombol WhatsApp -->
                 <div class="mt-4 flex flex-col xl:flex-row gap-2 text-center">
                  <router-link
                    :to="`/produk/${item.id}`"
                    class="hidden md:inline-block bg-white border-3 border-green-600 text-green-600 text-sm px-4 py-3 rounded-lg hover:bg-green-600 hover:text-white duration-300 transition"
                    @click.stop
                  >
                    Detail
                  </router-link>
                  <a
                    :href="generateWhatsAppLink(item)"
                    target="_blank"
                    class="inline-block bg-green-600 border-3 border-green-600 text-white text-sm px-4 w-full py-1 md:py-3 rounded-lg hover:bg-green-700 hover:border-green-700 duration-300 transition"
                    @click.stop
                  >
                    Booking via WhatsApp
                  </a>
                 </div>
                
                
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
      </div>
    <!-- </div> -->
    <Footer />
  </div>
  <!-- Modal -->
<div 
  v-if="showModal"
  class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
>
  <div class="bg-white w-[90%] max-w-sm rounded-xl p-5">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-bold">Pilih Hewan</h2>
      <button @click="showModal = false" class="text-gray-500">✕</button>
    </div>

    <!-- List Hewan -->
    <div class="flex flex-col gap-2">
      <button
        @click="selectHewan('Sapi')"
        class="text-left group pt-2 rounded hover:bg-gray-100"
      >
        <div class="pt-1 pb-2 px-3 ">Sapi</div>
        <div class="h-1 rounded-xl w-0 group-hover:w-full duration-300 bg-green-600"></div>
      </button>
      <button
        @click="selectHewan('Kambing')"
        class="text-left group pt-2 rounded hover:bg-gray-100"
      >
        <div class="pt-1 pb-2 px-3 ">Kambing</div>
        <div class="h-1 rounded-xl w-0 group-hover:w-full duration-300 bg-green-600"></div>
      </button>
      <button
        @click="selectHewan('Domba')"
        class="text-left group pt-2 rounded hover:bg-gray-100"
      >
        <div class="pt-1 pb-2 px-3 ">Kambing</div>
        <div class="h-1 rounded-xl w-0 group-hover:w-full duration-300 bg-green-600"></div>
      </button>
    </div>

  </div>
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
const showModal = ref(false);
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
  return `https://wa.me/62811440944?text=${encodeURIComponent(text)}`;
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
