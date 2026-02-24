@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center py-10">
        <div class="w-full max-w-2xl rounded-2xl bg-white p-8 shadow-sm dark:bg-gray-800">
            <h1 class="mb-4 text-3xl font-bold text-gray-800 dark:text-white">
                Bem-vindo ao MedCare!
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Olá, <span class="font-semibold text-brand-500">{{ Auth::user()->name }}</span>! Sua conta está ativa e você já pode começar a utilizar a plataforma.
            </p>
            <div class="mt-8 border-t border-gray-100 pt-6 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-500">
                    Esta é a sua área administrativa. Em breve, novas funcionalidades estarão disponíveis aqui.
                </p>
            </div>
        </div>
    </div>
@endsection
