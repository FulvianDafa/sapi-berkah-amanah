@extends('layouts.admin')

@section('title', isset($hewanKurban) ? 'Edit Hewan Kurban' : 'Tambah Hewan Kurban')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            {{ isset($hewanKurban) ? 'Edit Hewan Kurban' : 'Tambah Hewan Kurban' }}
        </h1>
        <a href="{{ route('admin.hewan-kurban.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <form action="{{ isset($hewanKurban) ? route('admin.hewan-kurban.update', $hewanKurban->id) : route('admin.hewan-kurban.store') }}" 
          method="POST" 
          enctype="multipart/form-data"
          id="hewanKurbanForm"
          class="space-y-6">
        @csrf
        @if(isset($hewanKurban))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri - Informasi Utama -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Utama</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Jenis Sapi -->
                            <div class="col-span-2">
                                <label for="jenis_sapi" class="block text-sm font-medium text-gray-700 mb-2">Jenis Sapi</label>
                                <input type="text" 
                                       name="jenis_sapi" 
                                       id="jenis_sapi" 
                                       value="{{ old('jenis_sapi', $hewanKurban->jenis_sapi ?? '') }}"
                                       class="block w-full rounded-lg border-gray-300 py-3 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                                @error('jenis_sapi')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Umur -->
                            <div>
                                <label for="umur" class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <input type="number" 
                                           name="umur" 
                                           id="umur" 
                                           value="{{ old('umur', $hewanKurban->umur ?? '') }}"
                                           class="block w-full rounded-lg border-gray-300 py-3 px-4 pr-12 focus:border-indigo-500 focus:ring-indigo-500"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                        <span class="text-gray-500 sm:text-sm">Tahun</span>
                                    </div>
                                </div>
                                @error('umur')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Berat -->
                            <div>
                                <label for="berat" class="block text-sm font-medium text-gray-700 mb-2">Berat</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <input type="number" 
                                           name="berat" 
                                           id="berat" 
                                           value="{{ old('berat', $hewanKurban->berat ?? '') }}"
                                           class="block w-full rounded-lg border-gray-300 py-3 px-4 pr-12 focus:border-indigo-500 focus:ring-indigo-500"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                        <span class="text-gray-500 sm:text-sm">Kg</span>
                                    </div>
                                </div>
                                @error('berat')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga -->
                            <div class="col-span-2">
                                <label for="harga_display" class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="text" 
                                           id="harga_display" 
                                           value="{{ old('harga', isset($hewanKurban) ? number_format($hewanKurban->harga, 0, ',', '.') : '') }}"
                                           class="block w-full rounded-lg border-gray-300 py-3 pl-12 focus:border-indigo-500 focus:ring-indigo-500"
                                           required>
                                    <input type="hidden" 
                                           name="harga" 
                                           id="harga" 
                                           value="{{ old('harga', $hewanKurban->harga ?? '') }}">
                                </div>
                                @error('harga')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-span-2">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                <textarea name="deskripsi" 
                                          id="deskripsi" 
                                          rows="5"
                                          class="block w-full rounded-lg border-gray-300 py-3 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $hewanKurban->deskripsi ?? '') }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan - Media -->
            <div class="space-y-6">
                <!-- Foto Section -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Hewan</h3>
                        <div class="space-y-4">
                            <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                <div class="space-y-2 text-center">
                                    <i class="fas fa-image text-gray-400 text-3xl mb-3"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="photos" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload foto</span>
                                            <input id="photos" 
                                                   name="photos[]" 
                                                   type="file" 
                                                   class="sr-only" 
                                                   multiple 
                                                   accept="image/*" 
                                                   onchange="handleImageUpload(event)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 5MB</p>
                                </div>
                            </div>

                            <div id="imagePreviewContainer" class="grid grid-cols-2 gap-4">
                                @if(isset($hewanKurban) && $hewanKurban->photos->count() > 0)
                                    @foreach($hewanKurban->photos as $photo)
                                        <div class="relative group" data-photo-id="{{ $photo->id }}">
                                            <img src="{{ $photo->url }}" class="h-40 w-full object-cover rounded-lg">
                                            <button type="button" 
                                                    onclick="deletePhoto({{ $photo->id }}, this)"
                                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div id="photoError" class="hidden mt-2 text-sm text-red-600">
                                Silakan pilih minimal 1 foto
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Section -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Video (Opsional)</h3>
                        <div class="space-y-4">
                            <input type="file" 
                                   name="video" 
                                   accept="video/mp4,video/mov"
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-3 file:px-4
                                          file:rounded-lg file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-50 file:text-indigo-700
                                          hover:file:bg-indigo-100">
                            @error('video')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if(isset($hewanKurban) && $hewanKurban->video_url)
                                <div class="mt-2">
                                    <video controls class="w-full rounded-lg">
                                        <source src="{{ $hewanKurban->video_url }}" type="video/mp4">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="flex justify-end space-x-3 border-t pt-6">
            <a href="{{ route('admin.hewan-kurban.index') }}" 
               class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-times mr-2"></i>
                Batal
            </a>
            <button type="submit" 
                    class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-save mr-2"></i>
                {{ isset($hewanKurban) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Ganti Toast menjadi Swal.fire untuk notifikasi
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// Kemudian gunakan Toast untuk notifikasi
function showNotification(type, message) {
    Toast.fire({
        icon: type,
        title: message
    });
}

function showLoading(message = 'Sedang memproses...') {
    Swal.fire({
        title: message,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
        customClass: {
            popup: 'flex flex-col items-center justify-center',
            title: 'text-center'
        }
    });

    setTimeout(() => {
        if (Swal.isVisible()) {
            hideLoading();
            showNotification('error', 'Waktu proses terlalu lama, silakan coba lagi');
        }
    }, 20000);
}

function hideLoading() {
    Swal.close();
}

// Modifikasi sistem tracking file
let uploadedFiles = new Map(); // Menggunakan Map untuk menyimpan file dan preview elements

function handleImageUpload(event) {
    const files = Array.from(event.target.files);
    const container = document.getElementById('imagePreviewContainer');
    const errorDiv = document.getElementById('photoError');
    const fileInput = document.getElementById('photos');
    
    // Create new DataTransfer object
    const dataTransfer = new DataTransfer();
    
    // Add existing files that haven't been deleted
    if (uploadedFiles.size > 0) {
        uploadedFiles.forEach((previewElement, file) => {
            if (previewElement && previewElement.parentNode) { // If preview still exists in DOM
                dataTransfer.items.add(file);
            }
        });
    }
    
    // Add new files
    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative group';
            const uniqueId = 'preview-' + Date.now() + Math.random().toString(36).substr(2, 9);
            div.setAttribute('data-preview-id', uniqueId);
            div.innerHTML = `
                <img src="${e.target.result}" class="h-40 w-full object-cover rounded-lg">
                <button type="button" 
                        onclick="removeUploadedPhoto('${uniqueId}')"
                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
            container.appendChild(div);
            uploadedFiles.set(file, div);
            dataTransfer.items.add(file);
        }
        reader.readAsDataURL(file);
    });
    
    // Update file input
    fileInput.files = dataTransfer.files;
    errorDiv.classList.add('hidden');
}

function removeUploadedPhoto(previewId) {
    const photoDiv = document.querySelector(`[data-preview-id="${previewId}"]`);
    if (!photoDiv) return;

    // Find and remove the file from uploadedFiles
    for (let [file, element] of uploadedFiles.entries()) {
        if (element === photoDiv) {
            uploadedFiles.delete(file);
            break;
        }
    }

    // Remove the preview
    photoDiv.remove();

    // Update file input
    const fileInput = document.getElementById('photos');
    const dataTransfer = new DataTransfer();
    
    uploadedFiles.forEach((element, file) => {
        if (element && element.parentNode) { // If preview still exists in DOM
            dataTransfer.items.add(file);
        }
    });
    
    fileInput.files = dataTransfer.files;

    // Show error if no photos remain
    if (document.querySelectorAll('#imagePreviewContainer .relative').length === 0) {
        document.getElementById('photoError').classList.remove('hidden');
    }
}

function deletePhoto(photoId, button) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Foto yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading('Menghapus foto...');
            
            const controller = new AbortController();
            const timeout = setTimeout(() => {
                controller.abort();
                hideLoading();
                showNotification('error', 'Waktu proses terlalu lama, silakan coba lagi');
            }, 30000);

            // Ambil CSRF token dari form yang sudah ada
            const csrfToken = document.querySelector('input[name="_token"]').value;

            // Gunakan URL yang sesuai dengan route yang didefinisikan
            fetch(`/admin/hewan-kurban/photo/${photoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                signal: controller.signal
            })
            .then(response => response.json())
            .then(data => {
                clearTimeout(timeout);
                hideLoading();
                
                if (data.success) {
                    const photoDiv = button.closest('.relative');
                    photoDiv.style.transition = 'opacity 0.3s ease';
                    photoDiv.style.opacity = '0';
                    
                    setTimeout(() => {
                        photoDiv.remove();
                        // Check remaining photos
                        if (document.querySelectorAll('#imagePreviewContainer .relative').length === 0) {
                            document.getElementById('photoError').classList.remove('hidden');
                        }
                    }, 300);

                    showNotification('success', 'Foto berhasil dihapus');
                } else {
                    throw new Error(data.message || 'Gagal menghapus foto');
                }
            })
            .catch(error => {
                clearTimeout(timeout);
                hideLoading();
                
                showNotification('error', error.message || 'Terjadi kesalahan saat menghapus foto');
            });
        }
    });
}

