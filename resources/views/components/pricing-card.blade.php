@props(['package', 'popular' => false])

<div
    class="bg-white rounded-3xl p-8 border border-gray-200 shadow-lg relative overflow-hidden flex flex-col justify-between transform hover:-translate-y-2 transition-transform duration-300">
    @if($popular)
        <div class="absolute top-0 right-0 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-bl-xl">{{ __('POPULAR') }}</div>
    @endif

    <div>
        <h3 class="text-xl font-bold text-gray-900">{{ __($package->name) }}</h3>
        <div class="mt-4 flex items-baseline">
            <span
                class="text-4xl font-extrabold tracking-tight text-gray-900">₺{{ number_format($package->price, 0) }}</span>
        </div>
        <p class="mt-4 text-gray-500 text-sm">{{ __('Ideal for accelerating your content production.') }}</p>

        <ul class="mt-6 space-y-4">
            <li class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-gray-900 font-bold text-sm">{{ $package->credits }} {{ __('Credits') }}</span>
            </li>
            <li class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-gray-600 text-sm">~{{ floor($package->credits / 5) }} {{ __('AI Images (DALL-E 3)') }}</span>
            </li>
            <li class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-gray-600 text-sm">~{{ $package->credits }} {{ __('AI Text Captions') }}</span>
            </li>
        </ul>
    </div>

    <div class="mt-8">
        <a href="{{ route('payment.checkout', $package->id) }}"
            class="w-full block text-center bg-gray-900 hover:bg-black text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
            {{ __('Buy Now') }}
        </a>
        <p class="text-center text-xs text-gray-400 mt-3 flex items-center justify-center space-x-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
            </svg>
            <span>{{ __('Secure Payment (Shopier)') }}</span>
        </p>
    </div>
</div>
