<template>
  <div>
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold">Daftar Hewan Kurban</h2>
      <router-link
        to="/dashboard/hewan/tambah"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        + Tambah Hewan
      </router-link>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
            >
              Foto
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
            >
              Jenis Sapi
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
            >
              Umur
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
            >
              Berat (kg)
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
            >
              Harga
            </th>
            <th
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
            >
              Aksi
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <!-- Loading State -->
          <tr v-if="loading">
            <td colspan="6" class="px-6 py-8 text-center">
              <div class="flex items-center justify-center">
                <div
                  class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"
                ></div>
                <span class="ml-2 text-gray-500">Memuat data...</span>
              </div>
            </td>
          </tr>

          <!-- Empty State -->
          <tr v-else-if="!hewanList.length">
            <td colspan="6" class="px-6 py-8 text-center">
              <div class="text-gray-500 mb-4">Belum ada data hewan kurban</div>
              <router-link
                to="/dashboard/hewan/tambah"
                class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
              >
                Tambah Hewan Kurban
              </router-link>
            </td>
          </tr>

          <!-- Data Rows -->
          <tr v-else v-for="hewan in hewanList" :key="hewan.id">
            <td class="px-6 py-4 whitespace-nowrap">
              <img
                :src="getMainPhoto(hewan.photos)"
                class="w-16 h-16 object-cover rounded"
                alt="Foto Sapi"
              />
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{ hewan.jenis_sapi }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ hewan.umur }} tahun</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ hewan.berat }} kg</td>
            <td class="px-6 py-4 whitespace-nowrap">
              Rp {{ formatPrice(hewan.harga) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap space-x-2">
              <router-link
                :to="`/dashboard/hewan-kurban/${hewan.id}/edit`"
                class="text-blue-600 hover:text-blue-900"
              >
                Edit
              </router-link>
              <button
                @click="confirmDelete(hewan.id)"
                class="text-red-600 hover:text-red-900"
              >
                Hapus
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      hewanList: [],
      loading: false,
      error: null,
    };
  },
  methods: {
    async confirmDelete(id) {
      const result = await Swal.fire({
        title: "Yakin hapus data?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#EF4444",
        cancelButtonColor: "#6B7280",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
      });

      if (result.isConfirmed) {
        try {
          const response = await fetch(
            `http://localhost:8000/api/admin/hewan-kurban/${id}`,
            {
              method: "DELETE",
              headers: {
                Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
              },
            }
          );

          if (response.ok) {
            await Swal.fire({
              icon: "success",
              title: "Terhapus!",
              text: "Data berhasil dihapus",
              showConfirmButton: false,
              timer: 1500,
            });
            await this.fetchHewanList();
          } else {
            throw new Error("Gagal menghapus data");
          }
        } catch (err) {
          Swal.fire({
            icon: "error",
            title: "Gagal!",
            text: err.message,
            confirmButtonText: "Tutup",
            confirmButtonColor: "#EF4444",
          });
        }
      }
    },
    formatPrice(price) {
      return new Intl.NumberFormat("id-ID").format(price);
    },
    getMainPhoto(photos) {
      if (!photos || photos.length === 0) {
        return "/placeholder-sapi.jpg"; // Tambahkan default image
      }
      // Ambil foto dengan order = 0 atau foto pertama
      return photos.find((p) => p.order === 0)?.url || photos[0].url;
    },
    async fetchHewanList() {
      try {
        this.loading = true;
        const response = await axios.get(
          "http://localhost:8000/api/admin/hewan-kurban",
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
            },
          }
        );
        this.hewanList = response.data.data || [];
      } catch (error) {
        console.error("Error:", error);
        // Jangan tampilkan error jika data kosong
        if (error.response?.status !== 404) {
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: "Gagal mengambil data",
          });
        }
      } finally {
        this.loading = false;
      }
    },

    async confirmDelete(id) {
      const result = await Swal.fire({
        // ... kode konfirmasi ...
      });

      if (result.isConfirmed) {
        try {
          await axios.delete(`/admin/hewan-kurban/${id}`);
          await Swal.fire({
            icon: "success",
            title: "Terhapus!",
            text: "Data berhasil dihapus",
            showConfirmButton: false,
            timer: 1500,
          });
          await this.fetchHewanList();
        } catch (error) {
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: error.response?.data?.message || "Gagal menghapus data",
          });
        }
      }
    },
  },
  created() {
    this.fetchHewanList();
  },
};
</script>
