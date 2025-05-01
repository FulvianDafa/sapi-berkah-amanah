<template>
  <aside class="bg-gray-800 text-white h-full">
    <!-- Logo/Brand -->
    <div class="p-6">
      <h2 class="text-xl font-bold">Sapi Berkah Amanah</h2>
    </div>

    <!-- Navigation -->
    <nav class="mt-6">
      <router-link
        to="/dashboard"
        class="block px-6 py-3 hover:bg-gray-700"
        :class="{ 'bg-gray-700': $route.path === '/dashboard' }"
      >
        Dashboard
      </router-link>

      <router-link
        to="/dashboard/hewan"
        class="block px-6 py-3 hover:bg-gray-700"
        :class="{ 'bg-gray-700': $route.path.includes('/dashboard/hewan') }"
      >
        Hewan Kurban
      </router-link>

      <!-- Tambahkan menu lain di sini -->
    </nav>

    <!-- Footer Sidebar -->
    <div class="absolute bottom-0 w-full p-6">
      <p class="text-sm text-gray-400">© 2024 Admin Panel</p>
    </div>
  </aside>
</template>

<script>
export default {
  name: "DashboardSidebar",
};
</script>
