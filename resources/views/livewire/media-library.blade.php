<div class="space-y-8" x-data="{ isUploading: false, isDragging: false }">
    <!-- Header/Upload Zone -->
    <div class="relative group" @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
        @drop.prevent="isDragging = false">
        <div :class="{
                'border-2 border-dashed rounded-3xl p-12 transition-all duration-300 flex flex-col items-center justify-center space-y-4': true,
                'border-indigo-200 bg-white': !isDragging,
                'border-indigo-500 bg-indigo-50/50 scale-[1.01]': isDragging
            }">
            <div
                class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                    </path>
                </svg>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-bold text-gray-900 font-display">Medya Yükle</h3>
                <p class="text-sm text-gray-500">Dosyaları buraya sürükleyin veya seçmek için tıklayın</p>
            </div>
            <input type="file" wire:model="uploads" multiple
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="isUploading = true">
        </div>

        <!-- Upload Progress Indicator -->
        <div x-show="isUploading" x-transition class="mt-4">
            <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-indigo-600 animate-progress"></div>
            </div>
            <p class="text-[10px] font-bold text-indigo-600 mt-2 uppercase tracking-widest text-center">Yükleniyor...
            </p>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-900 font-display">Kütüphanem</h2>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" wire:model.live="search" placeholder="Dosya ara..."
                    class="pl-10 pr-4 py-2 bg-white border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all w-64">
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @forelse($mediaItems as $item)
            <div
                class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden aspect-square hover:shadow-md transition-all duration-300">
                <img src="{{ $item->url }}" alt="{{ $item->filename }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                <!-- Overlay Actions -->
                <div
                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center space-x-2">
                    <button wire:click="deleteMedia({{ $item->id }})"
                        wire:confirm="Bu dosyayı silmek istediğinizden emin misiniz?"
                        class="p-2 bg-white/20 backdrop-blur-md rounded-lg text-white hover:bg-red-500 transition-colors"
                        title="{{ __('Sil') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                    <button
                        class="p-2 bg-white/20 backdrop-blur-md rounded-lg text-white hover:bg-indigo-500 transition-colors"
                        title="Seç" @click="$dispatch('media-selected', { url: '{{ $item->url }}', id: {{ $item->id }} })">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Info Badge -->
                <div class="absolute bottom-2 left-2 right-2">
                    <div class="bg-black/60 backdrop-blur-md px-2 py-1 rounded text-[8px] text-white font-bold truncate">
                        {{ $item->filename }}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 flex flex-col items-center justify-center text-gray-400">
                <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <p>Henüz hiç medya yüklenmemiş.</p>
            </div>
        @endforelse
    </div>

    <style>
        @keyframes progress {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .animate-progress {
            animation: progress 1.5s infinite linear;
        }
    </style>
</div>