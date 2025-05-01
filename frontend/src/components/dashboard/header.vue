<template>
  <header class="bg-white shadow">
    <div class="px-6 py-4 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>

      <!-- Profile & Logout -->
      <div class="flex items-center">
        <span class="mr-4 text-gray-600">
          {{ userEmail }}
        </span>
        <button
          @click="handleLogout"
          class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
        >
          Logout
        </button>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: "DashboardHeader",
  computed: {
    userEmail() {
      const user = JSON.parse(localStorage.getItem("admin_user") || "{}");
      return user.email || "Admin";
    },
  },
  methods: {
    handleLogout() {
      // Hapus token dan user data
      localStorage.removeItem("admin_token");
      localStorage.removeItem("admin_user");
      // Redirect ke halaman utama
      this.$router.push("/");
    },
  },
};
</script>
