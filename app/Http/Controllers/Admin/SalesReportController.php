<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

// use Maatwebsite\Excel\Facades\Excel; // Baris ini dan baris import package di bawah dihapus atau dibiarkan sebagai komentar sesuai permintaan user.
// use App\Exports\SalesExport; 
// use Barryvdh\DomPDF\Facade\Pdf; 

class SalesReportController extends Controller
{
    /**
     * Helper function untuk mendapatkan semua data dummy penjualan mentah.
     * Dalam proyek nyata, ini akan mengambil data dari Model/Eloquent.
     *
     * @return Collection
     */
    private function getRawSalesData(): Collection
    {
        return collect([
            // Data dummy penjualan Selesai (Completed Sales)
            ['id' => 'ORD-001', 'customer' => 'Adi Pradana', 'total' => 571000, 'date' => '2025-10-18', 'status' => 'Selesai'],
            ['id' => 'ORD-002', 'customer' => 'Budi Santoso', 'total' => 847700, 'date' => '2025-10-18', 'status' => 'Selesai'],
            ['id' => 'ORD-003', 'customer' => 'Citra Dewi', 'total' => 150000, 'date' => '2025-10-19', 'status' => 'Selesai'],
            ['id' => 'ORD-004', 'customer' => 'Dian Kurnia', 'total' => 260000, 'date' => '2025-10-19', 'status' => 'Selesai'],
            ['id' => 'ORD-005', 'customer' => 'Eko Nurcahyo', 'total' => 420000, 'date' => '2025-10-20', 'status' => 'Selesai'],
            ['id' => 'ORD-007', 'customer' => 'Galih Prakasa', 'total' => 650000, 'date' => '2025-10-15', 'status' => 'Selesai'],
            ['id' => 'ORD-008', 'customer' => 'Hana Wijaya', 'total' => 310000, 'date' => '2025-10-16', 'status' => 'Selesai'],
            ['id' => 'ORD-009', 'customer' => 'Irfan Hakim', 'total' => 990000, 'date' => '2025-10-17', 'status' => 'Selesai'],
            ['id' => 'ORD-010', 'customer' => 'Joko Susilo', 'total' => 200000, 'date' => '2025-10-20', 'status' => 'Selesai'],
            
            // Data order lain (Misalnya status Dikirim)
            ['id' => 'ORD-006', 'customer' => 'Fani Lestari', 'total' => 120000, 'date' => '2025-10-20', 'status' => 'Dikirim'],
        ])->map(function ($sale) {
            // Pastikan kolom 'date' dalam format Carbon untuk perbandingan
            $sale['date'] = Carbon::parse($sale['date']);
            return $sale;
        });
    }

    /**
     * Mengambil data penjualan yang sudah difilter berdasarkan status 'Selesai' dan periode,
     * lalu menghitung statistik yang diperlukan.
     *
     * @param string $filter 'today', 'weekly', 'monthly', 'all'
     * @return array
     */
    private function getFilteredSalesData(string $filter): array
    {
        $allSales = $this->getRawSalesData();
        
        // 1. Filter hanya data penjualan yang statusnya 'Selesai'
        $completed_sales = $allSales->filter(fn($s) => $s['status'] === 'Selesai');
        
        // 2. Filter berdasarkan periode waktu
        $filtered_sales = $completed_sales->filter(function ($sale) use ($filter) {
            $date = $sale['date'];
            
            if ($filter === 'today') {
                return $date->isToday();
            } elseif ($filter === 'weekly') {
                // Dianggap dari hari Senin hingga hari ini
                return $date->between(Carbon::now()->startOfWeek(), Carbon::now()->endOfDay());
            } elseif ($filter === 'monthly') {
                return $date->isCurrentMonth();
            }
            return true; // 'all'
        })->values(); // Reset keys setelah filtering

        // 3. Hitung Statistik
        $total_revenue = $filtered_sales->sum('total');
        $total_orders = $filtered_sales->count();
        $average_sale = $total_orders > 0 ? $total_revenue / $total_orders : 0;

        // 4. Format Data untuk Tampilan (View)
        $sales_data_formatted = $filtered_sales->map(function ($sale) {
            $sale['total_formatted'] = 'Rp ' . number_format($sale['total'], 0, ',', '.');
            // Menggunakan translatedFormat agar tanggal/bulan sesuai bahasa lokal
            $sale['date_formatted'] = $sale['date']->translatedFormat('d F Y'); 
            return $sale;
        });

        return [
            'sales' => $sales_data_formatted, // Data yang diformat untuk ditampilkan di View
            'raw_data' => $filtered_sales->toArray(), // Data mentah untuk export (jika diperlukan)
            'total_revenue' => 'Rp ' . number_format($total_revenue, 0, ',', '.'),
            'total_orders' => $total_orders,
            'average_sale' => 'Rp ' . number_format($average_sale, 0, ',', '.'),
        ];
    }
    
    /**
     * Menampilkan halaman utama laporan penjualan.
     * * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'monthly'); 
        
        $data = $this->getFilteredSalesData($filter);

        return view('admin.sales_report', [
            'sales' => $data['sales'],
            'total_revenue' => $data['total_revenue'],
            'total_orders' => $data['total_orders'],
            'average_sale' => $data['average_sale'],
            'filter' => $filter, // Kirim filter kembali ke view untuk mempertahankan pilihan
        ]);
    }

    /**
     * Export Laporan Penjualan ke format Excel (.xlsx).
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportExcel(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $data = $this->getFilteredSalesData($filter);
        $fileName = 'LaporanPenjualan_' . ucfirst($filter) . '_' . Carbon::now()->format('Ymd_His') . '.xlsx';

        // Ganti baris di bawah ini dengan implementasi export Excel yang sesungguhnya (misal menggunakan package Maatwebsite)
        $count = count($data['raw_data']);
        return back()->with('success', "Sukses! $count baris data penjualan periode " . ucfirst($filter) . " siap diunduh sebagai Excel ($fileName).");
    }

    /**
     * Export Laporan Penjualan ke format PDF (.pdf).
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportPdf(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $data = $this->getFilteredSalesData($filter);
        $fileName = 'LaporanPenjualan_' . ucfirst($filter) . '_' . Carbon::now()->format('Ymd_His') . '.pdf';

        // Ganti baris di bawah ini dengan implementasi export PDF yang sesungguhnya (misal menggunakan package DomPDF)
        $count = count($data['raw_data']);
        return back()->with('success', "Sukses! $count baris data penjualan periode " . ucfirst($filter) . " siap dibuat sebagai PDF ($fileName).");
    }
}
