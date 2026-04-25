@extends('layouts.admin')

@section('title', isset($hewanKurban) ? 'Edit Hewan Kurban' : 'Tambah Hewan Kurban')

@section('content')
<div class="space-y-5">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-lg font-semibold text-gray-900">
            {{ isset($hewanKurban) ? 'Edit Hewan Kurban' : 'Tambah Hewan Kurban' }}
        </h1>
        <a href="{{ route('admin.hewan-kurban.index') }}" class="btn-secondary text-xs">
            <i class="fas fa-arrow-left mr-1.5 text-[11px]"></i> Kembali
        </a>
    </div>

    <form action="{{ isset($hewanKurban) ? route('admin.hewan-kurban.update', $hewanKurban->id) : route('admin.hewan-kurban.store') }}"
          method="POST" enctype="multipart/form-data" id="hewanKurbanForm" novalidate>
        @csrf
        @if(isset($hewanKurban)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Left: Info -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border border-gray-100">
                    <div class="px-5 py-3 border-b border-gray-50">
                        <h3 class="text-sm font-medium text-gray-700">Informasi Utama</h3>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Jenis -->
                            <div>
                                <label for="jenis_hewan" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Jenis Hewan</label>
                                <select name="jenis_hewan" id="jenis_hewan" required onchange="toggleOptionalLabels()"
                                        class="w-full rounded-md border-gray-200 text-sm py-2 px-3 focus:border-green-600 focus:ring-green-600/30">
                                    <option value="sapi" {{ old('jenis_hewan', $hewanKurban->jenis_hewan ?? 'sapi') == 'sapi' ? 'selected' : '' }}>Sapi</option>
                                    <option value="kambing" {{ old('jenis_hewan', $hewanKurban->jenis_hewan ?? '') == 'kambing' ? 'selected' : '' }}>Kambing</option>
                                    <option value="domba" {{ old('jenis_hewan', $hewanKurban->jenis_hewan ?? '') == 'domba' ? 'selected' : '' }}>Domba</option>
                                </select>
                                @error('jenis_hewan') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Nama -->
                            <div>
                                <label for="nama" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Nama / Julukan</label>
                                <input type="text" name="nama" id="nama" required
                                       value="{{ old('nama', $hewanKurban->nama ?? '') }}"
                                       placeholder="Contoh: Si Gagah"
                                       class="w-full rounded-md border-gray-200 text-sm py-2 px-3 focus:border-green-600 focus:ring-green-600/30">
                                @error('nama') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Umur -->
                            <div>
                                <label for="umur" id="label_umur" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                                    Umur <span class="opt_text hidden normal-case text-gray-400 tracking-normal">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="umur" id="umur" step="0.1"
                                           value="{{ old('umur', $hewanKurban->umur ?? '') }}" placeholder="0"
                                           class="w-full rounded-md border-gray-200 text-sm py-2 px-3 pr-14 focus:border-green-600 focus:ring-green-600/30">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Tahun</span>
                                </div>
                                @error('umur') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Berat -->
                            <div>
                                <label for="berat" id="label_berat" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                                    Berat <span class="opt_text hidden normal-case text-gray-400 tracking-normal">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="berat" id="berat"
                                           value="{{ old('berat', $hewanKurban->berat ?? '') }}" placeholder="0"
                                           class="w-full rounded-md border-gray-200 text-sm py-2 px-3 pr-10 focus:border-green-600 focus:ring-green-600/30">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Kg</span>
                                </div>
                                @error('berat') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Harga -->
                            <div class="md:col-span-2">
                                <label for="harga_display" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Harga</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">Rp</span>
                                    <input type="text" id="harga_display" required
                                           value="{{ old('harga', isset($hewanKurban) ? number_format($hewanKurban->harga, 0, ',', '.') : '') }}"
                                           placeholder="0"
                                           class="w-full rounded-md border-gray-200 text-sm py-2 pl-10 pr-3 focus:border-green-600 focus:ring-green-600/30">
                                    <input type="hidden" name="harga" id="harga"
                                           value="{{ old('harga', $hewanKurban->harga ?? '') }}">
                                </div>
                                @error('harga') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="md:col-span-2">
                                <label for="deskripsi" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="3"
                                          placeholder="Tuliskan deskripsi hewan..."
                                          class="w-full rounded-md border-gray-200 text-sm py-2 px-3 focus:border-green-600 focus:ring-green-600/30 resize-y">{{ old('deskripsi', $hewanKurban->deskripsi ?? '') }}</textarea>
                                @error('deskripsi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Media -->
            <div class="space-y-5">
                <!-- Foto -->
                <div class="bg-white rounded-lg border border-gray-100">
                    <div class="px-5 py-3 border-b border-gray-50">
                        <h3 class="text-sm font-medium text-gray-700">Foto Hewan</h3>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-center py-6 border border-dashed border-gray-200 rounded-lg
                                    hover:border-green-400 hover:bg-green-50/20 transition-all cursor-pointer group">
                            <div class="text-center space-y-1">
                                <i class="fas fa-cloud-upload-alt text-gray-300 text-lg group-hover:text-green-500 transition-colors"></i>
                                <div class="text-xs text-gray-400">
                                    <label for="photos" class="cursor-pointer font-medium text-green-600 hover:text-green-700">Upload foto</label>
                                    <input id="photos" name="photos[]" type="file" class="sr-only" multiple accept="image/*" onchange="handleImageUpload(event)">
                                    <span> atau drag & drop</span>
                                </div>
                                <p class="text-[10px] text-gray-400">PNG, JPG · Max 5MB</p>
                            </div>
                        </div>

                        <div id="imagePreviewContainer" class="grid grid-cols-2 gap-2">
                            @if(isset($hewanKurban) && $hewanKurban->photos->count() > 0)
                                @foreach($hewanKurban->photos as $photo)
                                    <div class="relative group rounded-md overflow-hidden" data-photo-id="{{ $photo->id }}">
                                        <img src="{{ $photo->url }}" class="h-28 w-full object-cover">
                                        <button type="button" onclick="deletePhoto({{ $photo->id }}, this)"
                                                class="absolute top-1 right-1 w-6 h-6 rounded bg-black/50 text-white flex items-center justify-center
                                                       opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500">
                                            <i class="fas fa-times text-[9px]"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="photoError" class="hidden text-xs text-red-500 p-2 rounded bg-red-50">
                            <i class="fas fa-exclamation-triangle text-[10px] mr-1"></i> Minimal 1 foto
                        </div>
                    </div>
                </div>

                <!-- Video -->
                <div class="bg-white rounded-lg border border-gray-100">
                    <div class="px-5 py-3 border-b border-gray-50">
                        <h3 class="text-sm font-medium text-gray-700">Video <span class="text-gray-400 font-normal">(Opsional)</span></h3>
                    </div>
                    <div class="p-5 space-y-3">
                        <input type="file" name="video" accept="video/mp4,video/mov"
                               class="block w-full text-xs text-gray-500
                                      file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0
                                      file:text-xs file:font-medium file:bg-gray-50 file:text-gray-700
                                      hover:file:bg-gray-100 cursor-pointer">
                        @error('video') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        @if(isset($hewanKurban) && $hewanKurban->video_url)
                            <video controls class="w-full rounded-md border border-gray-100">
                                <source src="{{ $hewanKurban->video_url }}" type="video/mp4">
                            </video>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-2 pt-4 border-t border-gray-100 mt-5">
            <a href="{{ route('admin.hewan-kurban.index') }}" class="btn-secondary text-xs">Batal</a>
            <button type="submit" class="btn-primary text-xs">
                <i class="fas fa-save mr-1.5 text-[11px]"></i> {{ isset($hewanKurban) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Toggle optional labels
function toggleOptionalLabels() {
    const jenis = document.getElementById('jenis_hewan').value;
    const isNonSapi = jenis === 'kambing' || jenis === 'domba';
    document.querySelectorAll('.opt_text').forEach(el => {
        if (isNonSapi) el.classList.remove('hidden');
        else el.classList.add('hidden');
    });
    document.getElementById('umur').required = !isNonSapi;
    document.getElementById('berat').required = !isNonSapi;
}
document.addEventListener('DOMContentLoaded', function() { toggleOptionalLabels(); });

const Toast = Swal.mixin({
    toast: true, position: 'top-end', showConfirmButton: false,
    timer: 3000, timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

function showNotification(type, message) { Toast.fire({ icon: type, title: message }); }

function showLoading(message = 'Menyimpan data...') {
    Swal.fire({
        html: `
            <div class="flex flex-col items-center gap-3 py-2">
                <div class="w-10 h-10 border-4 border-gray-100 border-t-green-600 rounded-full animate-spin"></div>
                <span class="text-sm font-medium text-gray-700">${message}</span>
            </div>
        `,
        allowOutsideClick: false,
        showConfirmButton: false,
        width: 'auto',
        background: '#ffffff',
        backdrop: 'rgba(255, 255, 255, 0.6)',
        customClass: { popup: 'rounded-2xl shadow-sm border border-gray-100' }
    });
}

function hideLoading() { Swal.close(); }

let uploadedFiles = new Map();

function handleImageUpload(event) {
    const files = Array.from(event.target.files);
    const container = document.getElementById('imagePreviewContainer');
    const errorDiv = document.getElementById('photoError');
    const fileInput = document.getElementById('photos');
    const dataTransfer = new DataTransfer();

    if (uploadedFiles.size > 0) {
        uploadedFiles.forEach((previewElement, file) => {
            if (previewElement && previewElement.parentNode) dataTransfer.items.add(file);
        });
    }

    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative group rounded-md overflow-hidden';
            const uniqueId = 'preview-' + Date.now() + Math.random().toString(36).substr(2, 9);
            div.setAttribute('data-preview-id', uniqueId);
            div.innerHTML = `
                <img src="${e.target.result}" class="h-28 w-full object-cover">
                <button type="button" onclick="removeUploadedPhoto('${uniqueId}')"
                        class="absolute top-1 right-1 w-6 h-6 rounded bg-black/50 text-white flex items-center justify-center
                               opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500">
                    <i class="fas fa-times text-[9px]"></i>
                </button>
            `;
            container.appendChild(div);
            uploadedFiles.set(file, div);
            dataTransfer.items.add(file);
        }
        reader.readAsDataURL(file);
    });

    fileInput.files = dataTransfer.files;
    errorDiv.classList.add('hidden');
}

function removeUploadedPhoto(previewId) {
    const photoDiv = document.querySelector(`[data-preview-id="${previewId}"]`);
    if (!photoDiv) return;
    for (let [file, element] of uploadedFiles.entries()) {
        if (element === photoDiv) { uploadedFiles.delete(file); break; }
    }
    photoDiv.remove();
    const fileInput = document.getElementById('photos');
    const dataTransfer = new DataTransfer();
    uploadedFiles.forEach((element, file) => {
        if (element && element.parentNode) dataTransfer.items.add(file);
    });
    fileInput.files = dataTransfer.files;
    if (document.querySelectorAll('#imagePreviewContainer .relative').length === 0) {
        document.getElementById('photoError').classList.remove('hidden');
    }
}

function deletePhoto(photoId, button) {
    Swal.fire({
        title: 'Hapus foto?', text: "Tidak dapat dikembalikan.", icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#15803d', cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus', cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading('Menghapus foto...');
            const controller = new AbortController();
            const timeout = setTimeout(() => { controller.abort(); hideLoading(); showNotification('error', 'Timeout'); }, 30000);
            const csrfToken = document.querySelector('input[name="_token"]').value;

            fetch(`/admin/hewan-kurban/photo/${photoId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                signal: controller.signal
            })
            .then(r => r.json())
            .then(data => {
                clearTimeout(timeout); hideLoading();
                if (data.success) {
                    const photoDiv = button.closest('.relative');
                    photoDiv.style.transition = 'opacity 0.3s'; photoDiv.style.opacity = '0';
                    setTimeout(() => {
                        photoDiv.remove();
                        if (document.querySelectorAll('#imagePreviewContainer .relative').length === 0) {
                            document.getElementById('photoError').classList.remove('hidden');
                        }
                    }, 300);
                    showNotification('success', 'Foto dihapus');
                } else { throw new Error(data.message || 'Gagal'); }
            })
            .catch(error => { clearTimeout(timeout); hideLoading(); showNotification('error', error.message || 'Terjadi kesalahan'); });
        }
    });
}

const form = document.getElementById('hewanKurbanForm');
const inputs = form.querySelectorAll('input:not([type="hidden"]), select, textarea');

function setInvalid(input, msg) {
    input.classList.add('border-red-300', 'focus:border-red-400', 'focus:ring-red-400/20');
    input.classList.remove('border-gray-200', 'focus:border-green-600', 'focus:ring-green-600/30', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-500/30');
    
    let container = input.parentElement.classList.contains('relative') ? input.parentElement.parentElement : input.parentElement;
    let errorEl = container.querySelector('.js-error');
    
    if (!errorEl) {
        errorEl = document.createElement('p');
        errorEl.className = 'mt-1 text-xs text-red-500 js-error';
        container.appendChild(errorEl);
    }
    errorEl.textContent = msg;
}

function setValid(input) {
    input.classList.remove('border-red-300', 'focus:border-red-400', 'focus:ring-red-400/20', 'border-red-500', 'focus:border-red-500', 'focus:ring-red-500/30');
    input.classList.add('border-gray-200', 'focus:border-green-600', 'focus:ring-green-600/30');
    
    let container = input.parentElement.classList.contains('relative') ? input.parentElement.parentElement : input.parentElement;
    let errorEl = container.querySelector('.js-error');
    if (errorEl) errorEl.remove();
}

function validateInput(input) {
    if (input.type === 'file') return true; // File handled separately
    
    // Custom validation for harga_display
    if (input.id === 'harga_display') {
        const val = parseInt(input.value.replace(/\D/g, ''));
        if (isNaN(val) || val <= 0) {
            setInvalid(input, 'Harga harus lebih dari 0');
            return false;
        }
        setValid(input);
        return true;
    }

    if (!input.checkValidity()) {
        let msg = 'Harap isi bidang ini';
        if (input.validity.typeMismatch || input.validity.badInput) msg = 'Format tidak sesuai';
        else if (input.validity.rangeUnderflow) msg = 'Nilai terlalu kecil';
        
        setInvalid(input, msg);
        return false;
    }
    setValid(input);
    return true;
}

inputs.forEach(input => {
    input.addEventListener('blur', () => validateInput(input));
    input.addEventListener('input', () => {
        if (input.classList.contains('border-red-300') || input.classList.contains('border-red-500')) validateInput(input);
    });
});

form.addEventListener('submit', async function(e) {
    e.preventDefault();
    const photoContainer = document.getElementById('imagePreviewContainer');
    const errorDiv = document.getElementById('photoError');
    
    // Reset previous errors
    document.querySelectorAll('.ajax-error').forEach(el => el.remove());
    
    let isFormValid = true;
    inputs.forEach(input => {
        if (!validateInput(input)) isFormValid = false;
    });

    const isEdit = this.action.includes('hewan-kurban/');
    
    if (photoContainer.querySelectorAll('.relative').length === 0 && !isEdit) {
        errorDiv.classList.remove('hidden');
        isFormValid = false;
    }
    
    if (!isFormValid) {
        const firstError = form.querySelector('.border-red-300') || form.querySelector('.border-red-500') || errorDiv;
        if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        showNotification('error', 'Silakan periksa kembali isian form');
        return;
    }
    
    const hargaValue = hargaInput.value;
    if (hargaValue) hargaInput.value = hargaValue.replace(/\D/g, '');
    
    showLoading('Menyimpan...');
    
    try {
        const formData = new FormData(this);
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        hideLoading();
        
        if (response.ok) {
            localStorage.setItem('toast_success', 'Data hewan kurban berhasil disimpan');
            window.location.href = "{{ route('admin.hewan-kurban.index') }}";
        } else if (response.status === 422) {
            const data = await response.json();
            const errors = data.errors;
            let firstError = null;
            
            for (let key in errors) {
                let fieldId = key;
                if (key.includes('.')) fieldId = key.split('.')[0];
                
                const input = document.getElementById(fieldId) || document.querySelector(`[name="${fieldId}"]`);
                if (input && input.parentElement) {
                    const errorP = document.createElement('p');
                    errorP.className = 'mt-1 text-xs text-red-500 ajax-error';
                    errorP.textContent = errors[key][0];
                    
                    if (input.parentElement.classList.contains('relative')) {
                        input.parentElement.parentElement.appendChild(errorP);
                    } else {
                        input.parentElement.appendChild(errorP);
                    }
                    
                    if (!firstError) firstError = input;
                }
            }
            
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            showNotification('error', 'Silakan periksa kembali isian form');
            
            if (hargaValue) hargaDisplay.value = parseInt(hargaValue.replace(/\D/g, '')).toLocaleString('id-ID');
            
        } else {
            const data = await response.json();
            showNotification('error', data.message || 'Terjadi kesalahan pada server');
            if (hargaValue) hargaDisplay.value = parseInt(hargaValue.replace(/\D/g, '')).toLocaleString('id-ID');
        }
    } catch (err) {
        hideLoading();
        showNotification('error', 'Terjadi kesalahan koneksi');
        if (hargaValue) hargaDisplay.value = parseInt(hargaValue.replace(/\D/g, '')).toLocaleString('id-ID');
    }
});

const hargaDisplay = document.getElementById('harga_display');
const hargaInput = document.getElementById('harga');

hargaDisplay.addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    hargaInput.value = value;
    if (value.length > 0) this.value = parseInt(value).toLocaleString('id-ID');
});

window.addEventListener('load', function() {
    if (hargaDisplay.value) {
        const n = hargaDisplay.value.replace(/\D/g, '');
        if (n) { hargaDisplay.value = parseInt(n).toLocaleString('id-ID'); hargaInput.value = n; }
    }
});

const dropZone = document.querySelector('.border-dashed');
['dragenter','dragover','dragleave','drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); ev.stopPropagation(); }, false));
['dragenter','dragover'].forEach(e => dropZone.addEventListener(e, () => dropZone.classList.add('border-green-500','bg-green-50/30'), false));
['dragleave','drop'].forEach(e => dropZone.addEventListener(e, () => dropZone.classList.remove('border-green-500','bg-green-50/30'), false));
dropZone.addEventListener('drop', function(e) {
    const fileInput = document.getElementById('photos');
    const dataTransfer = new DataTransfer();
    if (fileInput.files.length > 0) Array.from(fileInput.files).forEach(f => dataTransfer.items.add(f));
    Array.from(e.dataTransfer.files).forEach(f => { if (f.type.startsWith('image/')) dataTransfer.items.add(f); });
    fileInput.files = dataTransfer.files;
    fileInput.dispatchEvent(new Event('change'));
}, false);
</script>
@endpush
