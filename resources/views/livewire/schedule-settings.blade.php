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
            <h1 class="text-xl font-bold text-gray-900 font-display">{{ __('Schedule Settings') }}</h1>
        </header>

        <div class="p-8 max-w-4xl mx-auto w-full">
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4">{{ __('Add Slot') }}</h2>
                <form wire:submit.prevent="addSlot" class="flex items-center space-x-4">
                    <select wire:model="selectedDay" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                        @foreach($days as $num => $name)
                            <option value="{{ $num }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <input type="time" wire:model="newTime" class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition-all">
                        {{ __('Add Slot') }}
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-6">{{ __('Timing') }}</h2>
                <div class="space-y-6">
                    @foreach($days as $num => $name)
                        <div class="border-b border-gray-50 pb-4 last:border-b-0">
                            <h3 class="text-sm font-bold text-gray-700 mb-2">{{ $name }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @forelse($slots[$num] ?? [] as $slot)
                                    <span class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-semibold">
                                        {{ substr($slot->time, 0, 5) }}
                                        <button wire:click="removeSlot({{ $slot->id }})" class="ml-2 text-indigo-400 hover:text-red-500">&times;</button>
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400">{{ __('No data') }}</span>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
