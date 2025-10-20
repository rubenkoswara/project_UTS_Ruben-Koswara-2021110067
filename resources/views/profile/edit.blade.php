@extends('layouts.app') 

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profile Saya') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        {{-- INDEX / RINGKASAN DATA AKUN --}}
        {{-- Class border border-gray-200 DIHILANGKAN --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            {{-- PASTIKAN TEKS HEADING HITAM --}}
            <h3 class="text-2xl font-bold mb-4 text-gray-900 border-b pb-2">Ringkasan Akun</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-lg text-gray-800">
                {{-- Pastikan Anda sudah login, jika tidak, ini akan error --}}
                <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                {{-- BARIS BARU DITAMBAHKAN DI SINI --}}
                <p><strong>No. Handphone:</strong> {{ Auth::user()->phone_number ?? '-' }}</p>
                <p><strong>Tanggal Lahir:</strong> {{ Auth::user()->date_of_birth ?? '-' }}</p>
                <p class="md:col-span-2"><strong>Alamat:</strong> {{ Auth::user()->address ?? '-' }}</p>
                
                {{-- BARIS LAMA --}}
                <p><strong>Bergabung Sejak:</strong> {{ Auth::user()->created_at->format('d F Y') }}</p>
                <p><strong>Status Akun:</strong> <span class="text-green-600 font-semibold">Aktif</span></p>
            </div>
            <p class="mt-4 text-gray-600">
                Gunakan formulir di bawah ini untuk memperbarui informasi profil Anda atau mengubah kata sandi.
            </p>
        </div>
        
        {{-- FORMULIR EDIT PROFIL --}}

        {{-- 1. Update Profile Information (Form Edit Nama dan Email) --}}
        {{-- Class border border-gray-200 DIHILANGKAN --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- 2. Update Password (Form Edit Password) --}}
        {{-- Class border border-gray-200 DIHILANGKAN --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- 3. Delete Account (Form Hapus Akun) --}}
        {{-- Class border border-gray-200 DIHILANGKAN --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