// Form validation dengan notifikasi
document.getElementById('hewanKurbanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const photoContainer = document.getElementById('imagePreviewContainer');
    const errorDiv = document.getElementById('photoError');
    const hasExistingPhotos = photoContainer.querySelectorAll('.relative').length > 0;
    
    if (!hasExistingPhotos) {
        errorDiv.classList.remove('hidden');
        window.scrollTo({
            top: errorDiv.offsetTop - 100,
            behavior: 'smooth'
        });
        showNotification('error', 'Silakan pilih minimal 1 foto');
        return;
    }

    // Pastikan nilai harga yang dikirim adalah angka tanpa format
    const hargaValue = hargaInput.value;
    if (hargaValue) {
        hargaInput.value = hargaValue.replace(/\D/g, '');
    }

    showLoading('Menyimpan data...');
    
    // Set timeout untuk form submission
    const submitTimeout = setTimeout(() => {
        hideLoading();
        showNotification('error', 'Waktu proses terlalu lama, silakan coba lagi');
    }, 30000); // 30 detik timeout

    // Store the timeout ID in the form element
    this.dataset.submitTimeout = submitTimeout;
    this.submit();
});

// Cleanup timeout after form submission (add this to your layout or main script)
window.addEventListener('unload', function() {
    const form = document.getElementById('hewanKurbanForm');
    if (form && form.dataset.submitTimeout) {
        clearTimeout(form.dataset.submitTimeout);
    }
});

