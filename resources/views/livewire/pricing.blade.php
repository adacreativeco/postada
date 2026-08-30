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
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-10">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
            <h1 class="text-xl font-bold text-gray-900 font-display">{{ __('Packages & Credits') }}</h1>
            <div class="flex items-center space-x-4">
                <div
                    class="bg-indigo-50 px-4 py-2 rounded-xl text-indigo-700 text-sm font-bold flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>{{ number_format(auth()->user()->ai_credits) }} {{ __('Credits Available') }}</span>
                </div>

                <div class="h-8 w-px bg-gray-200 mx-2"></div>

                <div class="flex items-center space-x-4" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center space-x-3 focus:outline-none">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-semibold text-gray-900 font-display">{{ auth()->user()->name }}
                                </p>
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
            </div>
        </header>

        <div class="p-8 max-w-7xl mx-auto w-full">

            @if (session('success'))
                <div
                    class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center space-x-3">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-8 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl flex items-center space-x-3">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 font-display">{{ __('Credit Packages Tailored to Your Needs') }}</h2>
                <p class="mt-4 text-gray-500 text-lg">{{ __('No commitments, no recurring subscriptions. Buy as much as you need, use freely.') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Free Tier Card (Visual only) -->
                <div
                    class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col justify-between opacity-75 grayscale hover:grayscale-0 transition-all duration-300">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ __('Starter') }}</h3>
                        <div class="mt-4 flex items-baseline">
                            <span class="text-4xl font-extrabold tracking-tight text-gray-900">₺0</span>
                        </div>
                        <p class="mt-4 text-gray-500 text-sm">{{ __('Free monthly renewal credits to explore the platform.') }}</p>

                        <ul class="mt-6 space-y-4">
                            <li class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-600 text-sm">{{ __('10 Free Credits Every Month') }}</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-600 text-sm">{{ __('Core Features') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                @foreach($packages as $package)
                    <x-pricing-card :package="$package" :popular="$package->credits > 200" />
                @endforeach
            </div>

            <div class="mt-16 text-center">
                <img src="https://s3.eu-central-1.amazonaws.com/shopier-images/shopier-logo.png" alt="Shopier"
                    class="h-8 mx-auto opacity-50 grayscale hover:grayscale-0 transition-all">
            </div>
        </div>
    </main>
</div>
