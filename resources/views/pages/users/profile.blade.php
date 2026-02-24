@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <x-common.page-breadcrumb pageTitle="Meu Perfil" />
    </div>

    <div class="max-w-3xl">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <!-- Nome -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Nome Completo<span class="text-error-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('name') border-error-500 @enderror" />
                        @error('name')
                            <p class="mt-1 text-xs text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- E-mail -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            E-mail<span class="text-error-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('email') border-error-500 @enderror" />
                        @error('email')
                            <p class="mt-1 text-xs text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-gray-100 dark:border-gray-800">

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <!-- Senha -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nova Senha (Opcional)
                            </label>
                            <input type="password" name="password"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 @error('password') border-error-500 @enderror" />
                            @error('password')
                                <p class="mt-1 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmar Senha -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Confirmar Nova Senha
                            </label>
                            <input type="password" name="password_confirmation"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="submit"
                            class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600 focus:ring-3 focus:ring-brand-500/10">
                            Salvar Alterações
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
