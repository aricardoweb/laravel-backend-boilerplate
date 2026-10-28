@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <x-common.page-breadcrumb pageTitle="Configurações da Plataforma" />
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/30 dark:text-red-400">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Aparência e Identidade</h3>
            <p class="text-sm text-gray-500 mt-1 dark:text-gray-400">Configure o nome e selecione as mídias da galeria para personalizar a plataforma.</p>
        </div>
        
        <form action="{{ route('settings.update') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <!-- Nome da Aplicação -->
                <div>
                    <label for="app_name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nome da Plataforma
                    </label>
                    <input type="text" id="app_name" name="settings[app_name]" 
                        value="{{ old('settings.app_name', $settings['app_name'] ?? 'Adminpanel Backend') }}"
                        class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400"
                        placeholder="Ex: Minha Empresa">
                </div>

                <hr class="border-gray-200 dark:border-gray-800">

                <div x-data="gallerySelector({
                    images: {{ Js::from($images) }},
                    app_logo: '{{ old('settings.app_logo', $settings['app_logo'] ?? '') }}',
                    app_favicon: '{{ old('settings.app_favicon', $settings['app_favicon'] ?? '') }}',
                    auth_banner: '{{ old('settings.auth_banner', $settings['auth_banner'] ?? '') }}'
                })">
                    <!-- Configurações de Mídia usando AlpineJS para seleção -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Logo -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Logo Principal
                            </label>
                            
                            <!-- Input Hidden que receberá a URL -->
                            <input type="hidden" name="settings[app_logo]" x-model="app_logo">

                            <!-- Preview / Seleção -->
                            <div @click="openGallery('app_logo')" class="group relative cursor-pointer overflow-hidden rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 transition-colors aspect-video flex-col dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 flex items-center justify-center text-center p-4">
                                <template x-if="app_logo">
                                    <div class="w-full h-full p-2 flex items-center justify-center">
                                        <img :src="app_logo" class="max-h-full max-w-full object-contain">
                                    </div>
                                </template>
                                <template x-if="!app_logo">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-8 w-8 text-gray-400 mb-2 group-hover:text-brand-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500 group-hover:text-brand-500">Selecionar na Galeria</span>
                                    </div>
                                </template>
                                
                                <template x-if="app_logo">
                                    <div class="absolute inset-0 bg-gray-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="text-sm font-medium text-white px-3 py-1.5 rounded-lg border border-white/20 backdrop-blur-sm">Trocar Imagem</span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Favicon -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Favicon (Ícone Aba)
                            </label>
                            <input type="hidden" name="settings[app_favicon]" x-model="app_favicon">
                            
                            <div @click="openGallery('app_favicon')" class="group relative cursor-pointer overflow-hidden rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 transition-colors aspect-square md:aspect-video flex-col dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 flex items-center justify-center text-center p-4">
                                <template x-if="app_favicon">
                                    <div class="w-20 h-20 p-2 flex items-center justify-center bg-white rounded-lg shadow-sm border border-gray-100 dark:bg-gray-900 dark:border-gray-700">
                                        <img :src="app_favicon" class="w-full h-full object-contain">
                                    </div>
                                </template>
                                <template x-if="!app_favicon">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-8 w-8 text-gray-400 mb-2 group-hover:text-brand-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500 group-hover:text-brand-500">Selecionar</span>
                                    </div>
                                </template>
                                <template x-if="app_favicon">
                                    <div class="absolute inset-0 bg-gray-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="text-sm font-medium text-white px-3 py-1.5 rounded-lg border border-white/20 backdrop-blur-sm">Trocar</span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Banner Login -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Banner de Autenticação
                            </label>
                            <input type="hidden" name="settings[auth_banner]" x-model="auth_banner">
                            
                            <div @click="openGallery('auth_banner')" class="group relative cursor-pointer overflow-hidden rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 transition-colors aspect-video flex-col dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 flex items-center justify-center text-center p-4">
                                <template x-if="auth_banner">
                                    <img :src="auth_banner" class="w-full h-full object-cover rounded-lg">
                                </template>
                                <template x-if="!auth_banner">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-8 w-8 text-gray-400 mb-2 group-hover:text-brand-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500 group-hover:text-brand-500">Selecionar</span>
                                    </div>
                                </template>
                                <template x-if="auth_banner">
                                    <div class="absolute inset-0 bg-gray-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="text-sm font-medium text-white px-3 py-1.5 rounded-lg border border-white/20 backdrop-blur-sm">Trocar Imagem</span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Modal da Galeria (AlpineJS) -->
                    <div x-show="isGalleryOpen" style="display: none;" class="fixed inset-0 z-[999999] flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4 sm:p-6"
                        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        
                        <div class="relative flex h-full max-h-[80vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-gray-900"
                            @click.outside="canCloseGallery() && closeGallery()">
                            
                            <!-- Header do Modal -->
                            <div class="flex items-center justify-between gap-3 border-b border-gray-100 px-4 py-4 sm:px-6 dark:border-gray-800">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Selecione ou envie uma imagem</h3>
                                <div class="flex items-center gap-2 shrink-0">
                                    <button type="button"
                                        @click="openFilePicker()"
                                        :disabled="isUploading"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-brand-500 px-3 py-2 text-xs sm:text-sm font-medium text-white hover:bg-brand-600 disabled:opacity-60 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <span x-text="isUploading ? 'Enviando...' : 'Enviar imagem'"></span>
                                    </button>
                                    <button type="button" @click="closeGallery(true)" class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-gray-800">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <input type="file" x-ref="fileInput" class="hidden" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp" @change="handleFileSelect($event)">

                            <!-- Área de Upload Rápido -->
                            <div class="px-4 py-4 sm:px-6 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50">
                                <div 
                                    class="relative border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-4 sm:p-6 text-center transition-all cursor-pointer"
                                    :class="{'border-brand-500 bg-brand-50/50 dark:bg-brand-900/10': isDragging}"
                                    @click="openFilePicker()"
                                    @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false"
                                    @drop.prevent="isDragging = false; handleDrop($event)"
                                >
                                    <div x-show="!isUploading">
                                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Arraste uma imagem aqui ou toque para enviar
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, SVG, WEBP ou GIF (máx. 5MB)</p>
                                    </div>

                                    <div x-show="isUploading" style="display: none;" class="flex flex-col items-center">
                                        <svg class="animate-spin h-8 w-8 text-brand-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <p class="text-sm font-medium text-brand-600 dark:text-brand-400">Enviando imagem...</p>
                                    </div>
                                </div>
                                <template x-if="uploadError">
                                    <p class="text-red-500 text-sm mt-3 text-center" x-text="uploadError"></p>
                                </template>
                            </div>

                            <!-- Grade de Imagens -->
                            <div class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50/50 dark:bg-black/20 custom-scrollbar">
                                <template x-if="images.length === 0 && !isUploading">
                                    <div class="py-12 text-center text-gray-500">
                                        <p class="font-medium">Nenhuma imagem na galeria.</p>
                                        <p class="text-sm mt-1">Use o botão <span class="font-semibold text-brand-500">Enviar imagem</span> acima para adicionar.</p>
                                    </div>
                                </template>
                                
                                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                                    <template x-for="img in images" :key="img.id">
                                        <div @click="selectImage(img.url)" class="group cursor-pointer aspect-square overflow-hidden rounded-xl border-2 border-transparent bg-white shadow-sm transition-all hover:border-brand-500 hover:shadow-md dark:bg-gray-800"
                                             :class="{'!border-brand-500 ring-2 ring-brand-500/20 box-border': isActive(img.url)}">
                                            <img :src="img.url" :alt="img.filename" class="h-full w-full object-cover">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-800">
                <button type="reset" class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors shadow-sm shadow-brand-500/20">
                    Salvar Configurações
                </button>
            </div>
        </form>
    </div>
