<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard utama administrator.
     */
    public function index(): View
    {
        // Memuat view yang berisi tampilan dashboard admin
        return view('admin.dashboard'); 
    }
}
