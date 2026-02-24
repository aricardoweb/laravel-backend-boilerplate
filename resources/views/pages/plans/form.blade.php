@extends('layouts.app', ['title' => isset($plan) ? 'Editar Plano' : 'Novo Plano'])

@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ isset($plan) ? 'Editar Plano' : 'Novo Plano' }}</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ isset($plan) ? 'Atualize as informações do plano.' : 'Preencha os dados abaixo para criar um novo plano.' }}
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('plans.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                Voltar
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-error-200 bg-error-50 p-4 text-error-800 dark:border-error-900/50 dark:bg-error-900/20 dark:text-error-400">
            <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-error-600 dark:text-error-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-medium">Foram encontrados os seguintes erros:</h3>
                    <ul class="mt-2 list-inside list-disc text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <form action="{{ isset($plan) ? route('plans.update', $plan) : route('plans.store') }}" method="POST" class="p-6">
            @csrf
            @if(isset($plan))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                
                <!-- Nome -->
                <div class="space-y-2 lg:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nome do Plano <span class="text-error-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $plan->name ?? '') }}" required
                        class="block w-full rounded-lg border-gray-300 px-4 py-2.5 text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-brand-500 @error('name') border-error-500 focus:border-error-500 focus:ring-error-500 @enderror"
                        placeholder="Ex: Premium">
                </div>


                <!-- Preço -->
                <div class="space-y-2">
                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Preço Mensal (R$) <span class="text-error-500">*</span>
                    </label>
                    <div class="relative rounded-lg shadow-sm" x-data="currencyMask('{{ old('price', isset($plan) ? number_format($plan->price, 2, ',', '.') : '') }}')">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <span class="text-gray-500 sm:text-sm">R$</span>
                        </div>
                        <input type="text" name="price" id="price" x-model="value" @input="format" required
                            class="block w-full rounded-lg border-gray-300 pl-11 pr-4 py-2.5 text-gray-900 transition-colors focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-brand-500 @error('price') border-error-500 focus:border-error-500 focus:ring-error-500 @enderror"
                            placeholder="0,00">
                    </div>
                </div>

                <!-- Validade (Texto) -->
                <div class="space-y-2">
                    <label for="credit_validity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Validade do Crédito (Texto) <span class="text-error-500">*</span>
                    </label>
                    <input type="text" name="credit_validity" id="credit_validity" value="{{ old('credit_validity', $plan->credit_validity ?? '') }}" required
                        class="block w-full rounded-lg border-gray-300 px-4 py-2.5 text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-brand-500 @error('credit_validity') border-error-500 focus:border-error-500 focus:ring-error-500 @enderror"
                        placeholder="Ex: 6 meses">
                </div>

                <!-- Validade (Meses Inteiro) -->
                <div class="space-y-2">
                    <label for="credit_validity_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Validade do Crédito (Meses) <span class="text-error-500">*</span>
                    </label>
                    <input type="number" min="0" step="1" name="credit_validity_months" id="credit_validity_months" value="{{ old('credit_validity_months', $plan->credit_validity_months ?? '') }}" required
                        class="block w-full rounded-lg border-gray-300 px-4 py-2.5 text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-brand-500 @error('credit_validity_months') border-error-500 focus:border-error-500 focus:ring-error-500 @enderror"
                        placeholder="Ex: 6">
                </div>

                <!-- Features (Dinâmico com Alpine JS) -->
                @php
                    $initialFeatures = old('features', isset($plan) && $plan->features ? $plan->features : ['']);
                    // Garantir que seja array literal para JS
                    $initialFeaturesJson = json_encode(array_values($initialFeatures));
                @endphp
                
                <div class="space-y-2 md:col-span-2 lg:col-span-3" x-data="featuresManager({{ $initialFeaturesJson }})">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Benefícios do Plano (Features)
                    </label>
                    <div class="space-y-3">
                        <template x-for="(feature, index) in features" :key="index">
                            <div class="flex items-center gap-2">
                                <input type="text" x-model="features[index]" :name="`features[${index}]`"
                                    class="block w-full rounded-lg border-gray-300 px-4 py-2.5 text-gray-900 shadow-sm transition-colors focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-brand-500"
                                    placeholder="Ex: Descontos em Exames">
                                
                                <button type="button" @click="removeFeature(index)" class="p-2 text-gray-400 hover:text-red-500 focus:outline-none" title="Remover benefício">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    
                    <button type="button" @click="addFeature()" class="mt-3 inline-flex items-center gap-1.5 text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Adicionar Benefício
                    </button>
                    <p class="text-xs text-gray-500 mt-1">Esses itens aparecerão como pontos fortes na interface da API.</p>
                </div>
                
                <hr class="md:col-span-2 lg:col-span-3 border-gray-100 dark:border-gray-800 my-4" />

                <!-- Configurações Adicionais -->
                <div class="space-y-4 md:col-span-2 lg:col-span-3 pb-6">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Opções de Exibição</h4>
                    
                    <div class="flex items-center gap-3">
                        <div class="flex h-6 items-center">
                            <input type="checkbox" name="recommended" id="recommended" value="1" {{ old('recommended', $plan->recommended ?? false) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-600 dark:border-gray-700 dark:bg-gray-800 dark:ring-offset-gray-900">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="recommended" class="font-medium text-gray-900 dark:text-white">Destacar como Recomendado</label>
                            <p class="text-gray-500 dark:text-gray-400">Ative para destacar este plano na tela principal de preços.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex h-6 items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $plan->is_active ?? true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-600 dark:border-gray-700 dark:bg-gray-800 dark:ring-offset-gray-900">
                        </div>
                        <div class="text-sm leading-6">
                            <label for="is_active" class="font-medium text-gray-900 dark:text-white">Plano Ativo</label>
                            <p class="text-gray-500 dark:text-gray-400">Quando inativo, o plano não será retornado na API pública.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                <a href="{{ route('plans.index') }}" class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors shadow-sm shadow-brand-500/20">
                    {{ isset($plan) ? 'Atualizar Plano' : 'Criar Plano' }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('featuresManager', (initialFeatures) => ({
            features: initialFeatures.length > 0 ? initialFeatures : [''],
            
            addFeature() {
                this.features.push('');
            },
            
            removeFeature(index) {
                if (this.features.length > 1) {
                    this.features.splice(index, 1);
                } else {
                    this.features[0] = '';
                }
            }
        }));

        Alpine.data('currencyMask', (initialValue = '') => ({
            value: initialValue,
            format() {
                let val = this.value;
                val = val.replace(/\D/g, "");
                val = (val / 100).toFixed(2) + "";
                val = val.replace(".", ",");
                val = val.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
                val = val.replace(/(\d)(\d{3}),/g, "$1.$2,");
                this.value = val;
            },
            init() {
                if (this.value) {
                    // Try to format existing value if passed (e.g. from backend float)
                    let num = parseFloat(this.value.replace(/\./g, '').replace(',', '.'));
                    if(!isNaN(num)){
                         this.value = num.toFixed(2).replace('.', ',');
                         this.format();
                    }
                }
            }
        }));
    });
</script>
@endpush
