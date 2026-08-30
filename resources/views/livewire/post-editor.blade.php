<div class="flex h-screen bg-gray-50/50 overflow-hidden text-gray-800 antialiased" x-data="{ 
    sidebarOpen: true,
    activeTab: 'twitter',
    content: @entangle('content'),
    platforms: @entangle('selectedPlatforms'),
    options: @entangle('platformOptions'),
    showAiModal: @entangle('showAIAssistant'),
    showMediaModal: @entangle('showMediaLibrary'),
    get twitterExceeded() { return (this.content ?? '').length > 280 },
    get linkedinExceeded() { return (this.content ?? '').length > 3000 },
    get facebookExceeded() { return (this.content ?? '').length > 63206 },
    get instagramExceeded() { return (this.content ?? '').length > 2200 },
    get tiktokExceeded() { return (this.content ?? '').length > 2200 },
    get redditExceeded() { return (this.content ?? '').length > 40000 },
    get youtubeExceeded() { return (this.content ?? '').length > 10000 },
    get telegramExceeded() { return (this.content ?? '').length > 4096 },
    get whatsappExceeded() { return (this.content ?? '').length > 65536 },
    init() {
        if (!this.platforms || this.platforms.length === 0) {
            this.platforms = ['twitter', 'linkedin'];
        }
        this.$watch('platforms', (val) => {
            if (val && val.length > 0 && !val.includes(this.activeTab)) {
                this.activeTab = val[0];
            }
        });
    }
}">
    <!-- Sidebar -->
    <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full" class="w-60 bg-white border-r border-gray-200/80 flex-shrink-0 z-30">
        <div class="h-full flex flex-col justify-between">
            <div>
                <!-- Brand Header -->
                <div class="h-14 px-5 border-b border-gray-100 flex items-center space-x-2.5">
                    <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center shadow-xs">
                        <span class="text-white font-bold text-xs">P</span>
                    </div>
                    <span class="text-sm font-bold tracking-tight text-gray-900 font-display">POST ADA</span>
                </div>

                <x-sidebar />
            </div>

            <!-- Bottom Logout -->
            <div class="p-3 border-t border-gray-100">
                <button wire:click="logout"
                    class="w-full flex items-center space-x-2.5 px-3 py-2 text-xs font-semibold text-gray-600 hover:text-red-600 hover:bg-red-50/60 rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span>{{ __('Log Out') }}</span>
                </button>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50/50">
        <!-- Compact Top Navbar -->
        <header class="h-14 bg-white border-b border-gray-200/80 flex items-center justify-between px-6 flex-shrink-0 z-20">
            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="h-4 w-px bg-gray-200"></div>
                <h1 class="text-sm font-bold text-gray-900">{{ __('Post Composer') }}</h1>
            </div>

            <div class="flex items-center space-x-2.5">
                <button wire:click="save"
                    class="inline-flex items-center space-x-1.5 bg-indigo-600 hover:bg-indigo-700 text-white px-3.5 py-1.5 rounded-lg font-semibold text-xs shadow-xs transition-colors">
                    <span>{{ $scheduledAt ? __('Schedule') : __('Publish Now') }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>
        </header>

        <!-- Editor Layout Body -->
        <div class="flex-1 overflow-y-auto p-5">
            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-5">
                <!-- Left Column: Controls & Textarea -->
                <div class="lg:col-span-7 space-y-4">
                    <!-- Platform Selector -->
                    <div class="bg-white rounded-xl border border-gray-200/80 p-3.5 shadow-2xs">
                        <div class="flex items-center justify-between mb-2.5">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Select Platforms') }}</span>
                            <span class="text-[11px] text-gray-400" x-text="platforms.length + ' seçili'"></span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach([
                                'twitter' => ['name' => 'X (Twitter)', 'color' => 'bg-black'],
                                'linkedin' => ['name' => 'LinkedIn', 'color' => 'bg-[#0A66C2]'],
                                'instagram' => ['name' => 'Instagram', 'color' => 'bg-pink-600'],
                                'facebook' => ['name' => 'Facebook', 'color' => 'bg-[#1877F2]'],
                                'tiktok' => ['name' => 'TikTok', 'color' => 'bg-gray-900'],
                                'reddit' => ['name' => 'Reddit', 'color' => 'bg-[#FF4500]'],
                                'youtube' => ['name' => 'YouTube', 'color' => 'bg-[#FF0000]'],
                                'telegram' => ['name' => 'Telegram', 'color' => 'bg-[#229ED9]'],
                                'whatsapp' => ['name' => 'WhatsApp', 'color' => 'bg-[#25D366]']
                            ] as $key => $platform)
                                <label class="relative cursor-pointer select-none">
                                    <input type="checkbox" wire:model.live="selectedPlatforms" value="{{ $key }}" class="peer hidden">
                                    <div class="px-2.5 py-1.5 rounded-lg border border-gray-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all hover:bg-gray-50 flex items-center justify-between">
                                        <div class="flex items-center space-x-1.5 min-w-0">
                                            <div class="w-2 h-2 rounded-full {{ $platform['color'] }} flex-shrink-0"></div>
                                            <span class="text-xs font-semibold text-gray-700 truncate">{{ $platform['name'] }}</span>
                                        </div>
                                        <div class="w-3.5 h-3.5 rounded border border-gray-300 peer-checked:bg-indigo-600 peer-checked:border-indigo-600 flex items-center justify-center flex-shrink-0 ml-1">
                                            <svg class="w-2.5 h-2.5 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Textarea & Toolbar -->
                    <div class="bg-white rounded-xl border border-gray-200/80 shadow-2xs overflow-hidden">
                        <!-- Toolbar -->
                        <div class="flex flex-wrap items-center justify-between px-3 py-2 bg-gray-50/80 border-b border-gray-200/60">
                            <div class="flex items-center space-x-1.5">
                                <button @click="showAiModal = true"
                                    class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-[11px] font-semibold transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.286L13 21l-2.286-6.857L5 12l5.714-2.286L13 3z"></path>
                                    </svg>
                                    <span>{{ __('Generate with AI') }}</span>
                                </button>

                                <button wire:click="generateHashtags"
                                    class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-md bg-white hover:bg-gray-100 text-gray-700 text-[11px] font-semibold border border-gray-200 transition-colors">
                                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    <span>Hashtags</span>
                                </button>

                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-md bg-white hover:bg-gray-100 text-gray-700 text-[11px] font-semibold border border-gray-200 transition-colors">
                                        <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                        </svg>
                                        <span>{{ __('Select Tone') }}</span>
                                        <svg class="w-2.5 h-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute left-0 mt-1 w-36 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-30">
                                        <button wire:click="changeTone('professional')" @click="open = false" class="w-full text-left px-3 py-1.5 text-[11px] text-gray-700 hover:bg-indigo-50 font-medium">{{ __('Professional') }}</button>
                                        <button wire:click="changeTone('friendly')" @click="open = false" class="w-full text-left px-3 py-1.5 text-[11px] text-gray-700 hover:bg-indigo-50 font-medium">{{ __('Friendly') }}</button>
                                        <button wire:click="changeTone('creative')" @click="open = false" class="w-full text-left px-3 py-1.5 text-[11px] text-gray-700 hover:bg-indigo-50 font-medium">{{ __('Creative') }}</button>
                                        <button wire:click="changeTone('humorous')" @click="open = false" class="w-full text-left px-3 py-1.5 text-[11px] text-gray-700 hover:bg-indigo-50 font-medium">{{ __('Humorous') }}</button>
                                        <button wire:click="changeTone('informative')" @click="open = false" class="w-full text-left px-3 py-1.5 text-[11px] text-gray-700 hover:bg-indigo-50 font-medium">{{ __('Informative') }}</button>
                                    </div>
                                </div>

                                <button @click="showMediaModal = true"
                                    class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-md bg-white hover:bg-gray-100 text-gray-700 text-[11px] font-semibold border border-gray-200 transition-colors">
                                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ __('Attach Media') }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Textarea -->
                        <div class="p-3.5">
                            <textarea wire:model.live="content" placeholder="{{ __('Write your content...') }}"
                                class="w-full h-36 p-0 text-sm border-none focus:ring-0 placeholder-gray-400 resize-none font-sans text-gray-900 leading-relaxed"></textarea>

                            <!-- Attached Media Thumbs -->
                            @if($selectedMedia->count() > 0)
                                <div class="pt-2 pb-1 flex flex-wrap gap-2">
                                    @foreach($selectedMedia as $media)
                                        <div class="relative group w-14 h-14 rounded-lg overflow-hidden border border-gray-200 shadow-2xs">
                                            <img src="{{ $media->url }}" class="w-full h-full object-cover">
                                            <button wire:click="removeMedia({{ $media->id }})"
                                                class="absolute inset-0 bg-red-500/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Character Counter -->
                        <div class="flex items-center justify-between px-3.5 py-2 bg-gray-50/60 border-t border-gray-100 text-[11px] text-gray-500">
                            <div class="flex items-center space-x-2.5">
                                @if(in_array('twitter', $selectedPlatforms))
                                    <span :class="twitterExceeded ? 'text-red-600 font-bold' : ''">X: <span x-text="(content || '').length"></span>/280</span>
                                @endif
                                @if(in_array('instagram', $selectedPlatforms))
                                    <span :class="instagramExceeded ? 'text-red-600 font-bold' : ''">IG: <span x-text="(content || '').length"></span>/2200</span>
                                @endif
                                @if(in_array('linkedin', $selectedPlatforms))
                                    <span :class="linkedinExceeded ? 'text-red-600 font-bold' : ''">LI: <span x-text="(content || '').length"></span>/3000</span>
                                @endif
                            </div>
                            <span class="font-mono text-gray-400"><span x-text="(content || '').length"></span> {{ __('Character Count') }}</span>
                        </div>
                    </div>

                    <!-- Timing -->
                    <div class="bg-white rounded-xl border border-gray-200/80 p-3.5 shadow-2xs flex items-center justify-between space-x-4">
                        <div class="flex items-center space-x-2 min-w-0">
                            <svg class="w-4 h-4 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-xs font-bold text-gray-700 flex-shrink-0">{{ __('Timing') }}:</span>
                            <input type="datetime-local" wire:model="scheduledAt"
                                class="bg-gray-50 border border-gray-200 rounded-lg px-2.5 py-1 text-xs focus:ring-1 focus:ring-indigo-500 outline-none text-gray-700">
                        </div>
                        <button wire:click="autoSchedule"
                            class="text-[11px] text-indigo-600 hover:text-indigo-700 font-semibold flex items-center space-x-1 bg-indigo-50 hover:bg-indigo-100/70 px-2.5 py-1 rounded-md transition-colors flex-shrink-0">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span>Auto-Schedule</span>
                        </button>
                    </div>
                </div>

                <!-- Right Column: 100% PURE SVG REALISTIC PLATFORM PREVIEWS -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="sticky top-4">
                        <div class="bg-white rounded-xl border border-gray-200/80 p-3.5 shadow-2xs">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Platform Previews') }}</span>
                            </div>

                            <!-- Tab Switcher -->
                            <div x-show="platforms.length > 0" class="flex items-center space-x-1 mb-3 bg-gray-100/80 p-1 rounded-lg overflow-x-auto">
                                <template x-if="platforms.includes('twitter')">
                                    <button @click="activeTab = 'twitter'" :class="activeTab === 'twitter' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-700'" class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition-all">X</button>
                                </template>
                                <template x-if="platforms.includes('linkedin')">
                                    <button @click="activeTab = 'linkedin'" :class="activeTab === 'linkedin' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-700'" class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition-all">LinkedIn</button>
                                </template>
                                <template x-if="platforms.includes('instagram')">
                                    <button @click="activeTab = 'instagram'" :class="activeTab === 'instagram' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-700'" class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition-all">Instagram</button>
                                </template>
                                <template x-if="platforms.includes('facebook')">
                                    <button @click="activeTab = 'facebook'" :class="activeTab === 'facebook' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-700'" class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition-all">Facebook</button>
                                </template>
                                <template x-if="platforms.includes('tiktok')">
                                    <button @click="activeTab = 'tiktok'" :class="activeTab === 'tiktok' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-700'" class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition-all">TikTok</button>
                                </template>
                                <template x-if="platforms.includes('reddit')">
                                    <button @click="activeTab = 'reddit'" :class="activeTab === 'reddit' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-700'" class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition-all">Reddit</button>
                                </template>
                                <template x-if="platforms.includes('youtube')">
                                    <button @click="activeTab = 'youtube'" :class="activeTab === 'youtube' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-700'" class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition-all">YouTube</button>
                                </template>
                                <template x-if="platforms.includes('telegram')">
                                    <button @click="activeTab = 'telegram'" :class="activeTab === 'telegram' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-700'" class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition-all">Telegram</button>
                                </template>
                                <template x-if="platforms.includes('whatsapp')">
                                    <button @click="activeTab = 'whatsapp'" :class="activeTab === 'whatsapp' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-500 hover:text-gray-700'" class="px-2.5 py-1 rounded-md text-[11px] font-semibold transition-all">WhatsApp</button>
                                </template>
                            </div>

                            <!-- 1. TWITTER / X CARD -->
                            <div x-show="activeTab === 'twitter'" class="border border-gray-200 rounded-xl p-3.5 bg-white shadow-2xs">
                                <div class="flex space-x-2.5">
                                    <div class="w-9 h-9 rounded-full bg-black text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-1.5 leading-tight">
                                            <span class="font-bold text-xs text-gray-900 truncate">{{ auth()->user()->name }}</span>
                                            <svg class="w-3.5 h-3.5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                            <span class="text-[11px] text-gray-400 truncate">@ {{ strtolower(str_replace(' ', '', auth()->user()->name)) }} · 1m</span>
                                        </div>
                                        <div class="text-xs text-gray-900 mt-1.5 whitespace-pre-wrap break-words leading-relaxed"
                                            x-text="content || '{{ __('Write your content...') }}'"></div>
                                        
                                        @if($selectedMedia->count() > 0)
                                            <div class="mt-2.5 grid grid-cols-2 gap-1.5 rounded-lg overflow-hidden border border-gray-100">
                                                @foreach($selectedMedia as $media)
                                                    <img src="{{ $media->url }}" class="w-full h-28 object-cover">
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="flex items-center justify-between text-gray-400 mt-3 pt-2 border-t border-gray-50 text-[11px] max-w-xs">
                                            <span class="flex items-center space-x-1 hover:text-blue-500 cursor-pointer"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg><span>12</span></span>
                                            <span class="flex items-center space-x-1 hover:text-green-500 cursor-pointer"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg><span>4</span></span>
                                            <span class="flex items-center space-x-1 hover:text-red-500 cursor-pointer"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg><span>38</span></span>
                                            <span class="flex items-center space-x-1 hover:text-blue-500 cursor-pointer"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. LINKEDIN CARD -->
                            <div x-show="activeTab === 'linkedin'" class="border border-gray-200 rounded-xl bg-white shadow-2xs overflow-hidden">
                                <div class="p-3 border-b border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-9 h-9 rounded-full bg-[#0A66C2] text-white flex items-center justify-center font-bold text-xs">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-900 leading-tight">{{ auth()->user()->name }}</p>
                                            <p class="text-[10px] text-gray-400">Content Creator & Leader • 1h • Public</p>
                                        </div>
                                    </div>
                                    <button class="text-xs font-bold text-[#0A66C2] hover:underline">+ Follow</button>
                                </div>
                                <div class="p-3">
                                    <div class="text-xs text-gray-800 whitespace-pre-wrap break-words leading-relaxed"
                                        x-text="content || '{{ __('Write your content...') }}'"></div>
                                </div>
                                @if($selectedMedia->count() > 0)
                                    <div class="grid grid-cols-1 gap-1 border-t border-gray-100">
                                        @foreach($selectedMedia as $media)
                                            <img src="{{ $media->url }}" class="w-full h-36 object-cover">
                                        @endforeach
                                    </div>
                                @endif
                                <div class="px-3 py-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500 font-semibold">
                                    <span class="flex items-center space-x-1 hover:text-[#0A66C2] cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        <span>Like</span>
                                    </span>
                                    <span class="flex items-center space-x-1 hover:text-[#0A66C2] cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        <span>Comment</span>
                                    </span>
                                    <span class="flex items-center space-x-1 hover:text-[#0A66C2] cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        <span>Repost</span>
                                    </span>
                                    <span class="flex items-center space-x-1 hover:text-[#0A66C2] cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                        <span>Send</span>
                                    </span>
                                </div>
                            </div>

                            <!-- 3. INSTAGRAM CARD -->
                            <div x-show="activeTab === 'instagram'" class="border border-gray-200 rounded-xl bg-white shadow-2xs overflow-hidden max-w-[340px] mx-auto">
                                <div class="p-2.5 flex items-center justify-between border-b border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600 p-[1.5px]">
                                            <div class="w-full h-full bg-white rounded-full flex items-center justify-center text-[10px] font-bold text-gray-800">
                                                {{ substr(auth()->user()->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-900">{{ strtolower(str_replace(' ', '', auth()->user()->name)) }}</span>
                                    </div>
                                    <span class="text-gray-400 text-xs font-bold">•••</span>
                                </div>
                                <div class="bg-gray-100 aspect-square flex items-center justify-center overflow-hidden">
                                    @if($selectedMedia->count() > 0)
                                        <img src="{{ $selectedMedia->first()->url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="p-6 text-center text-xs text-gray-400 font-medium">Instagram Post Preview</div>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <div class="flex items-center justify-between text-gray-800 mb-2">
                                        <div class="flex items-center space-x-3">
                                            <svg class="w-4 h-4 text-red-500 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                        </div>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                    </div>
                                    <p class="text-xs text-gray-900 leading-relaxed break-words">
                                        <span class="font-bold mr-1">{{ strtolower(str_replace(' ', '', auth()->user()->name)) }}</span>
                                        <span x-text="content || '{{ __('Write your content...') }}'"></span>
                                    </p>
                                </div>
                            </div>

                            <!-- 4. FACEBOOK CARD -->
                            <div x-show="activeTab === 'facebook'" class="border border-gray-200 rounded-xl bg-white shadow-2xs p-3">
                                <div class="flex items-center space-x-2 mb-2.5">
                                    <div class="w-8 h-8 rounded-full bg-[#1877F2] text-white flex items-center justify-center font-bold text-xs">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900 leading-tight">{{ auth()->user()->name }}</p>
                                        <p class="text-[10px] text-gray-400">Just now • Public</p>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-800 whitespace-pre-wrap break-words leading-relaxed mb-2.5"
                                    x-text="content || '{{ __('Write your content...') }}'"></div>
                                @if($selectedMedia->count() > 0)
                                    <div class="rounded-lg overflow-hidden mb-2.5">
                                        <img src="{{ $selectedMedia->first()->url }}" class="w-full h-36 object-cover">
                                    </div>
                                @endif
                                <div class="pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500 font-semibold px-2">
                                    <span class="flex items-center space-x-1 hover:text-[#1877F2] cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        <span>Like</span>
                                    </span>
                                    <span class="flex items-center space-x-1 hover:text-[#1877F2] cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        <span>Comment</span>
                                    </span>
                                    <span class="flex items-center space-x-1 hover:text-[#1877F2] cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                        <span>Share</span>
                                    </span>
                                </div>
                            </div>

                            <!-- 5. TIKTOK CARD -->
                            <div x-show="activeTab === 'tiktok'" class="border border-gray-900 rounded-2xl bg-black text-white shadow-lg overflow-hidden max-w-[260px] mx-auto aspect-[9/16] relative flex flex-col justify-between p-3.5">
                                <div class="flex items-center justify-between text-xs text-white/80 pt-1">
                                    <span>Following</span>
                                    <span class="font-bold text-white border-b-2 border-white pb-0.5">For You</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <div class="space-y-2 z-10">
                                    <p class="text-xs font-bold">@ {{ strtolower(str_replace(' ', '', auth()->user()->name)) }}</p>
                                    <p class="text-[11px] text-white/90 line-clamp-3 leading-snug" x-text="content || '{{ __('Write your content...') }}'"></p>
                                    <p class="text-[9px] text-white/60 flex items-center space-x-1">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                                        <span>Original Sound - {{ auth()->user()->name }}</span>
                                    </p>
                                </div>
                                <div class="absolute right-2.5 bottom-12 flex flex-col items-center space-y-3.5 text-white text-[10px]">
                                    <div class="flex flex-col items-center"><svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg><span>14.2k</span></div>
                                    <div class="flex flex-col items-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg><span>342</span></div>
                                    <div class="flex flex-col items-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg><span>1.8k</span></div>
                                    <div class="flex flex-col items-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg><span>Share</span></div>
                                </div>
                            </div>

                            <!-- 6. REDDIT CARD -->
                            <div x-show="activeTab === 'reddit'" class="border border-gray-200 rounded-xl bg-white shadow-2xs p-3">
                                <div class="flex items-center space-x-2 text-[10px] text-gray-500 mb-2">
                                    <span class="w-4 h-4 rounded-full bg-[#FF4500] text-white font-bold flex items-center justify-center text-[8px]">r/</span>
                                    <span class="font-bold text-gray-900">r/postada</span>
                                    <span>• Posted by u/{{ strtolower(str_replace(' ', '', auth()->user()->name)) }} • 2h ago</span>
                                </div>
                                <div class="text-xs text-gray-900 font-semibold mb-1.5">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-700 whitespace-pre-wrap break-words leading-relaxed"
                                    x-text="content || '{{ __('Write your content...') }}'"></div>
                                <div class="mt-3 pt-2 border-t border-gray-100 flex items-center space-x-4 text-[11px] text-gray-500 font-semibold">
                                    <span class="flex items-center space-x-1.5 bg-gray-100 px-2 py-0.5 rounded-full">
                                        <svg class="w-3.5 h-3.5 text-gray-600 hover:text-[#FF4500] cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                        <span class="text-gray-900 font-bold">42</span>
                                        <svg class="w-3.5 h-3.5 text-gray-600 hover:text-blue-600 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        <span>8 Comments</span>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                        <span>Share</span>
                                    </span>
                                </div>
                            </div>

                            <!-- 7. YOUTUBE CARD -->
                            <div x-show="activeTab === 'youtube'" class="border border-gray-200 rounded-xl bg-white shadow-2xs p-3">
                                <div class="flex items-center space-x-2 mb-2.5">
                                    <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center font-bold text-xs">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900 leading-tight">{{ auth()->user()->name }}</p>
                                        <p class="text-[10px] text-gray-400">Community Post • 1 hour ago</p>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-800 whitespace-pre-wrap break-words leading-relaxed mb-2.5"
                                    x-text="content || '{{ __('Write your content...') }}'"></div>
                                <div class="pt-2 border-t border-gray-100 flex items-center space-x-4 text-[11px] text-gray-500">
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        <span>1.1K</span>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06L17 4m-7 10v5a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        <span>48</span>
                                    </span>
                                </div>
                            </div>

                            <!-- 8. TELEGRAM CARD -->
                            <div x-show="activeTab === 'telegram'" class="bg-[#8ec1e3]/30 border border-[#8ec1e3]/60 rounded-xl p-3 max-w-[340px] mx-auto">
                                <div class="bg-white rounded-lg p-2.5 shadow-2xs relative">
                                    <p class="text-xs font-bold text-[#229ED9] mb-1">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-900 whitespace-pre-wrap break-words leading-relaxed"
                                        x-text="content || '{{ __('Write your content...') }}'"></p>
                                    <div class="text-right mt-1 text-[9px] text-gray-400 flex items-center justify-end space-x-1">
                                        <span>14:32</span>
                                        <span class="text-blue-500 font-bold">✓✓</span>
                                    </div>
                                </div>
                            </div>

                            <!-- 9. WHATSAPP CARD -->
                            <div x-show="activeTab === 'whatsapp'" class="bg-[#EFEAE2] border border-gray-300 rounded-xl p-3 max-w-[340px] mx-auto">
                                <div class="bg-white rounded-lg p-2.5 shadow-2xs relative ml-auto max-w-[90%]">
                                    <p class="text-xs text-gray-900 whitespace-pre-wrap break-words leading-relaxed"
                                        x-text="content || '{{ __('Write your content...') }}'"></p>
                                    <div class="text-right mt-1 text-[9px] text-gray-400 flex items-center justify-end space-x-1">
                                        <span>14:32</span>
                                        <span class="text-[#53bdeb] font-bold">✓✓</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- AI Assistant Modal -->
    <div x-show="showAiModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="absolute inset-0 bg-gray-900/30 backdrop-blur-2xs" @click="showAiModal = false"></div>
        <div class="bg-white rounded-xl p-5 max-w-md w-full relative z-10 shadow-xl space-y-4 border border-gray-200">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 rounded-md bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.286L13 21l-2.286-6.857L5 12l5.714-2.286L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">{{ __('AI Content Assistant') }}</h3>
                </div>
                <button @click="showAiModal = false" class="text-gray-400 hover:text-gray-600 text-lg font-bold">&times;</button>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5">{{ __('Enter Content Idea or Topic') }}</label>
                <textarea wire:model="aiPrompt" rows="3" placeholder="Örn: Yeni ürün lansmanımız için etkileyici bir duyuru..."
                    class="w-full p-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs focus:ring-1 focus:ring-indigo-500 outline-none resize-none text-gray-800"></textarea>
                @error('aiPrompt') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-end space-x-2 pt-2 border-t border-gray-100">
                <button @click="showAiModal = false" class="px-3 py-1.5 text-xs text-gray-600 hover:bg-gray-100 rounded-lg font-medium">
                    {{ __('Cancel') }}
                </button>
                <button wire:click="generateCaption" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-xs">
                    {{ __('Generate with AI') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Media Library Modal -->
    <div x-show="showMediaModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-10" x-cloak>
        <div class="absolute inset-0 bg-gray-900/30 backdrop-blur-2xs" @click="showMediaModal = false"></div>
        <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl h-full max-h-[75vh] overflow-hidden relative z-10 flex flex-col border border-gray-200">
            <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-white sticky top-0 z-20">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">{{ __('Attach Media') }}</h3>
                <button @click="showMediaModal = false" class="text-gray-400 hover:text-gray-600 text-lg font-bold">&times;</button>
            </div>
            <div class="flex-1 overflow-y-auto p-4">
                @livewire('media-library')
            </div>
        </div>
    </div>
</div>
