@props([
    'id',
    'title' => 'Confirmar Ação',
    'message' => 'Você tem certeza que deseja realizar esta ação?',
    'confirmText' => 'Confirmar',
    'cancelText' => 'Cancelar',
    'action',
    'method' => 'POST',
    'overrideMethod' => null,
    'confirmButtonClass' => 'bg-error-500 hover:bg-error-600 text-white',
])

<div x-data="{ show: false }" @keydown.escape.window="show = false" class="inline-block">
    <!-- Trigger Element -->
    <div @click="show = true" class="inline-block">
        {{ $slot }}
    </div>

    <!-- Modal Background -->
    <div x-show="show" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 sm:p-0 transition-opacity"
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="ease-in duration-200" 
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0">
        
        <!-- Modal Panel -->
        <div x-show="show" @click.away="show = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full max-w-sm overflow-hidden rounded-xl bg-white shadow-2xl dark:bg-gray-800 sm:max-w-md">
            
            <div class="px-6 py-6 sm:p-8">
                <!-- Ícone de Alerta centralizado acima -->
                <div class="mb-5 flex items-center justify-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                
                <h3 class="mb-2 text-center text-lg font-bold text-gray-900 dark:text-white">{{ $title }}</h3>
                <p class="text-center text-sm text-gray-600 dark:text-gray-400">{{ $message }}</p>
            </div>
            
            <div class="flex flex-col gap-3 bg-gray-50 px-6 py-4 dark:bg-gray-800/50 sm:flex-row-reverse sm:px-8">
                <form method="{{ $method }}" action="{{ $action }}" class="w-full sm:w-auto">
                    @csrf
                    @if($overrideMethod)
                        @method($overrideMethod)
                    @endif
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg px-4 py-2.5 text-sm font-medium transition-colors sm:w-auto {{ $confirmButtonClass }}">
                        {{ $confirmText }}
                    </button>
                </form>
                
                <button type="button" @click="show = false" class="w-full inline-flex justify-center rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:w-auto">
                    {{ $cancelText }}
                </button>
            </div>
        </div>
    </div>
</div>
