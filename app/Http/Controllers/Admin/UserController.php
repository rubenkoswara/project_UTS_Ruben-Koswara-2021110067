<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Mengambil data dari Model User
use Illuminate\Http\Request;
use Illuminate\View\View; // Untuk return view
use Illuminate\Http\RedirectResponse; // Untuk return redirect
use Illuminate\Support\Facades\Hash; // Untuk hashing password

class UserController extends Controller
{
    /**
     * READ: Menampilkan daftar (listing) semua pengguna dari database.
     */
    public function index(): View
    {
        // Ambil semua pengguna, diurutkan berdasarkan peran (admin di atas)
        $users = User::orderBy('is_admin', 'desc')->get(); 
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * CREATE VIEW: Menampilkan formulir untuk membuat pengguna baru.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * CREATE STORE: Menyimpan pengguna baru di database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Harus cocok dengan field password_confirmation
            'is_admin' => 'required|boolean',
        ]);

        // 2. Buat Pengguna
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Wajib di-hash
            'is_admin' => $request->is_admin,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Akun pengguna baru berhasil dibuat!');
    }

    /**
     * UPDATE VIEW: Menampilkan formulir untuk mengedit pengguna yang ditentukan.
     * Menggunakan Eloquent Model Binding: $user otomatis diisi berdasarkan ID di URL.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * UPDATE STORE: Memperbarui pengguna yang ditentukan di database.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            // Validasi unik email, tetapi abaikan email saat ini
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, 
            'is_admin' => 'required|boolean',
            // Password hanya jika diisi
            'password' => 'nullable|string|min:8|confirmed', 
        ]);
        
        $data = $request->only(['name', 'email', 'is_admin']);

        // 2. Tangani Pembaruan Password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 3. Update Data
        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * DELETE: Menghapus pengguna dari database.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Pencegahan: Admin tidak boleh menghapus akunnya sendiri
        if (auth()->user()->id === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

}