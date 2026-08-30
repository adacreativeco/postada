<div x-data="{ shown: false }" x-init="
        shown = true;
        $nextTick(() => {
            gsap.from($refs.form, { 
                y: 30, 
                opacity: 0, 
                duration: 1, 
                ease: 'power3.out' 
            });
            gsap.from($refs.items.children, {
                y: 20,
                opacity: 0,
                duration: 0.8,
                stagger: 0.1,
                delay: 0.3,
                ease: 'power2.out'
            });
        })
    " class="space-y-6">
    <!-- Header -->
    <div x-ref="items" class="text-center">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 font-display">PostPilot'a Katılın</h2>
        <p class="mt-2 text-sm text-gray-600">Sosyal medyada fark yaratmaya bugün başlayın.</p>
    </div>

    <form wire:submit.prevent="register" x-ref="form" class="space-y-4">
        <div x-ref="items">
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Tam Adınız</label>
                <input wire:model="name" type="text" id="name" required autofocus
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200">
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-posta Adresi</label>
                <input wire:model="email" type="email" id="email" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200">
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Şifre</label>
                <input wire:model="password" type="password" id="password" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200">
                @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Şifre Tekrarı</label>
                <input wire:model="password_confirmation" type="password" id="password_confirmation" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200">
            </div>

            <!-- Register Button -->
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all active:scale-95 duration-200">
                    <span wire:loading.remove>Hesap Oluştur</span>
                    <span wire:loading>Oluşturuluyor...</span>
                </button>
            </div>
        </div>
    </form>

    <div class="text-center mt-6">
        <p class="text-sm text-gray-600">
            Zaten bir hesabınız var mı?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 font-display">Giriş
                Yapın</a>
        </p>
    </div>
</div>