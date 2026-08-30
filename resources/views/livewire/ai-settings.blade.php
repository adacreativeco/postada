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
            <h1 class="text-xl font-bold text-gray-900 font-display">{{ __('AI Settings') }}</h1>
        </header>

        <div class="p-8 max-w-4xl mx-auto w-full">
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <form wire:submit.prevent="save" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">AI Provider</label>
                        <select wire:model="provider" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                            <option value="gemini">Google Gemini 2.0 Flash</option>
                            <option value="openai">OpenAI GPT-4o</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">OpenAI API Key</label>
                        <input type="password" wire:model="openaiKey" placeholder="sk-..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gemini API Key</label>
                        <input type="password" wire:model="geminiKey" placeholder="AIza..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                    </div>

                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition-all shadow-xs">
                        {{ __('Save Changes') }}
                    </button>
                </form>
            </div>
        </div>
    </main>
</div>
