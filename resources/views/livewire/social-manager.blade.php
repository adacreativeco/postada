<div class="flex h-screen bg-gray-50 overflow-hidden" x-data="{ sidebarOpen: true }">
    <!-- Sidebar -->
    <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full" class="w-64 bg-white border-r border-gray-200 flex-shrink-0">
        <div class="h-full flex flex-col">
            <div class="p-6 flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold">P</span>
                </div>
                <span class="text-xl font-bold tracking-tight text-gray-900 font-display">PostPilot</span>
            </div>

            <x-sidebar />

            <div class="p-4 border-t border-gray-100">
                <button onclick="Livewire.dispatch('logout')"
                    class="w-full flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span>{{ __('Çıkış Yap') }}</span>
                </button>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
            <h1 class="text-xl font-bold text-gray-900 font-display">Hesap Yönetimi</h1>
            <div></div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="space-y-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 font-display">Sosyal Hesaplar</h2>
                    <p class="text-sm text-gray-500">Hesaplarınızı bağlayarak otomasyona başlayın.</p>
                </div>

                @if (session()->has('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                         class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative mb-4 transition-all">
                        {{ session('success') }}
                    </div>
                @endif

                <div 
                    x-ref="grid"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    x-init="
                        gsap.from($refs.grid.children, { 
                            y: 20, 
                            opacity: 0, 
                            duration: 0.6, 
                            stagger: 0.1, 
                            ease: 'power2.out',
                            clearProps: 'all'
                        });
                    "
                >
                    @foreach($availableProviders as $key => $provider)
                        @php 
                            $connected = $connectedAccounts->where('provider', $key)->first();
                        @endphp
                        
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all p-6 group">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 {{ $provider['color'] }} rounded-xl flex items-center justify-center text-white shadow-lg shadow-gray-200">
                                        <!-- Simple Icon Placeholders -->
                                        @if($key === 'twitter')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.045 4.126H5.078z"></path></svg>
                                        @elseif($key === 'linkedin')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a2.7 2.7 0 0 0-2.7-2.7c-1.2 0-2 .7-2.3 1.3v-1.1h-2.6v7.8h2.6v-4.1c0-1 .2-2 1.5-2 1.2 0 1.3 1.1 1.3 2v4.1h2.6M6.4 8.6 A1.1 1.1 0 0 1 7.5 7.5 A1.1 1.1 0 0 1 8.6 8.6 A1.1 1.1 0 0 1 7.5 9.7 A1.1 1.1 0 0 1 6.4 8.6m1.3 1.9h-2.6v7.8h2.6v-7.8z"></path></svg>
                                        @elseif($key === 'facebook')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z"></path></svg>
                                        @elseif($key === 'instagram')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M12,7A5,5 0 0,0 7,12A5,5 0 0,0 12,17A5,5 0 0,0 17,12A5,5 0 0,0 12,7M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M18,7A1,1 0 0,0 17,6A1,1 0 0,0 16,7A1,1 0 0,0 17,8A1,1 0 0,0 18,7Z"></path></svg>
                                        @elseif($key === 'tiktok')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.17-2.81-.74-3.94-1.69-.17-.15-.33-.31-.48-.48v6.98c.11 5.37-4.11 10.05-9.45 10.12-5.74.19-10.74-4.56-10.51-10.32.12-4.52 3.44-8.52 7.89-9.28.32-.06.64-.1.95-.12.02 1.34-.01 2.68.01 4.02-2.31.22-4.4 1.83-4.99 4.07-.94 3.19 1.11 6.55 4.29 7.42 3.12.97 6.64-1.07 7.44-4.16.14-.36.19-.74.22-1.12V.02z"></path></svg>
                                        @elseif($key === 'reddit')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 11.5c0-1.65-1.35-3-3-3-.45 0-.88.1-1.26.28-1.74-1.28-4.16-2.11-6.84-2.2l1.45-6.57 4.74 1.01c.03.84.72 1.51 1.57 1.51 1.35 0 2.45-1.1 2.45-2.45S19.5 0 18.15 0c-1.12 0-2.06.75-2.34 1.77L11 .66c-.14-.03-.29.02-.38.13-.1.1-.13.25-.11.39l1.61 7.28C9.44 8.54 6.94 9.38 5.14 10.69c-.39-.19-.82-.29-1.27-.29-1.65 0-3 1.35-3 3 0 1.09.58 2.04 1.45 2.56-.05.24-.08.48-.08.73 0 3.31 4.03 6 9 6s9-2.69 9-6c0-.24-.03-.47-.08-.71.88-.53 1.47-1.48 1.47-2.58zM18.82 20c-1.42 0-2.58-1.16-2.58-2.58 0-1.42 1.16-2.58 2.58-2.58s2.58 1.16 2.58 2.58c0 1.42-1.16 2.58-2.58 2.58zM5.18 14.84c0-1.42 1.16-2.58 2.58-2.58s2.58 1.16 2.58 2.58-1.16 2.58-2.58 2.58-2.58-1.16-2.58-2.58zM17.47 18.23c-.45.45-1.2.7-2.1.7s-1.65-.25-2.1-.7c-.22-.22-.22-.58 0-.8s.58-.22.8 0c.32.32.88.46 1.3.46.42 0 .98-.14 1.3-.46.22-.22.58-.22.8 0s.23.58.01.8z"></path></svg>
                                        @elseif($key === 'youtube')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M10,15L15.19,12L10,9V15M21.56,7.17C21.69,7.64 21.78,8.27 21.84,9.07C21.91,9.87 21.94,10.56 21.94,11.16L22,12C22,14.19 21.84,15.8 21.56,16.83C21.31,17.73 20.73,18.31 19.83,18.56C19.36,18.69 18.73,18.78 17.93,18.84C17.13,18.91 16.44,18.94 15.84,18.94L15,19C12.81,19 11.2,18.84 10.17,18.56C9.27,18.31 8.69,17.73 8.44,16.83C8.31,16.36 8.22,15.73 8.16,14.93C8.09,14.13 8.06,13.44 8.06,12.84L8,12C8,9.81 8.16,8.2 8.44,7.17C8.69,6.27 9.27,5.69 10.17,5.44C10.64,5.31 11.27,5.22 12.07,5.16C12.87,5.09 13.56,5.06 14.16,5.06L15,5C17.19,5 18.8,5.16 19.83,5.44C20.73,5.69 21.31,6.27 21.56,7.17Z"></path></svg>
                                        @elseif($key === 'telegram')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M9.78,18.65L10.06,14.42L17.74,7.5C18.08,7.19 17.67,7.04 17.22,7.31L7.74,13.3L3.64,12C2.76,11.75 2.75,11.14 3.84,10.7L19.81,4.54C20.54,4.21 21.24,4.72 20.96,5.84L18.24,18.65C18.05,19.56 17.5,19.78 16.74,19.36L12.6,16.3L10.59,18.23C10.37,18.45 10.18,18.65 9.78,18.65Z"></path></svg>
                                        @elseif($key === 'whatsapp')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2 22L7.22 20.63C8.65 21.41 10.27 21.82 11.91 21.82H11.92C17.38 21.82 21.83 17.37 21.83 11.91C21.83 9.27 20.8 6.78 18.92 4.9C17.04 3.02 14.55 2 11.91 2H12.04M11.91 3.53C14.16 3.53 16.28 4.41 17.87 6C19.46 7.59 20.34 9.7 20.34 11.91C20.34 16.54 16.54 20.34 11.92 20.34C10.55 20.34 9.21 20 8.04 19.34L7.76 19.17L4.64 20L4.77 16.92L4.58 16.63C3.84 15.45 3.45 14.09 3.45 11.91C3.45 7.28 7.25 3.53 11.91 3.53M16.53 14.5C16.32 14.39 15.26 13.88 15.06 13.81C14.86 13.73 14.72 13.7 14.58 13.91C14.43 14.12 14.03 14.58 13.91 14.72C13.79 14.86 13.67 14.88 13.46 14.77C13.26 14.66 12.58 14.44 11.79 13.74C11.17 13.18 10.75 12.5 10.63 12.29C10.5 12.09 10.61 11.98 10.72 11.87C10.81 11.77 10.92 11.63 11.03 11.53C11.13 11.43 11.17 11.36 11.24 11.22C11.3 11.08 11.27 10.96 11.22 10.86C11.17 10.75 10.75 9.71 10.58 9.28C10.4 8.87 10.22 8.92 10.09 8.92C9.97 8.92 9.83 8.92 9.68 8.92C9.54 8.92 9.31 8.97 9.12 9.17C8.92 9.37 8.35 9.9 8.35 11C8.35 12.1 9.15 13.16 9.26 13.31C9.37 13.46 10.83 15.71 13.06 16.67C13.59 16.9 14 17.04 14.32 17.15C14.85 17.31 15.34 17.29 15.73 17.23C16.15 17.17 17.03 16.7 17.21 16.19C17.39 15.69 17.39 15.26 17.33 15.17C17.28 15.09 17.13 15.04 16.93 14.94" /></svg>
                                        @else
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a2.7 2.7 0 0 0-2.7-2.7c-1.2 0-2 .7-2.3 1.3v-1.1h-2.6v7.8h2.6v-4.1c0-1 .2-2 1.5-2 1.2 0 1.3 1.1 1.3 2v4.1h2.6M6.4 8.6 A1.1 1.1 0 0 1 7.5 7.5 A1.1 1.1 0 0 1 8.6 8.6 A1.1 1.1 0 0 1 7.5 9.7 A1.1 1.1 0 0 1 6.4 8.6m1.3 1.9h-2.6v7.8h2.6v-7.8z"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $provider['name'] }}</h3>
                                        <p class="text-xs {{ $connected ? 'text-green-600' : 'text-gray-400' }}">
                                            {{ $connected ? 'Bağlı: ' . ($connected->nickname ?: 'Aktif') : 'Bağlı değil' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                @if($connected)
                                    <button 
                                        wire:click="disconnect({{ $connected->id }})"
                                        wire:confirm="Bu hesabı kaldırmak istediğinizden emin misiniz?"
                                        class="w-full py-2 px-4 rounded-xl border border-red-100 text-red-600 font-semibold text-sm hover:bg-red-50 transition-colors"
                                    >
                                        Bağlantıyı Kes
                                    </button>
                                @else
                                    <a 
                                        href="{{ route('social.redirect', $key) }}"
                                        class="w-full inline-flex justify-center py-2 px-4 rounded-xl {{ $provider['color'] }} text-white font-semibold text-sm hover:opacity-90 transform active:scale-95 transition-all"
                                    >
                                        Şimdi Bağla
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
