<template>
  <div>
    <h2 class="text-2xl font-bold mb-6">
      {{ isEdit ? "Edit Hewan Kurban" : "Tambah Hewan Kurban" }}
    </h2>

    <div class="bg-white rounded-lg shadow p-6">
      <form @submit.prevent="handleSubmit">
        <!-- Jenis Sapi -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">
            Jenis Sapi
          </label>
          <input
            v-model="form.jenis_sapi"
            type="text"
            placeholder="Contoh: Sapi Limosin"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
            required
          />
        </div>

        <!-- Umur dan Berat -->
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">
              Umur (tahun)
            </label>
            <input
              v-model="form.umur"
              type="number"
              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
              required
            />
          </div>
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">
              Berat (kg)
            </label>
            <input
              v-model="form.berat"
              type="number"
              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
              required
            />
          </div>
        </div>

        <!-- Harga -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">
            Harga (Rp)
          </label>
          <input
            v-model="form.harga"
            type="number"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
            required
          />
        </div>

        <!-- Deskripsi -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">
            Deskripsi
          </label>
          <textarea
            v-model="form.deskripsi"
            rows="4"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
          ></textarea>
        </div>

        <!-- Multiple Photos -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">
            Foto-foto Sapi
          </label>
          <input
            type="file"
            @change="handlePhotosChange"
            multiple
            accept="image/*"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
          />
          <!-- Preview Photos -->
          <div class="grid grid-cols-4 gap-4 mt-4">
            <div
              v-for="(preview, index) in photoPreviews"
              :key="index"
              class="relative"
            >
              <img :src="preview" class="w-full h-32 object-cover rounded" />
              <button
                @click="removePhoto(index)"
                type="button"
                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center"
              >
                ×
              </button>
            </div>
          </div>
        </div>

        <!-- Video -->
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2">
            Video (Opsional)
          </label>
          <input
            type="file"
            @change="handleVideoChange"
            accept="video/*"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
          />
          <!-- Video Preview -->
          <video
            v-if="videoPreview"
            :src="videoPreview"
            controls
            class="mt-4 max-w-full h-48"
          ></video>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-4">
          <router-link
            to="/dashboard/hewan-kurban"
            class="px-4 py-2 text-gray-600 hover:text-gray-800 border rounded"
          >
            Batal
          </router-link>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
            :disabled="loading"
          >
            {{ loading ? "Menyimpan..." : "Simpan" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
  data() {
    return {
      form: {
        jenis_sapi: "",
        umur: "",
        berat: "",
        harga: "",
        deskripsi: "",
      },
      selectedPhotos: [],
      photoPreviews: [],
      selectedVideo: null,
      videoPreview: null,
      loading: false,
      error: null,
    };
  },
  computed: {
    isEdit() {
      return this.$route.params.id !== undefined;
    },
  },
  methods: {
    showSuccessAlert() {
      Swal.fire({
        icon: "success",
        title: "Berhasil!",
        text: "Data hewan kurban berhasil disimpan",
        showConfirmButton: false,
        timer: 1500,
      });
    },

    showErrorAlert(message) {
      Swal.fire({
        icon: "error",
        title: "Gagal!",
        text: message || "Terjadi kesalahan saat menyimpan data",
        confirmButtonText: "Tutup",
        confirmButtonColor: "#EF4444",
      });
    },

    async handleSubmit() {
      try {
        this.loading = true;
        const formData = new FormData();

        // ... kode form data ...

        const response = await fetch(url, {
          method: this.isEdit ? "POST" : "POST",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
          },
          body: formData,
        });

        if (response.ok) {
          await this.showSuccessAlert();
          this.$router.push("/dashboard/hewan-kurban");
        } else {
          const data = await response.json();
          throw new Error(data.message || "Gagal menyimpan data");
        }
      } catch (err) {
        console.error(err);
        this.showErrorAlert(err.message);
      } finally {
        this.loading = false;
      }
    },
    handlePhotosChange(e) {
      const files = Array.from(e.target.files);
      files.forEach((file) => {
        this.selectedPhotos.push(file);
        const reader = new FileReader();
        reader.onload = (e) => this.photoPreviews.push(e.target.result);
        reader.readAsDataURL(file);
      });
    },
    removePhoto(index) {
      this.selectedPhotos.splice(index, 1);
      this.photoPreviews.splice(index, 1);
    },
    handleVideoChange(e) {
      const file = e.target.files[0];
      if (file) {
        this.selectedVideo = file;
        this.videoPreview = URL.createObjectURL(file);
      }
    },
    async fetchHewan() {
      if (!this.isEdit) return;

      try {
        const response = await fetch(
          `http://localhost:8000/api/admin/hewan-kurban/${this.$route.params.id}`
        );
        const data = await response.json();
        this.form = {
          jenis_sapi: data.jenis_sapi,
          umur: data.umur,
          berat: data.berat,
          harga: data.harga,
          deskripsi: data.deskripsi,
        };
        // Load existing photos
        if (data.photos) {
          this.photoPreviews = data.photos.map((p) => p.url);
        }
        // Load existing video
        if (data.video_url) {
          this.videoPreview = data.video_url;
        }
      } catch (err) {
        console.error(err);
        this.error = "Gagal mengambil data hewan";
      }
    },
    async handleSubmit() {
      try {
        this.loading = true;
        const formData = new FormData();

        // Append basic data
        Object.keys(this.form).forEach((key) => {
          formData.append(key, this.form[key]);
        });

        // Append photos
        this.selectedPhotos.forEach((photo, index) => {
          formData.append(`photos[${index}]`, photo);
        });

        // Append video if exists
        if (this.selectedVideo) {
          formData.append("video", this.selectedVideo);
        }

        const url = this.isEdit
          ? `http://localhost:8000/api/admin/hewan-kurban/${this.$route.params.id}`
          : "http://localhost:8000/api/admin/hewan-kurban";

        const response = await fetch(url, {
          method: this.isEdit ? "POST" : "POST", // Using POST for both due to FormData
          headers: {
            Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
          },
          body: formData,
        });

        if (response.ok) {
          this.$router.push("/dashboard/hewan-kurban");
        } else {
          throw new Error("Gagal menyimpan data");
        }
      } catch (err) {
        console.error(err);
        this.error = "Gagal menyimpan data";
      } finally {
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchHewan();
  },
  beforeUnmount() {
    // Clean up video preview URL
    if (this.videoPreview) {
      URL.revokeObjectURL(this.videoPreview);
    }
  },
};
</script>
