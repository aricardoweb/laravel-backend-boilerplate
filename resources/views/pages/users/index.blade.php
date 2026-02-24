@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <x-common.page-breadcrumb pageTitle="Gerenciamento de Usuários" />
        <a href="{{ route('users.create') }}"
            class="flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-brand-600">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Novo Usuário
        </a>
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

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800 text-left">
                        <th class="px-5 py-3 sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Usuário</p>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">E-mail</p>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Roles</p>
                        </th>
                        <th class="px-5 py-3 sm:px-6 text-right">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Ações</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-100 dark:border-gray-800 last:border-0">
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 overflow-hidden rounded-full bg-gray-100 flex items-center justify-center">
                                        <span class="text-gray-500 font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $user->email }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($user->roles as $role)
                                        <span class="px-2 py-0.5 rounded-full text-theme-xs font-medium bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('users.edit', $user) }}" class="text-gray-500 hover:text-brand-500 transition-colors">
                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.1667 2.50004C14.3856 2.28113 14.6454 2.10748 14.9313 1.98901C15.2173 1.87053 15.5238 1.80957 15.8333 1.80957C16.1429 1.80957 16.4494 1.87053 16.7353 1.98901C17.0213 2.10748 17.2811 2.28113 17.5 2.50004C17.7189 2.71894 17.8926 2.97873 18.011 3.26469C18.1295 3.55065 18.1905 3.85717 18.1905 4.16671C18.1905 4.47624 18.1295 4.78276 18.011 5.06872C17.8926 5.35469 17.7189 5.61447 17.5 5.83337L6.25002 17.0834L1.66669 18.3334L2.91669 13.75L14.1667 2.50004Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <x-ui.confirm-modal
                                            title="Excluir Usuário"
                                            message="Tem certeza que deseja excluir o usuário {{ $user->name }}? Esta ação não pode ser desfeita."
                                            confirmText="Sim, excluir"
                                            action="{{ route('users.destroy', $user) }}"
                                            overrideMethod="DELETE"
                                        >
                                            <button type="button" class="text-gray-500 outline-none hover:text-error-500 focus:text-error-500 transition-colors">
                                                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.8333 5.83333L15.1111 15.9444C15.0483 16.8242 14.3164 17.5 13.4346 17.5H6.5654C5.68361 17.5 4.95171 16.8242 4.88889 15.9444L4.16667 5.83333M8.33333 9.16667V14.1667M11.6667 9.16667V14.1667M13.3333 5.83333V4.16667C13.3333 3.24619 12.5871 2.5 11.6667 2.5H8.33333C7.41286 2.5 6.66667 3.24619 6.66667 4.16667V5.83333M3.33333 5.83333H16.6667" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </x-ui.confirm-modal>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $users->links() }}
        </div>
    </div>
@endsection
