<div class="flex h-screen bg-gray-50 overflow-hidden" x-data="{ sidebarOpen: true }">
    <aside x-show="sidebarOpen" class="w-64 bg-white border-r border-gray-200 flex-shrink-0">
        <div class="h-full flex flex-col">
            <div class="p-6 flex items-center space-x-3">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold">P</span>
                </div>
                <span class="text-xl font-bold tracking-tight text-gray-900 font-display">POST ADA</span>
            </div>
            <x-sidebar />
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
            <h1 class="text-xl font-bold text-gray-900 font-display">{{ __('Account Settings') }}</h1>
        </header>

        <div class="p-8 max-w-4xl mx-auto w-full space-y-8">
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4">{{ __('Profile Information') }}</h2>
                <form wire:submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Content') }}</label>
                        <input type="text" wire:model="name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email Address') }}</label>
                        <input type="email" wire:model="email" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition-all shadow-xs">
                        {{ __('Save Changes') }}
                    </button>
                </form>
            </div>

            @if (session('password_success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('password_success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4">{{ __('Update Password') }}</h2>
                <form wire:submit.prevent="updatePassword" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Current Password') }}</label>
                        <input type="password" wire:model="current_password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                        @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('New Password') }}</label>
                        <input type="password" wire:model="password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Confirm Password') }}</label>
                        <input type="password" wire:model="password_confirmation" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition-all shadow-xs">
                        {{ __('Update Password') }}
                    </button>
                </form>
            </div>
        </div>
    </main>
</div>
