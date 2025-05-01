<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
      <h2 class="text-2xl font-bold text-center mb-8">Login Admin</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2"
            >Username</label
          >
          <input
            v-model="form.email"
            type="text"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
            required
          />
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2"
            >Password</label
          >
          <input
            v-model="form.password"
            type="password"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
            required
          />
        </div>
        <button
          type="submit"
          class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600"
        >
          Login
        </button>
        <p v-if="error" class="mt-4 text-red-500 text-center">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      error: null,
      loading: false,
    };
  },
  methods: {
    async handleLogin() {
      try {
        this.loading = true;
        this.error = null;

        const response = await fetch("http://localhost:8000/api/admin/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(this.form),
        });

        const data = await response.json();

        if (response.ok) {
          // Simpan token dan data user
          localStorage.setItem("admin_token", data.token);
          localStorage.setItem("admin_user", JSON.stringify(data.user));

          // Redirect ke dashboard
          this.$router.push("/dashboard");
        } else {
          this.error = data.message || "Login gagal";
        }
      } catch (err) {
        this.error = "Terjadi kesalahan sistem";
        console.error(err);
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
