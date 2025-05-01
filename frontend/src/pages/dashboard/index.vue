<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <Sidebar class="w-64 shadow-lg" />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Header -->
      <Header class="shadow-sm" />

      <!-- Content Area -->
      <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
        <!-- Jika di route root dashboard, tampilkan dashboard home -->
        <template v-if="$route.path === '/dashboard'">
          <!-- Welcome Section -->
          <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-2xl font-bold mb-4">
              Selamat Datang di Dashboard Admin
            </h2>
            <p class="text-gray-600">
              Kelola data hewan kurban dengan mudah di sini.
            </p>
          </div>

          <!-- Quick Stats -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Statistik Hewan -->
            <div class="bg-white rounded-lg shadow p-6">
              <h3 class="text-lg font-semibold text-gray-700 mb-2">
                Total Hewan Kurban
              </h3>
              <p class="text-3xl font-bold text-blue-600">{{ totalHewan }}</p>
              <p class="text-gray-500 text-sm mt-1">
                Hewan tersedia di katalog
              </p>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
              <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Aksi Cepat
              </h3>
              <router-link
                to="/dashboard/hewan"
                class="block w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 text-center"
              >
                Kelola Hewan Kurban
              </router-link>
            </div>
          </div>
        </template>

        <!-- Router view untuk halaman lain -->
        <router-view v-else></router-view>
      </main>

      <!-- Footer -->
      <Footer />
    </div>
  </div>
</template>

<script>
import Sidebar from "../../components/dashboard/sidebar.vue";
import Header from "../../components/dashboard/header.vue";
import Footer from "../../components/dashboard/footer.vue";

export default {
  name: "DashboardLayout",
  components: {
    Sidebar,
    Header,
    Footer,
  },
  data() {
    return {
      totalHewan: 0,
    };
  },
  created() {
    this.checkAuth();
    this.fetchStats();
  },
  methods: {
    checkAuth() {
      const token = localStorage.getItem("admin_token");
      if (!token) {
        this.$router.push("/admin-login");
      }
    },
    async fetchStats() {
      try {
        const response = await fetch(
          "http://localhost:8000/api/admin/hewan-kurban",
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
            },
          }
        );
        const data = await response.json();
        this.totalHewan = data.length;
      } catch (error) {
        console.error("Error fetching stats:", error);
      }
    },
  },
  errorCaptured(err, vm, info) {
    console.error("Error in component:", err);
    return false;
  },
};
</script>
