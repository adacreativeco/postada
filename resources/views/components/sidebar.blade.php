<div class="px-4 py-6 border-b border-gray-100 mb-4" x-data="{ open: false }">
    <div class="relative">
        <button @click="open = !open"
            class="w-full flex items-center justify-between px-3 py-2 bg-white border border-gray-200 rounded-xl hover:border-indigo-300 transition-all group">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                    {{ substr(auth()->user()->currentTeam()?->name ?? 'P', 0, 1) }}
                </div>
                <div class="text-left overflow-hidden">
                    <p class="text-xs text-gray-400 font-medium truncate uppercase tracking-wider">{{ __('Active Team') }}</p>
                    <p class="text-sm font-semibold text-gray-700 truncate">
                        {{ auth()->user()->currentTeam()?->name ?? 'POST ADA' }}
                    </p>
                </div>
            </div>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            class="absolute left-0 right-0 mt-2 py-2 bg-white border border-gray-100 rounded-xl shadow-xl z-50">

            <p class="px-4 py-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('My Teams') }}</p>

            @foreach(auth()->user()->allTeams() as $team)
                <form method="POST" action="{{ route('teams.switch', $team) }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm {{ auth()->user()->current_team_id === $team->id ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        {{ $team->name }}
                    </button>
                </form>
            @endforeach

            <div class="border-t border-gray-100 mt-2 pt-2">
                <a href="{{ route('team.settings') }}" wire:navigate @click="open = false"
                    class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                        </path>
                    </svg>
                    <span>{{ __('Team Settings') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>

<nav class="flex-1 px-4 space-y-1.5 mt-2">
    <a href="{{ route('dashboard') }}" wire:navigate
        class="flex items-center space-x-3 px-4 py-2.5 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl font-medium transition-all group">
        <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-700' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            </path>
        </svg>
        <span>{{ __('Dashboard') }}</span>
    </a>

    <a href="{{ route('analytics') }}" wire:navigate
        class="flex items-center space-x-3 px-4 py-2.5 {{ request()->routeIs('analytics') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl font-medium transition-all group">
        <svg class="w-5 h-5 {{ request()->routeIs('analytics') ? 'text-indigo-700' : 'text-gray-400 group-hover:text-gray-600' }}"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
            </path>
        </svg>
        <span>{{ __('Analytics') }}</span>
    </a>

    <a href="{{ route('calendar') }}" wire:navigate
        class="flex items-center space-x-3 px-4 py-2.5 {{ request()->routeIs('calendar') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl font-medium transition-all group">
        <svg class="w-5 h-5 {{ request()->routeIs('calendar') ? 'text-indigo-700' : 'text-gray-400 group-hover:text-gray-600' }}"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
            </path>
        </svg>
        <span>{{ __('Calendar') }}</span>
    </a>

    <a href="{{ route('editor') }}" wire:navigate
        class="flex items-center space-x-3 px-4 py-2.5 {{ request()->routeIs('editor') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl font-medium transition-all group">
        <svg class="w-5 h-5 {{ request()->routeIs('editor') ? 'text-indigo-700' : 'text-gray-400 group-hover:text-gray-600' }}"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
            </path>
        </svg>
        <span>{{ __('Post Composer') }}</span>
    </a>

    <a href="{{ route('social.accounts') }}" wire:navigate
        class="flex items-center space-x-3 px-4 py-2.5 {{ request()->routeIs('social.accounts') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl font-medium transition-all group">
        <svg class="w-5 h-5 {{ request()->routeIs('social.accounts') ? 'text-indigo-700' : 'text-gray-400 group-hover:text-gray-600' }}"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
            </path>
        </svg>
        <span>{{ __('Social Accounts') }}</span>
    </a>

    <a href="{{ route('pricing') }}" wire:navigate
        class="flex items-center space-x-3 px-4 py-2.5 {{ request()->routeIs('pricing') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl font-medium transition-all group">
        <svg class="w-5 h-5 {{ request()->routeIs('pricing') ? 'text-indigo-700' : 'text-gray-400 group-hover:text-gray-600' }}"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
            </path>
        </svg>
        <span>{{ __('Pricing') }}</span>
    </a>

    <a href="{{ route('settings.ai') }}" wire:navigate
        class="flex items-center space-x-3 px-4 py-2.5 {{ request()->routeIs('settings.ai') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl font-medium transition-all group">
        <svg class="w-5 h-5 {{ request()->routeIs('settings.ai') ? 'text-indigo-700' : 'text-gray-400 group-hover:text-gray-600' }}"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
        <span>{{ __('AI Settings') }}</span>
    </a>

    <div class="pt-4 mt-4 border-t border-gray-100">
        <!-- Minimalist Language Switcher -->
        <a href="{{ route('locale.switch', app()->getLocale() === 'tr' ? 'en' : 'tr') }}"
            class="flex items-center justify-between px-4 py-2.5 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl text-xs font-semibold text-gray-700 transition-colors">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                </svg>
                <span>{{ __('Language') }}</span>
            </span>
            <span class="px-2 py-0.5 rounded bg-gray-200 text-gray-800 text-[10px] font-bold tracking-wider uppercase">
                {{ app()->getLocale() === 'tr' ? 'TR / EN' : 'EN / TR' }}
            </span>
        </a>
    </div>
</nav>
