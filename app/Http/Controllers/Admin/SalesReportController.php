<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Response;

use Barryvdh\DomPDF\Facade\Pdf;




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
        // Tetapkan waktu lokal saat ini untuk data dummy
        Carbon::setLocale('id');

        return collect([
            // Data dummy penjualan Selesai (Completed Sales)
            ['id' => 'ORD-001', 'customer' => 'Adi Pradana', 'total' => 571000, 'date' => '2025-10-18', 'status' => 'Selesai'],
            ['id' => 'ORD-002', 'customer' => 'Budi Santoso', 'total' => 847700, 'date' => '2025-10-21', 'status' => 'Selesai'], // Hari ini
            ['id' => 'ORD-003', 'customer' => 'Citra Dewi', 'total' => 150000, 'date' => '2025-10-19', 'status' => 'Selesai'],
            ['id' => 'ORD-004', 'customer' => 'Dian Kurnia', 'total' => 260000, 'date' => '2025-10-19', 'status' => 'Selesai'],
            ['id' => 'ORD-005', 'customer' => 'Eko Nurcahyo', 'total' => 420000, 'date' => '2025-10-20', 'status' => 'Selesai'],
            ['id' => 'ORD-007', 'customer' => 'Galih Prakasa', 'total' => 650000, 'date' => '2025-10-15', 'status' => 'Selesai'],
            ['id' => 'ORD-008', 'customer' => 'Hana Wijaya', 'total' => 310000, 'date' => '2025-10-16', 'status' => 'Selesai'],
            ['id' => 'ORD-009', 'customer' => 'Irfan Hakim', 'total' => 990000, 'date' => '2025-10-17', 'status' => 'Selesai'],
            ['id' => 'ORD-010', 'customer' => 'Joko Susilo', 'total' => 200000, 'date' => '2025-10-20', 'status' => 'Selesai'],
            ['id' => 'ORD-011', 'customer' => 'Kevin Tan', 'total' => 120000, 'date' => '2025-09-25', 'status' => 'Selesai'], // Bulan lalu
            
            // Data order lain (Misalnya status Dikirim)
            ['id' => 'ORD-006', 'customer' => 'Fani Lestari', 'total' => 120000, 'date' => '2025-10-20', 'status' => 'Dikirim'],
        ])->map(function ($sale) {
            // Pastikan kolom 'date' dalam format Carbon untuk perbandingan
            $sale['date'] = Carbon::parse($sale['date']);
            return $sale;
        });
    }

    /**
     * Helper untuk menentukan rentang tanggal
     */
    private function calculateDateRange(string $filter): array
    {
        $now = Carbon::now();
        $start_date = null;
        $end_date = null;

        if ($filter === 'today') {
            $start_date = $now->copy()->startOfDay();
            $end_date = $now->copy()->endOfDay();
        } elseif ($filter === 'weekly') {
            // Minggu ini, dari Senin hingga sekarang/akhir hari ini
            $start_date = $now->copy()->startOfWeek();
            $end_date = $now->copy()->endOfDay();
        } elseif ($filter === 'monthly') {
            // Bulan ini, dari tanggal 1 hingga sekarang/akhir hari ini
            $start_date = $now->copy()->startOfMonth();
            $end_date = $now->copy()->endOfDay();
        }
        // Jika 'all', biarkan null

        // Pastikan tanggal diformat sebagai string Y-m-d untuk konsistensi di view/export
        return [
            'start_date' => $start_date ? $start_date->toDateString() : null,
            'end_date' => $end_date ? $end_date->toDateString() : null,
        ];
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
        $range = $this->calculateDateRange($filter);

        $completed_sales = $allSales->filter(fn($s) => $s['status'] === 'Selesai');
        
        // 2. Filter berdasarkan rentang tanggal yang didapat
        $filtered_sales = $completed_sales->filter(function ($sale) use ($range) {
            if (!$range['start_date'] || !$range['end_date']) {
                return true; // Filter 'all'
            }

            $date = $sale['date'];
            $start = Carbon::parse($range['start_date'])->startOfDay();
            $end = Carbon::parse($range['end_date'])->endOfDay();

            return $date->between($start, $end);
        })->values();

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
            'sales' => $sales_data_formatted,
            'raw_data' => $filtered_sales->toArray(),
            'total_revenue' => 'Rp ' . number_format($total_revenue, 0, ',', '.'),
            'total_orders' => $total_orders,
            'average_sale' => 'Rp ' . number_format($average_sale, 0, ',', '.'),
            'start_date' => $range['start_date'],
            'end_date' => $range['end_date'],
        ];
    }
    
    /**
     * Menampilkan halaman utama laporan penjualan.
     * @param Request $request
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
            'filter' => $filter, 
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ]);
    }

    /**
     * Export Laporan Penjualan ke format Excel (simulasi menggunakan CSV).
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportExcel(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $data = $this->getFilteredSalesData($filter);
        $exportData = $data['raw_data'];
        
        $range = $this->calculateDateRange($filter);
        $fileNameSuffix = $range['start_date'] && $range['end_date'] 
                        ? $range['start_date'] . '_to_' . $range['end_date'] 
                        : 'AllData';
                        
        $fileName = 'LaporanPenjualan_' . $fileNameSuffix . '_' . Carbon::now()->format('Ymd_His') . '.csv';
        
        // 1. Siapkan header CSV
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        // 2. Siapkan konten CSV
        $callback = function() use ($exportData)
        {
            $file = fopen('php://output', 'w');
            
            // Kolom Header
            fputcsv($file, ['No. Order', 'Tanggal', 'Customer', 'Total Penjualan', 'Status']);

            // Isi Data
            foreach ($exportData as $sale) {
                fputcsv($file, [
                    $sale['id'],
                    $sale['date']->toDateString(), // Gunakan tanggal mentah untuk export
                    $sale['customer'],
                    $sale['total'], // Gunakan total mentah (angka)
                    $sale['status']
                ]);
            }
            fclose($file);
        };

        // 3. Kembalikan respons stream
        return response()->stream($callback, 200, $headers);
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
        $exportData = $data['sales']; 
        
        $range = $this->calculateDateRange($filter);
        $fileNameSuffix = $range['start_date'] && $range['end_date'] 
                        ? $range['start_date'] . '_to_' . $range['end_date'] 
                        : 'AllData';
                        
        $fileName = 'LaporanPenjualan_' . $fileNameSuffix . '_' . Carbon::now()->format('Ymd_His') . '.pdf';

        // ------------------------------------------------------------------------
        // IMPLEMENTASI NYATA DENGAN DOMPDF (DIASUMSIKAN PACKAGE SUDAH TERINSTAL)
        // ------------------------------------------------------------------------
        
        $pdf = Pdf::loadView('exports.sales_pdf', [
            'sales' => $exportData,
            'total_revenue' => $data['total_revenue'],
            'total_orders' => $data['total_orders'],
            'filter_label' => ucfirst($filter),
            'start_date' => $range['start_date'],
            'end_date' => $range['end_date']
        ]);

        // 2. Return the PDF file as a download
        return $pdf->download($fileName); 
    

        // ------------------------------------------------------------------------
        // SIMULASI KETIKA DOMPDF BELUM TERINSTAL (Mengembalikan Response Kosong PDF)
        // ------------------------------------------------------------------------
        
        // Membuat respons kosong dengan header PDF
        $count = count($exportData);
        $content = "%PDF-1.4\n%DUMMY PDF CONTENT\n"; // Konten minimal untuk file PDF
        
        return response($content)
            ->withHeaders([
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"$fileName\"",
                'Content-Length' => strlen($content),
            ])
            ->with('success', "Sukses! **$count** baris data penjualan periode **" . ucfirst($filter) . "** ($fileNameSuffix) siap dibuat sebagai PDF ($fileName).");
    }
}