<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    {{-- Hapus kelas dark: dari body --}}
    <body class="font-sans text-gray-900 antialiased">
        {{-- Mengatur latar belakang halaman menjadi abu-abu muda bersih (bg-gray-100) --}}
        {{-- PERBAIKAN SPASI: Menghapus sm:justify-center dan menambahkan pt-20 (padding top) untuk menaikkan posisi kartu formulir. --}}
        <div class="min-h-screen flex flex-col items-center pt-20 sm:pt-20 bg-gray-100">
            {{-- LOGO TELAH DIHAPUS SEPENUHNYA DARI SINI --}}

            {{-- Mengatur kontainer kartu formulir menjadi putih bersih --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-xl overflow-hidden sm:rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
