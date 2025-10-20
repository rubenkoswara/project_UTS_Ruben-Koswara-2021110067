@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Buat Akun Pengguna Baru') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Formulir Pendaftaran Akun</h1>

            {{-- Formulir Create mengarah ke admin.users.store --}}
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                {{-- Input Nama --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Password --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Konfirmasi Password --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>

                {{-- Input Peran (is_admin) --}}
                <div class="mb-6">
                    <label for="is_admin" class="block text-sm font-medium text-gray-700">Peran Akun</label>
                    <select name="is_admin" id="is_admin" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        <option value="0" {{ old('is_admin') == 0 ? 'selected' : '' }}>Customer (Pelanggan)</option>
                        <option value="1" {{ old('is_admin') == 1 ? 'selected' : '' }}>Admin (Administrator)</option>
                    </select>
                    @error('is_admin')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                        Buat Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection