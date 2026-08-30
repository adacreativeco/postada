<div class="flex h-screen bg-gray-50 overflow-hidden" x-data="{ sidebarOpen: true }">
    <!-- Sidebar -->
    <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" ...
        class="w-64 bg-white border-r border-gray-200 flex-shrink-0">
        <!-- (Sidebar content same as dashboard/analytics) -->
        <div class="h-full flex flex-col">
            <div class="p-6 flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold">P</span>
                </div>
                <span class="text-xl font-bold tracking-tight text-gray-900 font-display">PostPilot</span>
            </div>

            <x-sidebar />

            <div class="p-4 border-t border-gray-100">
                <button wire:click="logout"
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
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-xl font-bold text-gray-900 font-display">İçerik Takvimi</h1>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex items-center bg-gray-100 rounded-xl p-1">
                    <button wire:click="prevMonth"
                        class="p-2 hover:bg-white hover:shadow-sm rounded-lg transition-all text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>
                    <span class="px-4 font-bold text-gray-900 min-w-[140px] text-center">{{ $currentMonthName }}</span>
                    <button wire:click="nextMonth"
                        class="p-2 hover:bg-white hover:shadow-sm rounded-lg transition-all text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
                <a href="{{ route('editor') }}" wire:navigate
                    class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
                    Yeni Gönderi
                </a>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <!-- Day Names -->
                <div class="grid grid-cols-7 bg-gray-50/50 border-b border-gray-100">
                    @foreach(['Pzr', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt'] as $dayName)
                        <div class="py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">
                            {{ $dayName }}
                        </div>
                    @endforeach
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7" x-data="{ draggingId: null }">
                    <!-- Blank Days -->
                    @for($i = 0; $i < $blankDays; $i++)
                        <div class="h-32 border-b border-r border-gray-50 bg-gray-50/20"></div>
                    @endfor

                    <!-- Actual Days -->
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        <div @dragover.prevent="$event.currentTarget.classList.add('bg-indigo-50')"
                            @dragleave.prevent="$event.currentTarget.classList.remove('bg-indigo-50')" @drop.prevent="
                                        $event.currentTarget.classList.remove('bg-indigo-50');
                                        if (draggingId) {
                                            $wire.reschedule(draggingId, {{ $day }});
                                        }
                                    "
                            class="h-32 border-b border-r border-gray-100 p-2 group hover:bg-gray-50/50 transition-all relative overflow-hidden">

                            <div class="flex items-center justify-between mb-1">
                                <span @class([
                                    'text-sm font-bold',
                                    'text-indigo-600' => $day == now()->day && $month == now()->month && $year == now()->year,
                                    'text-gray-400' => !($day == now()->day && $month == now()->month && $year == now()->year)
                                ])>{{ $day }}</span>

                                @if($day == now()->day && $month == now()->month && $year == now()->year)
                                    <span
                                        class="text-[8px] bg-indigo-600 text-white px-1.5 py-0.5 rounded-full uppercase font-bold tracking-tighter">{{ __('Bugün') }}</span>
                                @endif
                            </div>

                            <div class="space-y-1">
                                @if(isset($postsByDay[$day]))
                                    @foreach($postsByDay[$day] as $post)
                                        <div @if($post->status !== 'published') draggable="true"
                                        @dragstart="draggingId = {{ $post->id }}" @dragend="draggingId = null" @endif
                                            class="px-2 py-1 rounded-lg text-[10px] font-bold truncate flex items-center space-x-1 cursor-pointer transition-all hover:scale-[1.02] active:scale-95 group/card {{ $post->status === 'published' ? 'bg-green-50 text-green-700 border border-green-100 cursor-default' : 'bg-yellow-50 text-yellow-700 border border-yellow-100' }}">
                                            <div class="flex -space-x-1 shrink-0">
                                                @foreach(array_slice($post->platforms, 0, 2) as $platform)
                                                    <div
                                                        class="w-3 h-3 rounded-full bg-white border border-gray-100 flex items-center justify-center">
                                                        <span
                                                            class="text-[6px] transition-all">{{ strtoupper(substr($platform, 0, 1)) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <span class="truncate">{{ $post->content }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Day Hover Info (Quick Add) -->
                            <div class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('editor') }}?date={{ $year }}-{{ $month }}-{{ $day }}" wire:navigate
                                    class="bg-white/80 backdrop-blur-sm p-1 rounded-lg shadow-sm border border-gray-100 text-indigo-600 hover:text-indigo-700">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Legend -->
            <div class="mt-6 flex items-center space-x-6">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <span class="text-xs font-bold text-gray-500">Yayınlandı</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <span class="text-xs font-bold text-gray-500">Zamanlandı / Taslak</span>
                </div>
            </div>
        </div>
    </main>
</div>