<div class="flex h-screen bg-gray-50 overflow-hidden" x-data="{ sidebarOpen: true }">
    <!-- Animated Sidebar -->
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

            <div class="flex items-center space-x-4" x-data="{ open: false }">
                <div class="relative">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center space-x-3 focus:outline-none">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-semibold text-gray-900 font-display">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ __('Admin') }}</p>
                        </div>
                        <div
                            class="w-10 h-10 bg-indigo-100 rounded-full border-2 border-white shadow-sm flex items-center justify-center text-indigo-700 font-bold transition-transform transform hover:scale-105">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50 origin-top-right"
                        style="display: none;">

                        <div class="px-4 py-2 border-b border-gray-50">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <a href="{{ route('settings.account') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                            {{ __('Account Settings') }}
                        </a>
                        <a href="{{ route('team.settings') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                            {{ __('Team Settings') }}
                        </a>
                        <a href="{{ route('settings.ai') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                            {{ __('AI Settings') }}
                        </a>
                        <a href="{{ route('pricing') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                            {{ __('Plan & Billing') }}
                        </a>

                        <div class="border-t border-gray-50 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8" x-init="
                gsap.from($refs.header, { y: -20, opacity: 0, duration: 0.8, ease: 'power3.out' });
                gsap.from($refs.grid.children, { y: 20, opacity: 0, duration: 0.6, stagger: 0.1, delay: 0.2, ease: 'power2.out' });
            ">
            @if (session()->has('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative mb-6 transition-all">
                    {{ session('error') }}
                </div>
            @endif

            @if (session()->has('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative mb-6 transition-all">
                    {{ session('success') }}
                </div>
            @endif

            <div x-ref="header" class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 font-display">{{ __('Welcome') }},
                    {{ explode(' ', auth()->user()->name)[0] }}!
                </h1>
                <p class="text-gray-500 mt-1">{{ __('Your content engine and social automation workspace is ready.') }}</p>
            </div>

            <!-- Analytics Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8" x-init="
                gsap.from($refs.charts.children, { y: 20, opacity: 0, duration: 0.8, stagger: 0.2, ease: 'power3.out' });
            " x-ref="charts">
                <!-- Engagement Chart -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Avg. Engagement') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900">%{{ number_format($avgEngagement, 1) }}</h3>
                        </div>
                        <div class="bg-indigo-50 p-2 rounded-xl text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Mini Chart Visualization -->
                    <div class="h-32 flex items-end space-x-2">
                        @if(empty($engagementTrend))
                            <div class="w-full text-center text-xs text-gray-300 pb-4">{{ __('No data') }}</div>
                        @else
                            @foreach($engagementTrend as $val)
                                @php
                                    $maxTrend = max($engagementTrend) ?: 1;
                                    $height = ($val / $maxTrend) * 100;
                                @endphp
                                <div class="flex-1 bg-indigo-100 rounded-t-lg group-hover:bg-indigo-600 transition-all duration-500"
                                    style="height: {{ max(10, $height) }}%"></div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Platform Activity -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Platform Activity') }}</p>
                            <h2 class="text-2xl font-bold text-gray-900">{{ __('Most Active') }}</h2>
                        </div>
                        <div class="bg-purple-50 p-2 rounded-xl text-purple-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @forelse($platformPercentages as $platform => $width)
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs font-bold text-gray-500">
                                    <span>{{ ucfirst($platform) }}</span>
                                    <span>{{ $width }}%</span>
                                </div>
                                <div class="h-2 bg-gray-50 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-500 rounded-full transition-all duration-1000 group-hover:bg-indigo-600"
                                        style="width: 0%" x-init="setTimeout(() => $el.style.width = '{{ $width }}%', 500)">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-300 py-10 text-xs">{{ __('No data collected yet') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div x-ref="grid" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-sm font-medium text-gray-500">{{ __('Connected Accounts') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ auth()->user()->socialAccounts()->count() }}</p>
                </div>
                
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-sm font-medium text-gray-500">{{ __('Scheduled Posts') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ auth()->user()->posts()->where('status', 'scheduled')->count() }}
                    </p>
                </div>
                <a href="{{ route('editor') }}" wire:navigate
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                    <p class="text-sm font-medium text-gray-500 group-hover:text-indigo-600 transition-colors">
                        {{ __('Create New Post') }}
                    </p>
                    <div class="mt-4 flex items-center text-indigo-600 font-semibold font-display">
                        <span>{{ __('Get Started') }}</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Recent Posts -->
            <div class="mt-12 bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 font-display">{{ __('Recent Posts') }}</h2>
                    <a href="{{ route('editor') }}" wire:navigate
                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">{{ __('View All') }}</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th
                                    class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Content') }}</th>
                                <th
                                    class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Platforms') }}</th>
                                <th
                                    class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Status') }}</th>
                                <th
                                    class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Timing') }}</th>
                                <th
                                    class="text-right px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse(auth()->user()->posts()->latest()->take(5)->get() as $post)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-900 line-clamp-1">{{ $post->content }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-1">
                                            @foreach($post->platforms ?? [] as $platform)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                                    {{ $platform }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                                            $post->status === 'published' ? 'bg-green-100 text-green-800' :
                                            ($post->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') 
                                        }}">
                                            {{ __($post->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $post->scheduled_at ? $post->scheduled_at->format('d.m.Y H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <a href="{{ route('editor') }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-semibold">{{ __('Edit') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                        {{ __('You have not created any posts yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
