@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <x-common.page-breadcrumb pageTitle="Galeria de Mídias" />
        
        <!-- Botão de Upload que aciona o input type=file oculto -->
        <button type="button" onclick="document.getElementById('image-upload').click()"
            class="flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600 focus:ring-3 focus:ring-brand-500/10">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 4V20M4 12H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Fazer Upload
        </button>
        
        <!-- Formulário oculto de upload -->
        <form id="upload-form" action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="hidden">
            @csrf
            <input type="file" id="image-upload" name="image" accept="image/*" onchange="document.getElementById('upload-form').submit()">
        </form>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/30 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    @error('image')
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/30 dark:text-red-400">
            {{ $message }}
        </div>
    @enderror

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:gap-6">
        @forelse ($images as $image)
            <div class="group relative aspect-square overflow-hidden rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900 flex items-center justify-center">
                <img src="{{ $image->url }}" alt="{{ $image->filename }}" class="object-cover w-full h-full" loading="lazy">
                
                <!-- Overlay de Hover -->
                <div class="absolute inset-0 bg-gray-900/60 opacity-0 transition-opacity flex items-center justify-center gap-3 group-hover:opacity-100">
                    <form action="{{ route('gallery.destroy', $image) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir esta imagem da galeria? Isso pode quebrar referências onde ela está em uso.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-white bg-error-500 rounded-full hover:bg-error-600 transition-colors" title="Excluir Imagem">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 7L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 7M10 11V17M14 11V17M15 7V4C15 3.44772 14.5523 3 14 3H10C9.44772 3 9 3.44772 9 4V7M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>
                    
                    <button type="button" onclick="navigator.clipboard.writeText('{{ $image->url }}'); alert('URL copiada: {{ $image->url }}');" class="p-2 text-white bg-gray-700 rounded-full hover:bg-gray-600 transition-colors" title="Copiar URL">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 5H6C4.89543 5 4 5.89543 4 7V19C4 20.1046 4.89543 21 6 21H16C17.1046 21 18 20.1046 18 19V17M8 5C8 6.10457 8.89543 7 10 7H12C13.1046 7 14 6.10457 14 5M8 5C8 3.89543 8.89543 3 10 3H12C13.1046 3 14 3.89543 14 5M14 5H16C17.1046 5 18 5.89543 18 7V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="14" y="11" width="8" height="6" rx="1" stroke="currentColor" stroke-width="2"/>
                            <path d="M16 14H20M16 20H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500 dark:text-gray-400">
                <svg class="mx-auto mb-4 h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p>Nenhuma imagem na galeria ainda.</p>
                <p class="text-sm">Faça o upload da sua primeira imagem.</p>
            </div>
        @endforelse
    </div>

    @if ($images->hasPages())
        <div class="mt-8 border-t border-gray-100 pt-4 dark:border-gray-800">
            {{ $images->links() }}
        </div>
    @endif
@endsection
