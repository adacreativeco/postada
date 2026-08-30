<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'PostPilot') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="antialiased bg-gray-50 font-sans">
    <div id="app" class="min-h-screen">
        {{ $slot }}
    </div>

    <!-- Global Notifications -->
    <div x-data="{ 
            notifications: [],
            add(e) {
                const id = Date.now();
                this.notifications.push({
                    id: id,
                    type: e.detail[0].type || 'info',
                    message: e.detail[0].message
                });
                setTimeout(() => {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                }, 5000);
            }
        }" @notify.window="add($event)"
        class="fixed bottom-8 right-8 z-[100] flex flex-col space-y-3 pointer-events-none">
        <template x-for="n in notifications" :key="n.id">
            <div x-show="true" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="pointer-events-auto bg-white border border-gray-100 shadow-2xl rounded-2xl p-4 min-w-[300px] flex items-center space-x-4">
                <div :class="{
                    'bg-green-100 text-green-600': n.type === 'success',
                    'bg-blue-100 text-blue-600': n.type === 'info',
                    'bg-red-100 text-red-600': n.type === 'error'
                }" class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <template x-if="n.type === 'success'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </template>
                    <template x-if="n.type === 'info'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-900" x-text="n.message"></p>
                </div>
                <button @click="notifications = notifications.filter(notif => notif.id !== n.id)"
                    class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    @livewireScripts
</body>

</html>