// Format currency (kode yang sudah ada)
const hargaDisplay = document.getElementById('harga_display');
const hargaInput = document.getElementById('harga');

hargaDisplay.addEventListener('input', function(e) {
    let value = this.value.replace(/\D/g, '');
    hargaInput.value = value;
    
    if (value.length > 0) {
        value = parseInt(value).toLocaleString('id-ID');
        this.value = value;
    }
});

// Initialize currency format
window.addEventListener('load', function() {
    if (hargaDisplay.value) {
        const numericValue = hargaDisplay.value.replace(/\D/g, '');
        if (numericValue) {
            hargaDisplay.value = parseInt(numericValue).toLocaleString('id-ID');
            hargaInput.value = numericValue;
        }
    }
});

// Drag and drop functionality
const dropZone = document.querySelector('.border-dashed');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropZone.classList.add('border-indigo-500');
}

function unhighlight(e) {
    dropZone.classList.remove('border-indigo-500');
}

dropZone.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    const fileInput = document.getElementById('photos');
    const dataTransfer = new DataTransfer();
    
    // Add existing files from input
    if (fileInput.files.length > 0) {
        Array.from(fileInput.files).forEach(file => {
            dataTransfer.items.add(file);
        });
    }
    
    // Add new dropped files
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            dataTransfer.items.add(file);
        }
    });
    
    fileInput.files = dataTransfer.files;
    
    // Trigger change event to update preview
    const event = new Event('change');
    fileInput.dispatchEvent(event);
}
</script>
@endpush

@push('styles')
<style>
    /* Custom SweetAlert2 styling */
    .swal2-popup {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .swal2-title {
        text-align: center !important;
    }

    .swal2-loading {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        width: 100% !important;
    }
</style>
@endpush
