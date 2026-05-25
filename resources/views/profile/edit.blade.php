@extends('layouts.dashboard')

@section('title', 'Edit Profile')
@section('header', 'Edit Profile')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<style>
    .cropper-container {
        width: 100%;
        max-height: 400px;
    }
    .preview-container {
        overflow: hidden;
        width: 100%;
        max-width: 200px;
        aspect-ratio: 1/1;
        border-radius: 50%;
        margin: 0 auto;
    }
</style>
@endpush

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-2xl shadow relative">

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- FOTO -->
        <div class="text-center mb-6">
            <div class="relative inline-block">
                <img 
                    id="profile-preview"
                    src="{{ $user->profile_photo 
                        ? asset('storage/' . $user->profile_photo) 
                        : 'https://via.placeholder.com/100' }}"
                    class="w-32 h-32 rounded-full mx-auto mb-3 object-cover border-4 border-white dark:border-gray-700 shadow-sm"
                >
                <div class="absolute bottom-3 right-0 bg-green-600 rounded-full p-2 cursor-pointer hover:bg-green-700 transition shadow" onclick="document.getElementById('photo-input').click()">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Klik icon kamera untuk ganti foto</p>

            <!-- Hidden inputs for file and base64 string -->
            <input type="file" id="photo-input" class="hidden" accept="image/*">
            <input type="hidden" name="photo_base64" id="photo-base64">
        </div>

        <!-- NAME -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold dark:text-gray-200">Nama</label>
            <input type="text" name="name" value="{{ $user->name }}"
                class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2">
        </div>

        <!-- EMAIL -->
        <div class="mb-6">
            <label class="block mb-1 font-semibold dark:text-gray-200">Email</label>
            <input type="email" name="email" value="{{ $user->email }}"
                class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2">
        </div>

        <div class="flex items-center justify-end gap-3 mt-8">
            <!-- Simpan -->
            <button type="submit"
                class="px-6 py-2 rounded-lg font-semibold bg-[#4F772D] hover:bg-[#3f6123] text-white shadow-md hover:shadow-lg transition duration-200">
                Simpan Perubahan
            </button>
        </div>
    </form>
    
    <div class="flex items-center justify-end gap-3 mt-4">
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-5 py-2 rounded-lg text-sm font-medium bg-red-500 hover:bg-red-600 text-white transition duration-200">
                Logout
            </button>
        </form>
    </div>
</div>

<!-- CROP MODAL -->
<div id="crop-modal" class="hidden fixed inset-0 z-[100] bg-black bg-opacity-70 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl flex flex-col">
        <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
            <h3 class="font-bold text-lg dark:text-white">Sesuaikan Foto</h3>
            <button type="button" id="close-modal-btn" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-4 bg-gray-100 dark:bg-gray-900 flex-1 flex items-center justify-center min-h-[300px]">
            <!-- Image for cropper -->
            <div class="w-full max-w-[400px]">
                <img id="image-to-crop" class="max-w-full block">
            </div>
        </div>
        <div class="p-4 border-t dark:border-gray-700 flex justify-end gap-3">
            <button type="button" id="cancel-crop-btn" class="px-4 py-2 rounded-lg text-gray-700 bg-gray-200 hover:bg-gray-300 dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition">Batal</button>
            <button type="button" id="save-crop-btn" class="px-4 py-2 rounded-lg text-white bg-green-600 hover:bg-green-700 transition shadow">Gunakan Foto</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const photoInput = document.getElementById('photo-input');
        const photoBase64 = document.getElementById('photo-base64');
        const profilePreview = document.getElementById('profile-preview');
        
        const cropModal = document.getElementById('crop-modal');
        const imageToCrop = document.getElementById('image-to-crop');
        const saveCropBtn = document.getElementById('save-crop-btn');
        const cancelCropBtn = document.getElementById('cancel-crop-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        
        let cropper = null;

        // When a file is selected
        photoInput.addEventListener('change', function (e) {
            const files = e.target.files;
            
            if (files && files.length > 0) {
                const file = files[0];
                
                // Ensure it's an image
                if (/^image\/\w+/.test(file.type)) {
                    const reader = new FileReader();
                    
                    reader.onload = function (e) {
                        imageToCrop.src = e.target.result;
                        cropModal.classList.remove('hidden');
                        
                        // Initialize Cropper when image loads
                        if (cropper) {
                            cropper.destroy();
                        }
                        
                        cropper = new Cropper(imageToCrop, {
                            aspectRatio: 1, // Square crop for profile photos
                            viewMode: 2,
                            dragMode: 'move',
                            autoCropArea: 0.9,
                            restore: false,
                            guides: true,
                            center: true,
                            highlight: false,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                            toggleDragModeOnDblclick: false,
                        });
                    };
                    
                    reader.readAsDataURL(file);
                } else {
                    alert('Mohon pilih file gambar yang valid.');
                    photoInput.value = '';
                }
            }
        });

        function closeAndCleanUp() {
            cropModal.classList.add('hidden');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            photoInput.value = ''; // Reset input so same file can be selected again
        }

        // Save cropped image
        saveCropBtn.addEventListener('click', function () {
            if (!cropper) return;
            
            // Get cropped canvas
            const canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
            
            // Get base64 data
            const base64data = canvas.toDataURL('image/jpeg', 0.9);
            
            // Set values
            profilePreview.src = base64data;
            photoBase64.value = base64data;
            
            closeAndCleanUp();
        });

        // Cancel actions
        cancelCropBtn.addEventListener('click', closeAndCleanUp);
        closeModalBtn.addEventListener('click', closeAndCleanUp);
    });
</script>
@endpush