@endsection

@push('alpine')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('gallerySelector', (initialData) => ({
            images: initialData.images || [],
            app_logo: initialData.app_logo || '',
            app_favicon: initialData.app_favicon || '',
            auth_banner: initialData.auth_banner || '',

            isGalleryOpen: false,
            currentActivatingField: null,
            isDragging: false,
            isUploading: false,
            isPickingFile: false,
            uploadError: null,

            openGallery(field) {
                this.currentActivatingField = field;
                this.isGalleryOpen = true;
                this.uploadError = null;
                document.body.style.overflow = 'hidden';
            },

            canCloseGallery() {
                return !this.isUploading && !this.isPickingFile;
            },

            closeGallery(force = false) {
                if (!force && !this.canCloseGallery()) {
                    return;
                }

                this.isGalleryOpen = false;
                this.currentActivatingField = null;
                this.isPickingFile = false;
                this.uploadError = null;
                document.body.style.overflow = '';
            },

            openFilePicker() {
                if (this.isUploading) {
                    return;
                }

                this.isPickingFile = true;
                this.uploadError = null;
                this.$refs.fileInput.click();

                // Se o usuário cancelar o seletor nativo, libera o fechamento do modal
                setTimeout(() => {
                    if (!this.isUploading) {
                        this.isPickingFile = false;
                    }
                }, 1000);
            },

            selectImage(url) {
                if (this.currentActivatingField) {
                    this[this.currentActivatingField] = url;
                }
                this.closeGallery(true);
            },

            isActive(url) {
                if (!this.currentActivatingField) return false;
                return this[this.currentActivatingField] === url;
            },

            async handleDrop(event) {
                const files = event.dataTransfer.files;
                if (files.length > 0) {
                    await this.uploadFile(files[0]);
                }
            },

            async handleFileSelect(event) {
                const files = event.target.files;
                this.isPickingFile = false;

                if (files.length > 0) {
                    await this.uploadFile(files[0]);
                }

                event.target.value = '';
            },

            async uploadFile(file) {
                if (!file || !file.type.startsWith('image/')) {
                    this.uploadError = 'Selecione um arquivo de imagem válido.';
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    this.uploadError = 'A imagem deve ter no máximo 5MB.';
                    return;
                }

                const targetField = this.currentActivatingField;
                this.isUploading = true;
                this.uploadError = null;

                const formData = new FormData();
                formData.append('image', file);

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                try {
                    const response = await fetch('{{ route('gallery.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: formData
                    });

                    const data = await response.json().catch(() => ({}));

                    if (response.ok && data.image) {
                        this.images.unshift(data.image);

                        if (targetField) {
                            this[targetField] = data.image.url;
                        }

                        this.closeGallery(true);
                        return;
                    }

                    const validationError = data.errors?.image?.[0];
                    this.uploadError = validationError || data.message || 'Erro ao enviar a imagem. Verifique o formato e o tamanho (máx. 5MB).';
                } catch (error) {
                    this.uploadError = 'Erro na conexão. Tente novamente.';
                } finally {
                    this.isUploading = false;
                    this.isPickingFile = false;
                }
            }
        }));
    });
</script>
@endpush
