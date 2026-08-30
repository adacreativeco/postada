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
                <span class="text-xl font-bold tracking-tight text-gray-900 font-display">POST ADA</span>
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
                    <span>{{ __('Log Out') }}</span>
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
            <h1 class="text-xl font-bold text-gray-900 font-display">{{ __('Analytics') }}</h1>
            <div class="flex items-center space-x-4">
                <select wire:model.live="timeRange"
                    class="bg-gray-50 border-none text-sm font-semibold rounded-xl px-4 py-2 ring-1 ring-gray-100">
                    <option value="24h">24h</option>
                    <option value="7d">7d</option>
                    <option value="30d">30d</option>
                    <option value="90d">90d</option>
                </select>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <!-- Metric Highlights -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Likes') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalLikes) }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Reach') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalReach) }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Avg. Engagement') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">%{{ number_format($avgEngagement, 1) }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Comments') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalComments) }}</p>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Platform Breakdown -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Platform Activity') }}</h3>
                    <div class="space-y-6">
                        @forelse($platformBreakdown as $stat)
                            <div class="space-y-2">
                                <div class="flex justify-between items-end">
                                    <div class="flex items-center space-x-2">
                                        <div @class([
                                            'w-2 h-2 rounded-full',
                                            'bg-black' => $stat->platform === 'twitter',
                                            'bg-blue-600' => $stat->platform === 'linkedin',
                                            'bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600' => $stat->platform === 'instagram',
                                        ])></div>
                                        <span class="text-sm font-bold text-gray-700 capitalize">{{ $stat->platform }}</span>
                                    </div>
                                    <span class="text-xs font-bold text-gray-500">{{ number_format($stat->total) }}</span>
                                </div>
                                <div class="h-2 bg-gray-50 rounded-full overflow-hidden">
                                    @php $percent = $totalLikes > 0 ? ($stat->total / $totalLikes) * 100 : 0; @endphp
                                    <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-300 py-8 text-xs">{{ __('No data collected yet') }}</div>
                        @endforelse
                    </div>
                </div>

                <!-- Daily Growth -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Follower Growth') }}</h3>
                    <div class="h-48 flex items-end space-x-2">
                        @forelse($dailyGrowth as $day)
                            <div class="flex-1 flex flex-col items-center group relative">
                                @php $max = $dailyGrowth->max('total') ?: 1; $h = $max > 0 ? ($day->total / $max) * 100 : 0; @endphp
                                <div class="w-full bg-indigo-100 rounded-t-lg group-hover:bg-indigo-600 transition-all duration-300" style="height: {{ max(10, $h) }}%">
                                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                        {{ $day->total }}
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold text-gray-400 mt-2 uppercase">{{ date('D', strtotime($day->date)) }}</span>
                            </div>
                        @empty
                            <div class="w-full text-center text-gray-300 py-16 text-xs">{{ __('No data') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
