@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <x-common.page-breadcrumb pageTitle="{{ isset($user) ? 'Editar Usuário' : 'Novo Usuário' }}" />
    </div>

    <div class="max-w-3xl">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif

                <div class="space-y-5">
                    <!-- Nome -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Nome Completo<span class="text-error-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
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
                        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('email') border-error-500 @enderror" />
                        @error('email')
                            <p class="mt-1 text-xs text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Roles -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Funções (Roles)<span class="text-error-500">*</span>
                        </label>
                        <div class="flex flex-wrap gap-4 mt-2">
                            @foreach ($roles as $role)
                                <label class="flex items-center gap-2 cursor-pointer select-none">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                        {{ (isset($userRoles) && in_array($role->name, $userRoles)) || (is_array(old('roles')) && in_array($role->name, old('roles'))) ? 'checked' : '' }}
                                        class="w-4 h-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900">
                                    <span class="text-sm text-gray-700 dark:text-gray-400">{{ $role->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('roles')
                            <p class="mt-1 text-xs text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <!-- Senha -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Senha {{ isset($user) ? '(Deixe em branco para manter)' : '' }}<span class="{{ isset($user) ? '' : 'text-error-500' }}">{{ isset($user) ? '' : '*' }}</span>
                            </label>
                            <input type="password" name="password" {{ isset($user) ? '' : 'required' }}
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 @error('password') border-error-500 @enderror" />
                            @error('password')
                                <p class="mt-1 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmar Senha -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Confirmar Senha<span class="{{ isset($user) ? '' : 'text-error-500' }}">{{ isset($user) ? '' : '*' }}</span>
                            </label>
                            <input type="password" name="password_confirmation" {{ isset($user) ? '' : 'required' }}
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a href="{{ route('users.index') }}"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:ring-3 focus:ring-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600 focus:ring-3 focus:ring-brand-500/10">
                            {{ isset($user) ? 'Salvar Alterações' : 'Criar Usuário' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
